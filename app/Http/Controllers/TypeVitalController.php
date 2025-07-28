<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeVitalRequest;
use App\Repositories\TypeVitalRepository;
use App\Services\TypeVitalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeVitalController extends Controller
{
    protected $title = 'Tanda Vital';
    protected $repo;
    protected $service;

    public function __construct(TypeVitalRepository $repo, TypeVitalService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('dashboard.type-vital.index', [
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
        return view('dashboard.type-vital.create', [
            'title' => $this->title,
            'formFields' => $this->repo->formField(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeVitalRequest $request)
    {
         try {
            DB::beginTransaction();

            $data = $this->service->setData($request->validated());
            $store = $this->service->store($data);
            $message = $store->name.' telah terdaftar sebagai data '.$this->title;

            DB::commit();

            return redirect()
                    ->route('type-vital.index')
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
        return view('dashboard.type-vital.show', [
            'item' => $this->repo->findById($id),
            'fields' => $this->repo->modelField(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.type-vital.edit', [
            'item'       => $this->repo->findById($id),
            'formFields' => $this->repo->formField(),
            'title'      => $this->title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeVitalRequest $request, string $id)
    {
         try {
            DB::beginTransaction();

            $item = $this->repo->findById($id);
            $data = $this->service->setData($request->all());
            $item = $this->service->update($item, $data);

            DB::commit();

            $message = $item->name.' telah diupdate';
            return redirect()
                    ->route('type-vital.index')
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

            return redirect()->route('type-vital.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage())->withInput();
        }
    }
}
