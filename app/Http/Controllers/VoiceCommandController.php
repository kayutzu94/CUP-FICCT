<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoiceCommandController extends Controller
{
    public function handle(Request $request)
    {
        $command = strtolower($request->command);
        
        // Mapeo de comandos a rutas
        $commands = [
            'mostrar aprobados' => [
                'url' => '/reportes/aprobados',
                'message' => 'Abriendo reporte de aprobados'
            ],
            'aprobados' => [
                'url' => '/reportes/aprobados',
                'message' => 'Abriendo reporte de aprobados'
            ],
            'mostrar reprobados' => [
                'url' => '/reportes/aprobados',
                'message' => 'Abriendo reporte de reprobados'
            ],
            'reprobados' => [
                'url' => '/reportes/aprobados',
                'message' => 'Abriendo reporte de reprobados'
            ],
            'ver grupos' => [
                'url' => '/grupos',
                'message' => 'Abriendo lista de grupos'
            ],
            'grupos' => [
                'url' => '/grupos',
                'message' => 'Abriendo lista de grupos'
            ],
            'exportar excel' => [
                'url' => '/exportar/excel',
                'message' => 'Exportando reporte a Excel'
            ],
            'excel' => [
                'url' => '/exportar/excel',
                'message' => 'Exportando reporte a Excel'
            ],
            'exportar pdf' => [
                'url' => '/exportar/pdf',
                'message' => 'Exportando reporte a PDF'
            ],
            'pdf' => [
                'url' => '/exportar/pdf',
                'message' => 'Exportando reporte a PDF'
            ],
            'ver estadísticas' => [
                'url' => '/reportes/estadisticas',
                'message' => 'Abriendo estadísticas por materia'
            ],
            'estadísticas' => [
                'url' => '/reportes/estadisticas',
                'message' => 'Abriendo estadísticas por materia'
            ],
            'promedios generales' => [
                'url' => '/reportes/promedios',
                'message' => 'Abriendo reporte de promedios generales'
            ],
            'promedios' => [
                'url' => '/reportes/promedios',
                'message' => 'Abriendo reporte de promedios generales'
            ],
            'docentes por grupos' => [
                'url' => '/reportes/docentes-por-grupos',
                'message' => 'Abriendo reporte de docentes por grupos'
            ],
            'grupos más aprobados' => [
                'url' => '/reportes/grupos-mas-aprobados',
                'message' => 'Abriendo reporte de grupos con más aprobados'
            ],
            'top grupos' => [
                'url' => '/reportes/grupos-mas-aprobados',
                'message' => 'Abriendo reporte de grupos con más aprobados'
            ],
            'cantidad de grupos' => [
                'url' => '/reportes/grupos-habilitados',
                'message' => 'Abriendo reporte de cantidad de grupos'
            ],
            'grupos habilitados' => [
                'url' => '/reportes/grupos-habilitados',
                'message' => 'Abriendo reporte de grupos habilitados'
            ],
            'lista de postulantes' => [
                'url' => '/reportes/lista',
                'message' => 'Abriendo lista de postulantes'
            ],
            'postulantes' => [
                'url' => '/postulantes',
                'message' => 'Abriendo lista de postulantes'
            ],
            'dashboard' => [
                'url' => '/dashboard',
                'message' => 'Volviendo al panel de control'
            ],
            'inicio' => [
                'url' => '/dashboard',
                'message' => 'Volviendo al panel de control'
            ],
        ];
        
        // Buscar comando coincidente
        foreach ($commands as $key => $action) {
            if (str_contains($command, $key)) {
                return response()->json([
                    'success' => true,
                    'message' => $action['message'],
                    'redirect' => $action['url']
                ]);
            }
        }
        
        // Si no se encuentra el comando
        return response()->json([
            'success' => false,
            'message' => 'Comando no reconocido. Comandos disponibles: aprobados, reprobados, grupos, exportar excel, exportar pdf, estadísticas, promedios, etc.'
        ]);
    }
}