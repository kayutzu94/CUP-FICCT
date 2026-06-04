<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Evaluacion;
use App\Models\Materia;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    // CU27: Exportar Excel
    public function exportExcel()
    {
        $postulantes = Postulante::with(['carreraAsignada'])->get();
        
        $callback = function() use ($postulantes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['CI', 'Nombres', 'Apellidos', 'Email', 'Carrera Asignada', 'Promedio Final', 'Estado']);
            
            foreach ($postulantes as $p) {
                fputcsv($file, [
                    $p->ci, $p->nombres, $p->apellidos, $p->email,
                    $p->carreraAsignada->nombre ?? 'Pendiente',
                    $p->promedio_final ?? 0,
                    $p->estado_academico
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="postulantes_' . date('Y-m-d') . '.csv"',
        ]);
    }

    // CU27: Exportar PDF
    public function exportPDF()
    {
        $postulantes = Postulante::with(['carreraAsignada'])->get();
        $pdf = Pdf::loadView('pdf.postulantes', compact('postulantes'));
        return $pdf->download('reporte_postulantes_' . date('Y-m-d') . '.pdf');
    }
}