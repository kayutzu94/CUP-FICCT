@extends('layouts.app')

@section('title', 'Asignación por Mérito')
@section('header', '🎓 Asignación de Carreras por Mérito')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-sliders-h fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Configurar Asignación Automática</h4>
                    <p class="mb-0 text-white-50 small mt-1">Defina los parámetros de corte para la distribución de plazas por orden de mérito</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mb-4 p-3.5">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-info-circle fa-lg me-2"></i>
                    <strong class="font-size-sm">¿Cómo opera el proceso de selección?</strong>
                </div>
                <ul class="mb-0 ps-3 font-size-sm text-secondary d-flex flex-column gap-1.5">
                    <li>🏆 Los <strong class="text-dark">mejores promedios</strong> (según la cantidad exacta que ingreses) serán asignados directamente a su <strong class="text-success fw-bold">PRIMERA OPCIÓN</strong>.</li>
                    <li>📋 El <strong class="text-dark">resto de postulantes aprobados</strong> pasará a competir por las plazas disponibles en su <strong class="text-warning-custom fw-bold">SEGUNDA OPCIÓN</strong>.</li>
                    <li>⚠️ En caso de no existir cupos libres en ninguna de sus opciones elegidas, se les mantendrá en <strong class="text-danger fw-bold">LISTA DE ESPERA</strong>.</li>
                </ul>
            </div>
            
            <form method="POST" action="{{ route('asignacion.ejecutar') }}" autocomplete="off">
                @csrf
                <div class="row g-4">
                    
                    <div class="col-12 col-lg-6">
                        <div class="card h-100 border-0 shadow-2xs rounded-3 p-3 bg-white">
                            <div class="form-group mb-0">
                                <label for="cupos_primera_opcion" class="form-label text-dark fw-bold small mb-2">
                                    <i class="fas fa-trophy text-success me-1"></i> Cantidad de mejores promedios para PRIMERA OPCIÓN:
                                </label>
                                <div class="input-group input-group-lg mb-2">
                                    <span class="input-group-text bg-light border text-muted font-size-sm"><i class="fas fa-users-cog"></i></span>
                                    <input type="number" 
                                           class="form-control border font-size-md fw-bold @error('cupos_primera_opcion') is-invalid @enderror" 
                                           id="cupos_primera_opcion" 
                                           name="cupos_primera_opcion" 
                                           value="" 
                                           placeholder="Ej. 50"
                                           min="1" 
                                           max="{{ $totalAprobados }}"
                                           autocomplete="off"
                                           required>
                                </div>
                                <div class="d-flex align-items-center text-muted font-size-xs bg-light rounded-2 p-2 px-2.5 border border-dashed">
                                    <i class="fas fa-database me-2 opacity-75"></i>
                                    <span>Total de aprobados disponibles en el sistema: <strong class="text-dark font-monospace">{{ $totalAprobados }}</strong></span>
                                </div>
                                @error('cupos_primera_opcion')
                                    <div class="invalid-feedback d-block mt-2 font-size-xs fw-semibold"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-6">
                        <div class="card h-100 border-0 shadow-2xs rounded-3 p-3 bg-white">
                            <label class="form-label text-dark fw-bold small mb-2">
                                <i class="fas fa-eye text-info-custom me-1"></i> Proyección en tiempo real:
                            </label>
                            <div id="vista-previa" class="flex-fill d-flex align-items-center justify-content-center bg-light bg-opacity-60 rounded-3 border p-3 border-dashed" style="min-height: 120px;">
                                <div class="text-center text-muted font-size-sm py-2">
                                    <i class="fas fa-keyboard mb-2 fa-lg opacity-50"></i><br>
                                    Ingrese una cantidad numérica para proyectar la distribución.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('postulantes.index') }}" class="btn btn-secondary border-0 font-size-sm px-4 py-2.5 rounded-3 fw-medium w-100 w-sm-auto text-center order-2 order-sm-1">
                        <i class="fas fa-arrow-left me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-action font-size-sm px-4 py-2.5 rounded-3 fw-bold shadow-sm hover-up w-100 w-sm-auto order-1 order-sm-2" onclick="return confirm('¿Estás totalmente seguro de ejecutar el algoritmo de asignación? Todas las plazas y estados de ocupación actuales de las carreras se reiniciarán por completo.')">
                        <i class="fas fa-play me-1"></i> Ejecutar Asignación Oficial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Contexto controlado sin automatizaciones ocultas
    const inputCantidad = document.getElementById('cupos_primera_opcion');
    const vistaPrevia = document.getElementById('vista-previa');
    const totalAprobados = {{ $totalAprobados }};
    
    function actualizarVistaPrevia() {
        let valorRaw = inputCantidad.value;
        
        if (valorRaw === '' || isNaN(valorRaw)) {
            vistaPrevia.innerHTML = `
                <div class="text-center text-muted font-size-sm py-2">
                    <i class="fas fa-keyboard mb-2 fa-lg opacity-50"></i><br>
                    Esperando que digite una cantidad válida...
                </div>
            `;
            return;
        }

        let valor = parseInt(valorRaw) || 0;
        
        if (valor > totalAprobados) {
            valor = totalAprobados;
            inputCantidad.value = totalAprobados;
        }
        
        if (valor < 0) {
            valor = 0;
            inputCantidad.value = 0;
        }
        
        let resto = totalAprobados - valor;
        
        if (totalAprobados === 0) {
            vistaPrevia.innerHTML = `
                <div class="text-center text-danger p-2">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2 opacity-80"></i>
                    <p class="mb-1 font-size-sm fw-bold">No existen postulantes aprobados en base de datos</p>
                    <small class="text-muted d-block font-size-xs">Debe registrar u homologar las notas del CUP previamente.</small>
                </div>
            `;
            return;
        }
        
        if (resto === 0) {
            vistaPrevia.innerHTML = `
                <div class="w-100 text-center fade-in-fast">
                    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center mb-3">
                        <span class="badge bg-success-soft text-success border border-success border-opacity-10 font-size-xs px-2.5 py-1.5 rounded-pill font-monospace fw-bold">🏆 ${valor} mejores promedios</span>
                        <i class="fas fa-chevron-right text-muted font-size-xs mx-1"></i>
                        <span class="badge bg-primary-soft text-primary-custom border border-primary border-opacity-10 font-size-xs px-2.5 py-1.5 rounded-pill fw-bold">✓ PRIMERA OPCIÓN</span>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-20">
                        <i class="fas fa-check-circle text-success me-1"></i> 
                        <span class="small text-dark fw-medium"><strong>El 100% de los ${totalAprobados} postulantes</strong> ingresarán directamente a su <strong>PRIMERA OPCIÓN</strong> si hay cupo disponible.</span>
                    </div>
                </div>
            `;
        } 
        else {
            vistaPrevia.innerHTML = `
                <div class="w-100 text-center fade-in-fast">
                    <div class="d-flex flex-column align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2 w-100 justify-content-center">
                            <span class="badge bg-success-soft text-success border border-success border-opacity-10 font-size-2xs px-2.5 py-1.5 rounded-pill font-monospace fw-bold text-end" style="min-width:140px;">🏆 ${valor} alumnos</span>
                            <i class="fas fa-arrow-right text-muted font-size-2xs"></i>
                            <span class="badge bg-primary-soft text-primary-custom border border-primary border-opacity-10 font-size-2xs px-2.5 py-1.5 rounded-pill fw-bold text-start" style="min-width:140px;">✓ 1ra Opción</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 w-100 justify-content-center">
                            <span class="badge bg-warning-soft text-warning-custom border border-warning border-opacity-10 font-size-2xs px-2.5 py-1.5 rounded-pill font-monospace fw-bold text-end" style="min-width:140px;">📋 ${resto} alumnos</span>
                            <i class="fas fa-arrow-right text-muted font-size-2xs"></i>
                            <span class="badge bg-info-soft text-info-custom border border-info border-opacity-10 font-size-2xs px-2.5 py-1.5 rounded-pill fw-bold text-start" style="min-width:140px;">🥈 2da Opción</span>
                        </div>
                    </div>
                    <div class="text-muted font-size-2xs font-monospace border-top pt-2 mt-2">
                        Mapeo: Aprobados (${totalAprobados}) = Corte (${valor}) + Remanente (${resto})
                    </div>
                </div>
            `;
        }
    }
    
    inputCantidad.addEventListener('input', actualizarVistaPrevia);
    document.addEventListener('DOMContentLoaded', actualizarVistaPrevia);
</script>
@endsection

@push('styles')
<style>
    /* Estructuras fijas e institucionales */
    .metric-icon-box {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }
    .text-warning-custom { color: #b78a02 !important; }
    
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.14); }
    .bg-info-soft { background-color: rgba(23, 162, 184, 0.12); }

    .btn-action {
        background-color: #0a2b5e;
        color: white;
    }
    .btn-action:hover {
        background-color: #143f7d;
        color: white;
    }

    /* Utilidades responsivas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .mb-1.5 { margin-bottom: 0.35rem; }
    .gap-1.5 { gap: 0.35rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }

    .fade-in-fast {
        animation: fadeInFast 0.2s ease-out;
    }
    @keyframes fadeInFast {
        from { opacity: 0; transform: scale(0.98); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush