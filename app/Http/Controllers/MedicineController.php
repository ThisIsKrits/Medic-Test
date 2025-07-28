<?php

namespace App\Http\Controllers;

use App\Repositories\MedicineRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MedicineController extends Controller
{
    protected $email = 'rarief62@gmail.com';
    protected $password = '083878063646';
    protected $title = 'Obat';
    protected $repo;
    protected $service;

    public function __construct(MedicineRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return view('dashboard.medicine.index', [
            'title' => $this->title,
            'items' => $this->repo->dataIndex(request()),
        ]);
    }
}
