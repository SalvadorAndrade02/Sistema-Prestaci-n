<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class ReportController extends Controller
{
    public function generatePrestaPDF($id)
    {
        // Obtener el usuario por ID
        $prest = Prestamo::findOrFail($id);

        // Cargar la vista y pasar los datos del usuario
        $pdf = PDF::loadView('prestacion_report', compact('prest'));

        // Descargar el PDF con un nombre específico
        return $pdf->download('prest_report_' . $prest->id . '.pdf');
    }
    public function reporteGeneral(){
        $reporte = Prestamo::all();
        $pdf = PDF::loadView('report_general', compact('reporte'));

        return $pdf->download('reporteGeneralPrestaciones.pdf');
    }
}
