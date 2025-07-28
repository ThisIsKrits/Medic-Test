<?php

use App\Enums\AktifEnum;
use App\Models\Checkup;
use App\Models\Patient;
use App\Models\TypeVital;
use App\Repositories\MedicineRepository;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

if (!function_exists('patients')) {
    function patients()
    {
        return Patient::byStatus(AktifEnum::AKTIF)
            ->get()
            ->pluck('name', 'id');
    }
}

if (!function_exists('roles')) {
    function roles()
    {
        return Role::where('name', '!=', 'superadmin')
            ->pluck('name', 'id');
    }
}

if (!function_exists('typeVital')) {
    function typeVital()
    {
        return TypeVital::get()
            ->pluck('name', 'id');
    }
}

if (!function_exists('checkup')) {
    function checkup()
    {
        return Checkup::get()
            ->pluck('no', 'id');
    }
}

if (!function_exists('select_medic')) {
    function select_medic($s = false)
    {
        try {
            $repo = new MedicineRepository();
            $data = $repo->dataHelper(request());

            $today = Carbon::now()->format('Y-m-d');
            $html = default_option_select();

            foreach ($data as $item) {
                $sel = ($s && $s == $item['name']) ? 'selected' : '';

                $activePrice = 0;

                foreach ($item['prices'] ?? [] as $price) {
                    $start = $price['start_date']['value'] ?? null;
                    $end   = $price['end_date']['value'] ?? null;

                    if ($start && $end && $start <= $today && $today <= $end) {
                        $activePrice = $price['unit_price'];
                        break;
                    }
                }

                if (!$activePrice && !empty($item['prices'])) {
                    usort($item['prices'], function ($a, $b) {
                        return strtotime($b['end_date']['value']) <=> strtotime($a['end_date']['value']);
                    });
                    $activePrice = $item['prices'][0]['unit_price'] ?? 0;
                }

                $html .= '<option
                    value="'.$item['name'].'"
                    ref-price="'.human_number($activePrice).'"
                    '.$sel.'>'
                    .$item['name'].
                '</option>';
            }

            return $html;

        } catch (\Exception $e) {
            return default_option_select(); // fallback jika gagal
        }
    }
}

