<?php

namespace App\Http\Controllers;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    //

    public function download($id)
    {
        $record = Prescription::with('patient')->findOrFail($id);

        // Generate the PDF
        $pdf = Pdf::loadView('pdf.certificate', ['record' => $record]);

        // Return the PDF for viewing in the browser (instead of downloading)
        return $pdf->stream('certificate.pdf');
    }

}
