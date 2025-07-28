<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class LogController extends Controller
{

    protected $title = 'Log';
    public function index()
    {
        $items = Audit::with('user')->latest()->paginate(10);

        return view('dashboard.log.index',[
            'items' => $items,
            'title' => $this->title
        ]);
    }
}
