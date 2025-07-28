<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionItem;
use Illuminate\Http\Request;

class PrescriptionDetailController extends Controller
{
    public function create()
    {
        return view('dashboard.prescription-detail.create');
    }

    public function destroy(Request $request, PrescriptionItem $prescriptionItem)
    {

        try {
            $prescriptionItem->delete();

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
