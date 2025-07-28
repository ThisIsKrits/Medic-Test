<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\CheckupFile;
use Illuminate\Http\Request;

class CheckupFileController extends Controller
{
    public function create()
    {
        return view('dashboard.checkup-file.create');
    }

    public function destroy(Request $request, CheckupFile $checkupFile)
    {
        try {
            $checkupFile->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
                'data'    => null,
                'title' => 'Done'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus',
                'data'    => null,
                'title' => 'Oopps'
            ], 404);
        }
    }
}
