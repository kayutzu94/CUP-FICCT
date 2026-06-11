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
        //Postulante::truncate();
        //Evaluacion::truncate();
        //Carrera::query()->update(['inscritos_actuales' => 0]);
        
        $carreras = Carrera::all();
        $materias = Materia::all();
        
        $postulantesData = [
            // 30 postulantes aprobados (promedios altos)
            ['nombres' => 'Carlos Andrés', 'apellidos' => 'Mendoza Ríos', 'promedio_base' => 85],
            ['nombres' => 'María Fernanda', 'apellidos' => 'López García', 'promedio_base' => 78],
            ['nombres' => 'José Antonio', 'apellidos' => 'Quispe Mamani', 'promedio_base' => 82],
            ['nombres' => 'Ana Lucía', 'apellidos' => 'Torres Vásquez', 'promedio_base' => 75],
            ['nombres' => 'Luis Alberto', 'apellidos' => 'Flores Vargas', 'promedio_base' => 88],
            ['nombres' => 'Daniela Alejandra', 'apellidos' => 'Rojas Paredes', 'promedio_base' => 72],
            ['nombres' => 'Jorge Luis', 'apellidos' => 'Gutiérrez Fernández', 'promedio_base' => 79],
            ['nombres' => 'Valentina Sofía', 'apellidos' => 'Castro Orellana', 'promedio_base' => 84],
            ['nombres' => 'Miguel Ángel', 'apellidos' => 'Sánchez Miranda', 'promedio_base' => 76],
            ['nombres' => 'Camila Belén', 'apellidos' => 'Díaz Suárez', 'promedio_base' => 81],
            ['nombres' => 'Sebastián', 'apellidos' => 'Jiménez Chávez', 'promedio_base' => 73],
            ['nombres' => 'Fernanda Andrea', 'apellidos' => 'Perales Colque', 'promedio_base' => 86],
            ['nombres' => 'Adrián Gabriel', 'apellidos' => 'Mamani Choque', 'promedio_base' => 77],
            ['nombres' => 'Paola Daniela', 'apellidos' => 'Villarroel Daza', 'promedio_base' => 80],
            ['nombres' => 'Cristian Omar', 'apellidos' => 'Navarro Ponce', 'promedio_base' => 74],
            ['nombres' => 'Natalia Belén', 'apellidos' => 'Zeballos Antelo', 'promedio_base' => 87],
            ['nombres' => 'Ricardo Javier', 'apellidos' => 'Soliz Justiniano', 'promedio_base' => 71],
            ['nombres' => 'Gabriela Patricia', 'apellidos' => 'Arias Suárez', 'promedio_base' => 83],
            ['nombres' => 'David Alejandro', 'apellidos' => 'Bustos Montaño', 'promedio_base' => 78],
            ['nombres' => 'Stefany Nicole', 'apellidos' => 'Ribera Cuéllar', 'promedio_base' => 90],
            ['nombres' => 'Alejandro', 'apellidos' => 'Vargas Suárez', 'promedio_base' => 76],
            ['nombres' => 'Camila', 'apellidos' => 'Flores Justiniano', 'promedio_base' => 82],
            ['nombres' => 'Diego', 'apellidos' => 'Mendoza Pereira', 'promedio_base' => 68],
            ['nombres' => 'Valentina', 'apellidos' => 'Céspedes Rojas', 'promedio_base' => 79],
            ['nombres' => 'Nicolás', 'apellidos' => 'Aguirre Landívar', 'promedio_base' => 85],
            ['nombres' => 'Regina', 'apellidos' => 'Palacios Nogales', 'promedio_base' => 72],
            ['nombres' => 'Andrés', 'apellidos' => 'Roca Antelo', 'promedio_base' => 88],
            ['nombres' => 'Mariana', 'apellidos' => 'Zeballos Ortiz', 'promedio_base' => 74],
            ['nombres' => 'Tomás', 'apellidos' => 'López Justiniano', 'promedio_base' => 81],
            ['nombres' => 'Florencia', 'apellidos' => 'Méndez Cuéllar', 'promedio_base' => 77],
            // 20 postulantes reprobados (promedios bajos)
            ['nombres' => 'Joaquín', 'apellidos' => 'Ribera Paz', 'promedio_base' => 45],
            ['nombres' => 'Victoria', 'apellidos' => 'Salinas Vaca', 'promedio_base' => 52],
            ['nombres' => 'Manuel', 'apellidos' => 'Terrazas Justiniano', 'promedio_base' => 48],
            ['nombres' => 'Julieta', 'apellidos' => 'Oropeza Rivero', 'promedio_base' => 55],
            ['nombres' => 'Felipe', 'apellidos' => 'Cortez Camacho', 'promedio_base' => 42],
            ['nombres' => 'Antonella', 'apellidos' => 'Burgoa Justiniano', 'promedio_base' => 58],
            ['nombres' => 'Mateo', 'apellidos' => 'Padilla Landívar', 'promedio_base' => 49],
            ['nombres' => 'Luciana', 'apellidos' => 'Rioja Flores', 'promedio_base' => 53],
            ['nombres' => 'Emiliano', 'apellidos' => 'Guzmán Suárez', 'promedio_base' => 44],
            ['nombres' => 'Aitana', 'apellidos' => 'Montero Justiniano', 'promedio_base' => 56],
            ['nombres' => 'Bautista', 'apellidos' => 'Larrea Cuéllar', 'promedio_base' => 47],
            ['nombres' => 'Catalina', 'apellidos' => 'Aguirre Justiniano', 'promedio_base' => 51],
            ['nombres' => 'Thiago', 'apellidos' => 'Molina Roca', 'promedio_base' => 43],
            ['nombres' => 'Delfina', 'apellidos' => 'Céspedes Justiniano', 'promedio_base' => 54],
            ['nombres' => 'Santino', 'apellidos' => 'Vaca Justiniano', 'promedio_base' => 46],
            ['nombres' => 'Carolina', 'apellidos' => 'Ustariz Justiniano', 'promedio_base' => 59],
            ['nombres' => 'Israel', 'apellidos' => 'Reyes Flores', 'promedio_base' => 41],
            ['nombres' => 'Emma', 'apellidos' => 'Aguirre Cardona', 'promedio_base' => 50],
            ['nombres' => 'Bruno', 'apellidos' => 'Montaño Rivero', 'promedio_base' => 48],
            ['nombres' => 'Lara', 'apellidos' => 'Lema Justiniano', 'promedio_base' => 52],
            // 30 postulantes adicionales (15 aprobados, 15 reprobados)
            ['nombres' => 'Fernando', 'apellidos' => 'Cáceres Justiniano', 'promedio_base' => 83],
            ['nombres' => 'Isabella', 'apellidos' => 'Mercado Justiniano', 'promedio_base' => 47],
            ['nombres' => 'Lucas', 'apellidos' => 'Vargas Justiniano', 'promedio_base' => 79],
            ['nombres' => 'Valentina', 'apellidos' => 'Salvatierra Justiniano', 'promedio_base' => 52],
            ['nombres' => 'Matías', 'apellidos' => 'Roca Justiniano', 'promedio_base' => 88],
            ['nombres' => 'Renata', 'apellidos' => 'Justiniano Justiniano', 'promedio_base' => 44],
            ['nombres' => 'Emilio', 'apellidos' => 'Ortiz Justiniano', 'promedio_base' => 76],
            ['nombres' => 'Catalina', 'apellidos' => 'Aguilera Justiniano', 'promedio_base' => 55],
            ['nombres' => 'Santiago', 'apellidos' => 'Ribera Justiniano', 'promedio_base' => 91],
            ['nombres' => 'Antonella', 'apellidos' => 'Justiniano Justiniano', 'promedio_base' => 42],
            ['nombres' => 'Benjamín', 'apellidos' => 'Justiniano Justiniano', 'promedio_base' => 85],
            ['nombres' => 'Mía', 'apellidos' => 'Rivero Justiniano', 'promedio_base' => 49],
            ['nombres' => 'Joaquín', 'apellidos' => 'Vargas Méndez', 'promedio_base' => 73],
            ['nombres' => 'Delfina', 'apellidos' => 'Rojas Aguilar', 'promedio_base' => 58],
            ['nombres' => 'Thiago', 'apellidos' => 'Pérez Ramírez', 'promedio_base' => 82],
            ['nombres' => 'Emma', 'apellidos' => 'Gutiérrez Flores', 'promedio_base' => 46],
            ['nombres' => 'Facundo', 'apellidos' => 'Castro Herrera', 'promedio_base' => 89],
            ['nombres' => 'Andrea', 'apellidos' => 'Suárez Molina', 'promedio_base' => 53],
            ['nombres' => 'Julián', 'apellidos' => 'Ortega Cabrera', 'promedio_base' => 77],
            ['nombres' => 'Sofía', 'apellidos' => 'Silva Torres', 'promedio_base' => 48],
            ['nombres' => 'Santino', 'apellidos' => 'Navarro Fernández', 'promedio_base' => 84],
            ['nombres' => 'Clara', 'apellidos' => 'Martínez López', 'promedio_base' => 51],
            ['nombres' => 'Lautaro', 'apellidos' => 'Gómez Villalba', 'promedio_base' => 75],
            ['nombres' => 'Abril', 'apellidos' => 'Domínguez Salazar', 'promedio_base' => 56],
            ['nombres' => 'Franco', 'apellidos' => 'Quiroga Bustos', 'promedio_base' => 87],
            ['nombres' => 'Martina', 'apellidos' => 'Cárdenas Pacheco', 'promedio_base' => 43],
            ['nombres' => 'Agustín', 'apellidos' => 'Montoya Delgado', 'promedio_base' => 80],
            ['nombres' => 'Lara', 'apellidos' => 'Reyes Zambrano', 'promedio_base' => 54],
            ['nombres' => 'Favio', 'apellidos' => 'Peña Maldonado', 'promedio_base' => 72],
            ['nombres' => 'Luciana', 'apellidos' => 'Fuentes Arce', 'promedio_base' => 45],
        ];

        foreach ($postulantesData as $data) {
            $primera = $carreras->random();
            $segunda = $carreras->where('id', '!=', $primera->id)->random();
            
            $nombreCompleto = strtolower(str_replace(' ', '', $data['nombres'])) . '.' . strtolower(explode(' ', $data['apellidos'])[0]);
            
            $postulante = Postulante::create([
                'ci' => 'CI' . rand(100000, 999999),
                'nombres' => $data['nombres'],
                'apellidos' => $data['apellidos'],
                'fecha_nacimiento' => rand(1995, 2005) . '-' . rand(1, 12) . '-' . rand(1, 28),
                'sexo' => rand(0, 1) ? 'M' : 'F',
                'direccion' => 'Calle ' . rand(1, 100) . ' #' . rand(100, 999),
                'telefono' => '777' . rand(10000, 99999),
                'email' => $nombreCompleto . '@cup.edu.bo',
                'colegio' => 'Unidad Educativa ' . chr(rand(65, 90)),
                'ciudad' => 'Santa Cruz de la Sierra',
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
            
            // Crear evaluaciones con notas basadas en el promedio_base
            $sumaPromedios = 0;
            foreach ($materias as $materia) {
                $variacion = rand(-15, 15);
                $promedioMateria = max(20, min(100, $data['promedio_base'] + $variacion));
                $sumaPromedios += $promedioMateria;
                
                $examen1 = rand($promedioMateria - 15, $promedioMateria + 15);
                $examen2 = rand($promedioMateria - 15, $promedioMateria + 15);
                $examen3 = rand($promedioMateria - 15, $promedioMateria + 15);
                $examen1 = max(20, min(100, $examen1));
                $examen2 = max(20, min(100, $examen2));
                $examen3 = max(20, min(100, $examen3));
                $promedio = round(($examen1 + $examen2 + $examen3) / 3, 2);
                
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