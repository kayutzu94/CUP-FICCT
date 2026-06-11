<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Postulante;
use App\Models\Carrera;

class AsignarCarrerasPorMerito extends Command
{
    protected $signature = 'asignar:carreras {cupos_primera_opcion=50}';
    protected $description = 'Asigna carreras por mérito: X mejores promedios a primera opción, resto a segunda';

    public function handle()
    {
        $cuposPrimeraOpcion = $this->argument('cupos_primera_opcion');
        
        $this->info("\n🎓 SISTEMA DE ASIGNACIÓN POR MÉRITO");
        $this->info("=====================================");
        $this->info("📊 Los {$cuposPrimeraOpcion} mejores promedios irán a su PRIMERA OPCIÓN");
        $this->info("📊 El resto de aprobados irán a su SEGUNDA OPCIÓN\n");
        
        // 1. Resetear contadores de carreras
        Carrera::query()->update(['inscritos_actuales' => 0]);
        $this->info("✓ Contadores de carreras reiniciados");
        
        // 2. Obtener postulantes APROBADOS ordenados por promedio (mejores primero)
        $postulantes = Postulante::where('estado_academico', 'aprobado')
            ->orderBy('promedio_final', 'desc')
            ->get();
        
        $totalAprobados = $postulantes->count();
        $this->info("✓ Postulantes aprobados: {$totalAprobados}\n");
        
        if ($totalAprobados == 0) {
            $this->error("No hay postulantes aprobados para asignar.");
            return;
        }
        
        $asignadosPrimera = 0;
        $asignadosSegunda = 0;
        $sinCupo = 0;
        
        foreach ($postulantes as $index => $postulante) {
            $primera = Carrera::find($postulante->primera_carrera_id);
            $segunda = Carrera::find($postulante->segunda_carrera_id);
            
            $asignado = false;
            $opcion = '';
            
            // Los primeros 'cupos_primera_opcion' van a primera opción
            if ($index < $cuposPrimeraOpcion) {
                if ($primera && $primera->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $primera->id;
                    $primera->increment('inscritos_actuales');
                    $asignado = true;
                    $asignadosPrimera++;
                    $opcion = "PRIMERA OPCIÓN (Top {$cuposPrimeraOpcion})";
                } elseif ($segunda && $segunda->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $segunda->id;
                    $segunda->increment('inscritos_actuales');
                    $asignado = true;
                    $asignadosSegunda++;
                    $opcion = "SEGUNDA OPCIÓN (1ra opción llena)";
                }
            } else {
                // Resto a segunda opción
                if ($segunda && $segunda->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $segunda->id;
                    $segunda->increment('inscritos_actuales');
                    $asignado = true;
                    $asignadosSegunda++;
                    $opcion = "SEGUNDA OPCIÓN";
                } elseif ($primera && $primera->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $primera->id;
                    $primera->increment('inscritos_actuales');
                    $asignado = true;
                    $asignadosPrimera++;
                    $opcion = "PRIMERA OPCIÓN (2da opción llena)";
                }
            }
            
            if (!$asignado) {
                $postulante->carrera_asignada_id = null;
                $sinCupo++;
                $this->warn("  ✗ {$postulante->nombres} {$postulante->apellidos} (Prom: {$postulante->promedio_final}) → SIN CUPO");
            } else {
                $this->line("  ✓ {$postulante->nombres} {$postulante->apellidos} (Prom: {$postulante->promedio_final}) → {$opcion}");
            }
            
            $postulante->save();
        }
        
        // Resultados finales
        $this->info("\n📊 RESULTADOS DE ASIGNACIÓN:");
        $this->info("   ✅ Asignados a 1ra Opción: {$asignadosPrimera}");
        $this->info("   ✅ Asignados a 2da Opción: {$asignadosSegunda}");
        $this->info("   ⏳ Sin cupo (lista espera): {$sinCupo}");
        
        $this->info("\n📚 CUPOS POR CARRERA:");
        $carreras = Carrera::all();
        foreach ($carreras as $carrera) {
            $disponibles = $carrera->capacidad_maxima - $carrera->inscritos_actuales;
            $barra = $this->getBarra($carrera->inscritos_actuales, $carrera->capacidad_maxima);
            $this->line("   {$carrera->nombre}: {$carrera->inscritos_actuales}/{$carrera->capacidad_maxima} {$barra} (libres: {$disponibles})");
        }
    }
    
    private function getBarra($actual, $maximo)
    {
        $porcentaje = ($actual / $maximo) * 100;
        if ($porcentaje >= 90) return '🔴';
        if ($porcentaje >= 70) return '🟡';
        return '🟢';
    }
}