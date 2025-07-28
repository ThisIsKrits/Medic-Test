<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Repositories\PatientRepository;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    protected $title = 'Pasien';
    protected $repo;
    protected $service;

    public function __construct(PatientRepository $repo, PatientService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('dashboard.patient.index', [
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
        return view('dashboard.patient.create', [
            'title' => $this->title,
            'formFields' => $this->repo->formField(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
         try {
            DB::beginTransaction();

            $data = $this->service->setData($request->validated());
            $store = $this->service->store($data);
            $message = $store->name.' telah terdaftar sebagai data '.$this->title;

            DB::commit();

            return redirect()
                    ->route('patient.index')
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
        return view('dashboard.patient.show', [
            'item' => $this->repo->findById($id),
            'fields' => $this->repo->modelField(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.patient.edit', [
            'item'       => $this->repo->findById($id),
            'formFields' => $this->repo->formField(),
            'title'      => $this->title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, string $id)
    {
         try {
            DB::beginTransaction();

            $item = $this->repo->findById($id);
            $data = $this->service->setData($request->all());
            $item = $this->service->update($item, $data);

            DB::commit();

            $message = $item->name.' telah diupdate';
            return redirect()
                    ->route('patient.index')
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

            return redirect()->route('patient.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }
}
