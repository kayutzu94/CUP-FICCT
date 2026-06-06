<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Postulante;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Evaluacion;

class PostulantesSeeder extends Seeder
{
    public function run(): void
    {
        Postulante::truncate();
        Evaluacion::truncate();
        Carrera::query()->update(['inscritos_actuales' => 0]);
        
        $carreras = Carrera::all();
        $materias = Materia::all();
        
        $nombres = [
            ['nombres' => 'Carlos Andrés', 'apellidos' => 'Mendoza Ríos'],
            ['nombres' => 'María Fernanda', 'apellidos' => 'López García'],
            ['nombres' => 'José Antonio', 'apellidos' => 'Quispe Mamani'],
            ['nombres' => 'Ana Lucía', 'apellidos' => 'Torres Vásquez'],
            ['nombres' => 'Luis Alberto', 'apellidos' => 'Flores Vargas'],
            ['nombres' => 'Daniela Alejandra', 'apellidos' => 'Rojas Paredes'],
            ['nombres' => 'Jorge Luis', 'apellidos' => 'Gutiérrez Fernández'],
            ['nombres' => 'Valentina Sofía', 'apellidos' => 'Castro Orellana'],
            ['nombres' => 'Miguel Ángel', 'apellidos' => 'Sánchez Miranda'],
            ['nombres' => 'Camila Belén', 'apellidos' => 'Díaz Suárez'],
            ['nombres' => 'Sebastián', 'apellidos' => 'Jiménez Chávez'],
            ['nombres' => 'Fernanda Andrea', 'apellidos' => 'Perales Colque'],
            ['nombres' => 'Adrián Gabriel', 'apellidos' => 'Mamani Choque'],
            ['nombres' => 'Paola Daniela', 'apellidos' => 'Villarroel Daza'],
            ['nombres' => 'Cristian Omar', 'apellidos' => 'Navarro Ponce'],
            ['nombres' => 'Natalia Belén', 'apellidos' => 'Zeballos Antelo'],
            ['nombres' => 'Ricardo Javier', 'apellidos' => 'Soliz Justiniano'],
            ['nombres' => 'Gabriela Patricia', 'apellidos' => 'Arias Suárez'],
            ['nombres' => 'David Alejandro', 'apellidos' => 'Bustos Montaño'],
            ['nombres' => 'Stefany Nicole', 'apellidos' => 'Ribera Cuéllar'],
        ];

        for ($i = 1; $i <= 30; $i++) {
            $nombre = $nombres[array_rand($nombres)];
            $primera = $carreras->random();
            $segunda = $carreras->where('id', '!=', $primera->id)->random();
            
            $postulante = Postulante::create([
                'ci' => 'CI' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'nombres' => $nombre['nombres'],
                'apellidos' => $nombre['apellidos'],
                'fecha_nacimiento' => '2000-01-01',
                'sexo' => $i % 2 == 0 ? 'M' : 'F',
                'direccion' => 'Dirección ' . $i,
                'telefono' => '777' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'email' => 'postulante' . $i . '@cup.edu.bo',
                'colegio' => 'Colegio ' . $i,
                'ciudad' => 'Santa Cruz',
                'titulo_bachiller' => 'Bachiller en Humanidades',
                'primera_carrera_id' => $primera->id,
                'segunda_carrera_id' => $segunda->id,
                'carrera_asignada_id' => $primera->id,
            ]);
            
            if ($primera->tieneCupoDisponible()) {
                $primera->increment('inscritos_actuales');
            } else {
                $segunda->increment('inscritos_actuales');
                $postulante->carrera_asignada_id = $segunda->id;
                $postulante->save();
            }
            
            // Crear evaluaciones para cada materia
            $sumaPromedios = 0;
            foreach ($materias as $materia) {
                $examen1 = rand(40, 100);
                $examen2 = rand(40, 100);
                $examen3 = rand(40, 100);
                $promedio = round(($examen1 + $examen2 + $examen3) / 3, 2);
                $sumaPromedios += $promedio;
                
                Evaluacion::create([
                    'postulante_id' => $postulante->id,
                    'materia_id' => $materia->id,
                    'examen1' => $examen1,
                    'examen2' => $examen2,
                    'examen3' => $examen3,
                    'promedio' => $promedio,
                    'estado' => $promedio >= 60 ? 'aprobado' : 'reprobado',
                ]);
            }
            
            $promedioFinal = round($sumaPromedios / $materias->count(), 2);
            $postulante->promedio_final = $promedioFinal;
            $postulante->estado_academico = $promedioFinal >= 60 ? 'aprobado' : 'reprobado';
            $postulante->save();
        }
    }
}