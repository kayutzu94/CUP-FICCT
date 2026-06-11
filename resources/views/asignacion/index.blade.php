@extends('layouts.app')

@section('title', 'Asignación por Mérito')
@section('header', '🎓 Asignación de Carreras por Mérito')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chalkboard-user"></i> Configurar Asignación
            </h5>
        </div>
        <div class="card-body">
            <div class="static-info-card mb-4" style="background-color: #e3f2fd; border-left: 4px solid #0a2b5e; padding: 15px; border-radius: 8px;">
                <i class="fas fa-info-circle" style="color: #0a2b5e;"></i>
                <strong style="color: #0a2b5e;">¿Cómo funciona?</strong>
                <ul class="mt-2 mb-0" style="color: #333;">
                    <li>🏆 Los <strong>mejores promedios</strong> (según la cantidad que ingreses) irán a su <strong style="color: #28a745;">PRIMERA OPCIÓN</strong></li>
                    <li>📋 El <strong>resto de aprobados</strong> irán a su <strong style="color: #ffc107;">SEGUNDA OPCIÓN</strong> (si hay cupo)</li>
                    <li>⚠️ Si no hay cupo en ninguna opción, quedan en <strong style="color: #dc3545;">LISTA DE ESPERA</strong></li>
                </ul>
            </div>
            
            <form method="POST" action="{{ route('asignacion.ejecutar') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="cupos_primera_opcion" class="form-label">
                                <i class="fas fa-trophy"></i> Cantidad de mejores promedios para PRIMERA OPCIÓN:
                            </label>
                            <input type="number" 
                                   class="form-control form-control-lg @error('cupos_primera_opcion') is-invalid @enderror" 
                                   id="cupos_primera_opcion" 
                                   name="cupos_primera_opcion" 
                                   value="" 
                                   placeholder="Ej. 50"
                                   min="1" 
                                   max="{{ $totalAprobados }}"
                                   required>
                            <small class="text-muted">
                                Total de aprobados disponibles: <strong>{{ $totalAprobados }}</strong>
                            </small>
                            @error('cupos_primera_opcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="fas fa-eye"></i> Vista previa:
                            </label>
                            <div class="static-info-card" id="vista-previa" style="background-color: #f8f9fc; border: 1px solid #dee2e6; padding: 15px; border-radius: 8px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-keyboard mb-2"></i><br>
                                    Ingrese una cantidad para ver la distribución de postulantes.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('¿Estás seguro de ejecutar la asignación? Los cupos actuales se reiniciarán.')">
                        <i class="fas fa-play"></i> Ejecutar Asignación
                    </button>
                    <a href="{{ route('postulantes.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const inputCantidad = document.getElementById('cupos_primera_opcion');
    const vistaPrevia = document.getElementById('vista-previa');
    const totalAprobados = {{ $totalAprobados }};
    
    function actualizarVistaPrevia() {
        let valorRaw = inputCantidad.value;
        
        // Si el campo está vacío o no es un número válido, mostrar indicación de ingreso manual
        if (valorRaw === '' || isNaN(valorRaw)) {
            vistaPrevia.innerHTML = `
                <div class="text-center text-muted">
                    <i class="fas fa-keyboard mb-2"></i><br>
                    Esperando que ingrese un número...
                </div>
            `;
            return;
        }

        let valor = parseInt(valorRaw) || 0;
        
        // Validar que no sea mayor que el total de aprobados
        if (valor > totalAprobados) {
            valor = totalAprobados;
            inputCantidad.value = totalAprobados;
        }
        
        // Validar mínimo permisible al escribir manualmente
        if (valor < 0) {
            valor = 0;
            inputCantidad.value = 0;
        }
        
        let resto = totalAprobados - valor;
        
        // Si no hay aprobados en el sistema
        if (totalAprobados === 0) {
            vistaPrevia.innerHTML = `
                <div class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p class="mb-0"><strong>No hay postulantes aprobados</strong></p>
                    <small>Primero debe registrar notas para los postulantes</small>
                </div>
            `;
            return;
        }
        
        // Si el resto es 0 (todos van a primera opción)
        if (resto === 0) {
            vistaPrevia.innerHTML = `
                <div class="text-center">
                    <div class="mb-2">
                        <span class="badge bg-success fs-6 p-2">🏆 ${valor} mejores promedios</span>
                        <i class="fas fa-arrow-right mx-2"></i>
                        <span class="badge bg-primary p-2">✓ PRIMERA OPCIÓN</span>
                    </div>
                    <div class="mt-2 p-2" style="background-color: #d4edda; border-radius: 5px;">
                        <i class="fas fa-check-circle text-success"></i> 
                        <strong>Todos los ${totalAprobados} aprobados</strong> irán a su <strong>PRIMERA OPCIÓN</strong>
                        <br><small>(No hay postulantes para segunda opción)</small>
                    </div>
                </div>
            `;
        } 
        // Si hay resto (algunos van a segunda opción)
        else {
            vistaPrevia.innerHTML = `
                <div class="text-center">
                    <div class="mb-2">
                        <span class="badge bg-success fs-6 p-2">🏆 ${valor} mejores promedios</span>
                        <i class="fas fa-arrow-right mx-2"></i>
                        <span class="badge bg-primary p-2">✓ PRIMERA OPCIÓN</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-warning fs-6 p-2">📋 ${resto} restantes</span>
                        <i class="fas fa-arrow-right mx-2"></i>
                        <span class="badge bg-info p-2">➡ SEGUNDA OPCIÓN</span>
                    </div>
                    <div class="text-muted mt-2 small">
                        <i class="fas fa-chart-line"></i> 
                        Total aprobados: <strong>${totalAprobados}</strong> | 
                        Primera opción: <strong>${valor}</strong> | 
                        Segunda opción: <strong>${resto}</strong>
                    </div>
                </div>
            `;
        }
    }
    
    // Actualizar dinámicamente cuando el usuario digite o cambie el valor
    inputCantidad.addEventListener('input', actualizarVistaPrevia);
    
    // Ejecutar al cargar la página por si se conservan datos en el búfer de navegación
    document.addEventListener('DOMContentLoaded', actualizarVistaPrevia);
</script>
@endsection