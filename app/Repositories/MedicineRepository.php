<?php

namespace App\Repositories;

use App\Enums\AktifEnum;
use App\Enums\GenderEnum;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class MedicineRepository
{
    protected string $email = 'rarief62@gmail.com';
    protected string $password = '083878063646';
    protected string $baseUrl = 'http://recruitment.rsdeltasurya.com/api/v1';

    protected function authenticate(): string
    {
        $response = Http::post("{$this->baseUrl}/auth", [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Gagal autentikasi ke API.');
    }

    public function dataIndex($request = false)
    {
        $token = $this->authenticate();

        $medicineResponse = Http::withToken($token)
            ->get("{$this->baseUrl}/medicines");

        if (!$medicineResponse->successful()) {
            throw new \Exception('Gagal mengambil daftar obat.');
        }

        $medicines = $medicineResponse->json()['medicines'];

        // Gabungkan dengan harga masing-masing
        foreach ($medicines as &$medicine) {
            $medicineId = $medicine['id'];

            $priceResponse = Http::withToken($token)
                ->get("{$this->baseUrl}/medicines/{$medicineId}/prices");

            $medicine['prices'] = $priceResponse->successful()
                ? $priceResponse->json()['prices']
                : [];
        }

        // Filter manual jika ada pencarian
        if ($request && $request->search) {
            $search = strtolower($request->search);
            $medicines = array_filter($medicines, function ($item) use ($search) {
                return str_contains(strtolower($item['name']), $search);
            });
        }

        $medicines = array_values($medicines); // reset index array

        $perPage = 4;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $offset = ($currentPage - 1) * $perPage;

        $pagedData = array_slice($medicines, $offset, $perPage);
        $paginator = new LengthAwarePaginator(
            $pagedData,
            count($medicines),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginator;
    }

    public function dataHelper($request = false)
    {
        $token = $this->authenticate();

        $medicineResponse = Http::withToken($token)
            ->get("{$this->baseUrl}/medicines");

        if (!$medicineResponse->successful()) {
            throw new \Exception('Gagal mengambil daftar obat.');
        }

        $medicines = $medicineResponse->json()['medicines'];

        // Gabungkan dengan harga masing-masing
        foreach ($medicines as &$medicine) {
            $medicineId = $medicine['id'];

            $priceResponse = Http::withToken($token)
                ->get("{$this->baseUrl}/medicines/{$medicineId}/prices");

            $medicine['prices'] = $priceResponse->successful()
                ? $priceResponse->json()['prices']
                : [];
        }

        // Filter manual jika ada pencarian
        if ($request && $request->search) {
            $search = strtolower($request->search);
            $medicines = array_filter($medicines, function ($item) use ($search) {
                return str_contains(strtolower($item['name']), $search);
            });
        }

        $medicines = array_values($medicines); // reset index array

        return $medicines;
    }

    public function findById($id)
    {
        return Patient::findOrFail($id);
    }

}
