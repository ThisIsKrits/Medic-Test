<?php

namespace App\Http\Controllers;

use App\Enums\StatusPrecription;
use App\Models\Prescription;
use App\Services\PrescriptionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateStatusPrescriptionController extends Controller
{
    protected $service;

    public function __construct(PrescriptionService $service)
    {
        $this->service = $service;
    }

    public function update($id)
    {
        $prescription = Prescription::findOrFail($id);
        $this->service->updateStatus($prescription, 2);

        $message = 'Status telah diupdate';
        return redirect()
                    ->route('prescription.index')
                    ->withSuccess($message);
    }

    public function show($id)
    {
        $prescription = Prescription::with('prescriptionItems')->findOrFail($id);
        $prescription->load('prescriptionItems', 'checkup','checkup.patients');

        if (Auth::user()->hasAnyRole(['apoteker', 'superadmin', 'admin'])) {
            $this->service->updateStatus($prescription, 3);
        }



        $pdf = Pdf::loadView('print.resep', [
            'prescription'  => $prescription
        ]);
        return $pdf->stream('resep_' . $prescription->no . '.pdf');
    }
}
