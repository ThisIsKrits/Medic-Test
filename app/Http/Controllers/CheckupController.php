<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckUpRequest;
use App\Repositories\CheckupRepository;
use App\Services\CheckupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckupController extends Controller
{
    protected $title = 'Pemeriksaan';
    protected $repo;
    protected $service;

    public function __construct(CheckupRepository $repo, CheckupService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('dashboard.checkup.index', [
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
        return view('dashboard.checkup.create', [
            'title' => $this->title,
            'formFields' => $this->repo->formField(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckupRequest $request)
    {
          try {
            DB::beginTransaction();

            $data = $this->service->setData($request->all());
            $data['no'] = $this->service->lastCode();
            $store = $this->service->store($data);

            $this->service->saveDataDetail($store, $request->all());
            $this->service->saveDataDocument($store, $request->all());

            $message = $store->no.' telah terdaftar sebagai data '.$this->title;

            DB::commit();

            return redirect()
                    ->route('checkup.index')
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
        return view('dashboard.checkup.show', [
            'item' => $this->repo->findById($id),
            'fields' => $this->repo->modelField(),
            'detailFields' => $this->repo->modelDetailField(),
            'docFields' => $this->repo->modelDocumentField(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.checkup.edit', [
            'item'       => $this->repo->findById($id),
            'formFields' => $this->repo->formField(),
            'title'      => $this->title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckUpRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = $this->repo->findById($id);
            $data = $this->service->setData($request->all());
            $item = $this->service->update($item, $data);

            $details = $item->vitalSign->keyBy('id');
            $doc = $item->checkupFile->keyBy('id');
            $this->service->saveDataDetail($item, $request->all(), $details);
            $this->service->saveDataDocument($item, $request->all(), $doc);

            DB::commit();

            $message = $item->nama.' telah diupdate';
            return redirect()
                    ->route('checkup.index')
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

            return redirect()->route('checkup.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }
}
