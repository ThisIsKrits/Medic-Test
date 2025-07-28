<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\VitalSign;
use Illuminate\Http\Request;

class VitalSignController extends Controller
{
    public function create()
    {
        return view('dashboard.vital-sign.create');
    }

    public function destroy(Request $request, VitalSign $vitalSign)
    {

        try {
            $vitalSign->delete();

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
