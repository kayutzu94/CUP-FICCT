@extends('layouts.app')

@section('title', 'Lista de Docentes')

@section('content')
<div class="container-fluid px-0 py-2">

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center alert-dismissible fade show mb-3 p-3" role="alert">
            <i class="fas fa-exclamation-triangle fa-lg me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center alert-dismissible fade show mb-3 p-3" role="alert">
            <i class="fas fa-check-circle fa-lg me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center">
                    <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                        <i class="fas fa-graduation-cap fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-white">Lista de Docentes</h4>
                        <p class="mb-0 text-white-50 small mt-1">Administración, verificación de requisitos de postulación y asignación de carga horaria</p>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <div class="btn-group shadow-sm rounded-3 overflow-hidden" role="group" aria-label="Filtros de Requisitos">
                        <a href="{{ route('docentes.index') }}" class="btn btn-sm fw-medium px-3 d-inline-flex align-items-center {{ !request('filter_requisitos') ? 'btn-secondary text-white' : 'btn-light text-dark' }}">
                            Todos
                        </a>
                        <a href="{{ route('docentes.index', ['filter_requisitos' => 'cumple']) }}" class="btn btn-sm fw-medium px-3 d-inline-flex align-items-center {{ request('filter_requisitos') === 'cumple' ? 'btn-success text-white' : 'btn-light text-success' }}">
                            <i class="fas fa-check-circle me-1.5"></i> Cumplen
                        </a>
                        <a href="{{ route('docentes.index', ['filter_requisitos' => 'no_cumple']) }}" class="btn btn-sm fw-medium px-3 d-inline-flex align-items-center {{ request('filter_requisitos') === 'no_cumple' ? 'btn-danger text-white' : 'btn-light text-danger' }}">
                            <i class="fas fa-exclamation-circle me-1.5"></i> No cumplen
                        </a>
                    </div>
                    <a href="{{ route('docentes.create') }}" class="btn btn-warning fw-bold text-dark rounded-3 px-3 shadow-sm hover-up">
                        <i class="fas fa-plus me-1"></i> Nuevo Docente
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3">CI</th>
                            <th class="py-3">Nombres</th>
                            <th class="py-3">Apellidos</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Profesión</th>
                            <th class="py-3">Especialidad</th>
                            <th class="py-3 text-center" style="width: 125px;">Requisitos</th>
                            <th class="py-3 text-center" style="width: 110px;">Grupos</th>
                            <th class="py-3 text-center" style="width: 95px;">Estado</th>
                            <th class="py-3 text-center px-3" style="width: 320px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($docentes as $docente)
                        <tr class="row-hover-effect">
                            <td class="px-3 fw-bold text-dark font-monospace">{{ $docente->ci }}</td>
                            <td class="fw-medium">{{ $docente->nombres }}</td>
                            <td class="fw-medium">{{ $docente->apellidos }}</td>
                            <td class="text-secondary font-size-sm">{{ $docente->email }}</td>
                            <td><span class="badge bg-light text-dark border font-size-xs px-2 py-1.5">{{ $docente->profesion }}</span></td>
                            <td class="text-muted font-size-sm">{{ $docente->especialidad ?? 'N/A' }}</td>
                            
                            <td class="text-center">
                                @if($docente->cumpleRequisitos())
                                    <span class="badge bg-success-soft text-success px-2 py-1.5 rounded-pill font-size-xs fw-bold border border-success border-opacity-10">
                                        <i class="fas fa-check-circle me-1"></i> Cumple
                                    </span>
                                @else
                                    <span class="badge bg-danger-soft text-danger px-2 py-1.5 rounded-pill font-size-xs fw-bold border border-danger border-opacity-10 cursor-help" 
                                          data-bs-toggle="tooltip" 
                                          data-bs-placement="top"
                                          title="Faltan: {{ implode(', ', $docente->getRequisitosPendientes()) }}">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Falta doc.
                                    </span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                <span class="badge bg-info-soft text-info-custom px-2.5 py-1.5 font-size-sm rounded fw-bold font-monospace border border-info border-opacity-10">
                                    {{ $docente->asignaciones->count() }}/4
                                </span>
                            </td>
                            
                            <td class="text-center">
                                @if($docente->activo)
                                    <span class="badge bg-success font-size-xs px-2 py-1 rounded-pill">Activo</span>
                                @else
                                    <span class="badge bg-secondary font-size-xs px-2 py-1 rounded-pill">Inactivo</span>
                                @endif
                            </td>
                            
                            <td class="px-3">
                                <div class="d-flex gap-1.5">
                                    <a href="{{ route('docentes.show', $docente) }}" class="btn btn-sm btn-outline-primary border rounded-3 px-2 py-1.5 flex-fill d-flex align-items-center justify-content-center font-size-sm fw-medium shadow-2xs" title="Ver Historial">
                                        <i class="fas fa-eye me-1"></i> Ver
                                    </a>
                                    <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-sm btn-outline-warning border rounded-3 px-2 py-1.5 flex-fill d-flex align-items-center justify-content-center font-size-sm fw-medium shadow-2xs text-warning-custom" title="Editar Información">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </a>
                                    
                                    @if($docente->cumpleRequisitos())
                                        <button type="button" class="btn btn-sm btn-outline-success border rounded-3 px-2 py-1.5 flex-fill d-flex align-items-center justify-content-center font-size-sm fw-bold shadow-2xs" onclick="abrirModalAsignacion({{ $docente->id }})" title="Asignar Materias y Grupos">
                                            <i class="fas fa-plus-circle me-1"></i> Asignar
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-light border text-muted rounded-3 px-2 py-1.5 flex-fill d-flex align-items-center justify-content-center font-size-sm fw-medium opacity-60" disabled 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top"
                                                title="Bloqueado. Requisitos pendientes: {{ implode(', ', $docente->getRequisitosPendientes()) }}">
                                            <i class="fas fa-lock me-1"></i> Trancado
                                        </button>
                                    @endif

                                    <form id="delete-form-{{ $docente->id }}" action="{{ route('docentes.destroy', $docente) }}" method="POST" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger border rounded-3 px-2 py-1.5 w-100 d-flex align-items-center justify-content-center font-size-sm fw-medium shadow-2xs" onclick="confirmDelete('delete-form-{{ $docente->id }}')" title="Eliminar Registro">
                                            <i class="fas fa-trash me-1"></i> Borrar
                                        </button>
                                    </form>
                                </div>
                                
                                @if($docente->cumpleRequisitos())
                                <div id="modalAsignar{{ $docente->id }}" class="modal-custom window-blur fade-in-fast" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10,43,94,0.4); z-index: 9999; align-items: center; justify-content: center;">
                                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden w-100 mx-3 scale-up" style="max-width: 500px;">
                                        <div class="card-header text-white border-0 py-3 px-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #0a2b5e 0%, #143f7d 100%);">
                                            <h5 class="modal-title fw-bold d-flex align-items-center mb-0 font-size-md">
                                                <i class="fas fa-network-wired me-2 text-warning"></i> Asignar Carga Académica
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white shadow-none" onclick="cerrarModalAsignacion({{ $docente->id }})"></button>
                                        </div>
                                        <form action="{{ route('docentes.asignar-grupos', $docente) }}" method="POST">
                                            @csrf
                                            <div class="card-body p-4 text-start">
                                                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mb-3 d-flex align-items-center p-3">
                                                    <i class="fas fa-user-circle fa-lg me-2.5"></i>
                                                    <span class="small fw-medium">Asignación para: <strong class="text-dark">{{ $docente->nombre_completo }}</strong></span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-dark fw-medium small">Materia <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border text-muted"><i class="fas fa-book"></i></span>
                                                        <select name="materia_id" class="form-select border font-size-sm" required>
                                                            <option value="">-- Seleccione una materia --</option>
                                                            @foreach(\App\Models\Materia::all() as $materia)
                                                                <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label text-dark fw-medium small">Seleccionar Grupos <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border text-muted align-items-start pt-2"><i class="fas fa-layer-group"></i></span>
                                                        <select name="grupos[]" class="form-select border font-size-sm select-grupos-max" multiple size="4" required data-max="4">
                                                            @foreach(\App\Models\Grupo::all() as $grupo)
                                                                <option value="{{ $grupo->id }}" class="py-1 px-2 border-bottom border-light">
                                                                    {{ $grupo->nombre }} ({{ $grupo->codigo }}) — {{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }} Alumnos
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1.5 mt-2 bg-light border p-2.5 rounded-3">
                                                        <i class="fas fa-keyboard text-muted small"></i>
                                                        <small class="text-muted font-size-xs">
                                                            Mantén presionado <kbd class="bg-secondary text-white px-1 rounded">Ctrl</kbd> para marcar varios. <strong>Máximo 4 en total.</strong>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-light border-0 py-3 px-4 d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-secondary border-0 font-size-sm px-3 py-2 rounded-3" onclick="cerrarModalAsignacion({{ $docente->id }})">Cancelar</button>
                                                <button type="submit" class="btn btn-action font-size-sm px-4 py-2 rounded-3 fw-bold">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 bg-white bg-opacity-50">
                                <div class="py-3">
                                    <i class="fas fa-users-slash text-muted fa-3x mb-3 opacity-40"></i>
                                    <h5 class="text-muted fw-normal">No se encontraron docentes registrados</h5>
                                    <p class="text-muted small mb-0">Intente modificando los filtros de requisitos del listado.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($docentes->hasPages())
                <div class="mt-4 d-flex justify-content-center custom-pagination-wrapper">
                    {{ $docentes->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Inicializar Tooltips nativos de Bootstrap
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // Cuadro de confirmación nativo para eliminación
    function confirmDelete(formId) {
        if(confirm('¿Está seguro de eliminar de forma permanente a este docente de la base de datos?')) {
            document.getElementById(formId).submit();
        }
    }
    
    // Abrir ventana modal limpia
    function abrirModalAsignacion(id) {
        var modal = document.getElementById('modalAsignar' + id);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            // Pequeño retardo para activar animación CSS suave
            setTimeout(() => {
                modal.querySelector('.card').classList.add('show-scale');
            }, 10);
        }
    }
    
    // Cerrar ventana modal limpia
    function cerrarModalAsignacion(id) {
        var modal = document.getElementById('modalAsignar' + id);
        if (modal) {
            modal.querySelector('.card').classList.remove('show-scale');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 150);
        }
    }
    
    // Cerrar modal al hacer clic en las zonas exteriores difuminadas
    window.onclick = function(event) {
        if (event.target.classList && event.target.classList.contains('modal-custom')) {
            var modals = document.querySelectorAll('.modal-custom');
            modals.forEach(function(modal) {
                modal.querySelector('.card').classList.remove('show-scale');
                setTimeout(() => {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }, 150);
            });
        }
    }

    // Control de límite máximo interactivo (Seguridad en interfaz del cliente)
    document.addEventListener('DOMContentLoaded', function () {
        const selectsGrupos = document.querySelectorAll('.select-grupos-max');
        selectsGrupos.forEach(function (select) {
            let opcionesPrevias = [];
            select.addEventListener('change', function () {
                const maximo = parseInt(this.getAttribute('data-max')) || 4;
                const opcionesSeleccionadas = Array.from(this.options).filter(opt => opt.selected);
                
                if (opcionesSeleccionadas.length > maximo) {
                    alert(`Restricción institucional FICCT: No se permite sobrecargar al docente con más de ${maximo} grupos simultáneos.`);
                    Array.from(this.options).forEach(opt => {
                        opt.selected = opcionesPrevias.includes(opt.value);
                    });
                } else {
                    opcionesPrevias = opcionesSeleccionadas.map(opt => opt.value);
                }
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* Cabecera institucional */
    .custom-table-header {
        background-color: #0a2b5e !important;
    }
    .metric-icon-box {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Interacción en tablas */
    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(10, 43, 94, 0.02) !important;
    }

    /* Badges translúcidos con contraste */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .bg-info-soft { background-color: rgba(23, 162, 184, 0.12); }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    
    .text-info-custom { color: #117a8b; }
    .text-primary-custom { color: #0a2b5e; }
    .text-warning-custom { color: #cc9a06 !important; }
    
    .cursor-help { cursor: help; }
    .gap-1.5 { gap: 0.35rem; }

    /* Botones y efectos */
    .btn-action {
        background-color: #0a2b5e;
        color: white;
    }
    .btn-action:hover {
        background-color: #143f7d;
        color: white;
    }
    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }
    .shadow-2xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    /* Clases utilitarias fijas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .me-1.5 { margin-right: 0.35rem; }
    .p-2.5 { padding: 0.65rem; }
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }

    /* Efectos de Blur y Animaciones del modal personalizado */
    .window-blur {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        transition: all 0.2s ease-in-out;
    }
    .fade-in-fast {
        animation: fadeInFast 0.2s ease-out;
    }
    .scale-up {
        transform: scale(0.93);
        opacity: 0;
        transition: transform 0.15s ease-out, opacity 0.15s ease-out;
    }
    .card.show-scale {
        transform: scale(1);
        opacity: 1;
    }

    @keyframes fadeInFast {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Corrección de diseño para paginación de Bootstrap dentro de contenedores fluidos */
    .custom-pagination-wrapper nav {
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>
@endpush
@endsection