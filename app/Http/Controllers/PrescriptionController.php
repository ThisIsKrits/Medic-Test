<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrescriptionRequest;
use App\Models\Prescription;
use App\Repositories\PrescriptionRepository;
use App\Services\PrescriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    protected $title = 'Resep';
    protected $repo;
    protected $service;

    public function __construct(PrescriptionRepository $repo, PrescriptionService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('dashboard.prescription.index', [
            'title' => $this->title,
            'fields' => $this->repo->modelField(),
            'items' => $this->repo->dataIndex(request()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.prescription.create', [
            'title' => $this->title,
            'formFields' => $this->repo->formField(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionRequest $request)
    {
          try {
            DB::beginTransaction();

            $data = $this->service->setData($request->all());
            $data['no'] = $this->service->lastCode();
            $store = $this->service->store($data);

            $this->service->saveDataDetail($store, $request->all());

            $message = $store->no.' telah terdaftar sebagai data '.$this->title;

            DB::commit();

            return redirect()
                    ->route('prescription.index')
                    ->withSuccess($message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.prescription.show', [
            'item' => $this->repo->findById($id),
            'fields' => $this->repo->modelField(),
            'detailFields' => $this->repo->modelDetailField(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Prescription::find($id);

        if ($item->status == 2) {
            $message = "Resep {$item->no} tidak bisa diedit karena sudah dilayani.";

            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $message
                ], 403);
            }

            return redirect()
                ->route('prescription.index')
                ->with('error', $message);
        }

        return view('dashboard.prescription.edit', [
            'item'       => $this->repo->findById($id),
            'formFields' => $this->repo->formField(),
            'title'      => $this->title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = $this->repo->findById($id);
            $data = $this->service->setData($request->all());
            $item = $this->service->update($item, $data);

            $details = $item->prescriptionItems->keyBy('id');
            $this->service->saveDataDetail($item, $request->all(), $details);

            DB::commit();

            $message = $item->no.' telah diupdate';
            return redirect()
                    ->route('prescription.index')
                    ->withSuccess($message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            DB::beginTransaction();

            $item = $this->repo->findById($id);
            $this->service->destroy($item);

            DB::commit();

            return redirect()->route('prescription.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }
}
