@extends('layouts.app')

@section('title', 'Lista de Docentes')

@section('content')
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow">
    <div class="card-header bg-light py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <h4 class="m-0 font-weight-bold text-dark">
                <i class="fas fa-graduation-cap"></i> Lista de Docentes
            </h4>
            <div class="d-flex flex-wrap gap-2">
                <div class="btn-group" role="group" aria-label="Filtros de Requisitos">
                    <a href="{{ route('docentes.index') }}" class="btn {{ !request('filter_requisitos') ? 'btn-secondary' : 'btn-outline-secondary' }}">Todos</a>
                    <a href="{{ route('docentes.index', ['filter_requisitos' => 'cumple']) }}" class="btn {{ request('filter_requisitos') === 'cumple' ? 'btn-success' : 'btn-outline-success' }}">Cumplen requisitos</a>
                    <a href="{{ route('docentes.index', ['filter_requisitos' => 'no_cumple']) }}" class="btn {{ request('filter_requisitos') === 'no_cumple' ? 'btn-danger' : 'btn-outline-danger' }}">No cumplen</a>
                </div>
                <a href="{{ route('docentes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Docente
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover vertical-align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>CI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Profesión</th>
                        <th>Especialidad</th>
                        <th class="text-center">Requisitos</th>
                        <th class="text-center">Grupos Asignados</th>
                        <th class="text-center">Estado</th>
                        <th style="min-width: 280px;" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docentes as $docente)
                    <tr>
                        <td>{{ $docente->ci }}</td>
                        <td>{{ $docente->nombres }}</td>
                        <td>{{ $docente->apellidos }}</td>
                        <td>{{ $docente->email }}</td>
                        <td>{{ $docente->profesion }}</td>
                        <td>{{ $docente->especialidad ?? 'N/A' }}</td>
                        
                        <td class="text-center">
                            @if($docente->cumpleRequisitos())
                                <span class="badge bg-success p-2">
                                    <i class="fas fa-check-circle"></i> Cumple
                                </span>
                            @else
                                <span class="badge bg-danger p-2" 
                                      style="cursor: help;"
                                      data-bs-toggle="tooltip" 
                                      data-bs-placement="top"
                                      title="Faltan: {{ implode(', ', $docente->getRequisitosPendientes()) }}">
                                    <i class="fas fa-exclamation-triangle"></i> No cumple
                                </span>
                            @endif
                        </td>
                        
                        <td class="text-center">
                            <span class="badge bg-info p-2 fs-6">{{ $docente->asignaciones->count() }}/4</span>
                        </td>
                        
                        <td class="text-center">
                            @if($docente->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('docentes.show', $docente) }}" class="btn btn-sm btn-info flex-fill" title="Ver">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-sm btn-warning flex-fill" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                
                                @if($docente->cumpleRequisitos())
                                    <button type="button" class="btn btn-sm btn-primary flex-fill" onclick="abrirModalAsignacion({{ $docente->id }})" title="Asignar Grupos">
                                        <i class="fas fa-users"></i> Asignar
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-secondary flex-fill" disabled 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top"
                                            title="No disponible. Requisitos pendientes: {{ implode(', ', $docente->getRequisitosPendientes()) }}">
                                        <i class="fas fa-ban"></i> Bloqueado
                                    </button>
                                @endif

                                <form id="delete-form-{{ $docente->id }}" action="{{ route('docentes.destroy', $docente) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="confirmDelete('delete-form-{{ $docente->id }}')" title="Eliminar">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                            
                            @if($docente->cumpleRequisitos())
                            <div id="modalAsignar{{ $docente->id }}" class="modal-custom" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
                                <div style="background: white; border-radius: 10px; width: 500px; max-width: 90%; margin: auto; box-shadow: 0 5px 20px rgba(0,0,0,0.3);">
                                    <div class="modal-header bg-primary text-white" style="padding: 15px; border-radius: 10px 10px 0 0;">
                                        <h5 class="modal-title">Asignar Docente a Grupos</h5>
                                        <button type="button" class="btn-close btn-close-white" onclick="cerrarModalAsignacion({{ $docente->id }})"></button>
                                    </div>
                                    <form action="{{ route('docentes.asignar-grupos', $docente) }}" method="POST">
                                        @csrf
                                        <div class="modal-body" style="padding: 20px; text-align: left;">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i>
                                                <strong>Docente:</strong> {{ $docente->nombre_completo }}
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Materia <span class="text-danger">*</span></label>
                                                <select name="materia_id" class="form-select" required>
                                                    <option value="">-- Seleccione una materia --</option>
                                                    @foreach(\App\Models\Materia::all() as $materia)
                                                        <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Grupos <span class="text-danger">*</span></label>
                                                <select name="grupos[]" class="form-select select-grupos-max" multiple size="4" required data-max="4">
                                                    @foreach(\App\Models\Grupo::all() as $grupo)
                                                        <option value="{{ $grupo->id }}">
                                                            {{ $grupo->nombre }} ({{ $grupo->codigo }}) - 
                                                            {{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }} estudiantes
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="text-muted d-block mt-2">
                                                    Mantén presionada <kbd>Ctrl</kbd> para seleccionar. <strong>Máximo 4 grupos en total.</strong>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="padding: 15px; border-top: 1px solid #dee2e6; text-align: right;">
                                            <button type="button" class="btn btn-secondary" onclick="cerrarModalAsignacion({{ $docente->id }})">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Asignar Docente</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">No hay docentes registrados que coincidan con el filtro</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $docentes->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Inicializar Tooltips de Bootstrap para ver los requisitos faltantes al pasar el mouse
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    function confirmDelete(formId) {
        if(confirm('¿Está seguro de eliminar este docente?')) {
            document.getElementById(formId).submit();
        }
    }
    
    function abrirModalAsignacion(id) {
        var modal = document.getElementById('modalAsignar' + id);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }
    
    function cerrarModalAsignacion(id) {
        var modal = document.getElementById('modalAsignar' + id);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
    
    window.onclick = function(event) {
        if (event.target.classList && event.target.classList.contains('modal-custom')) {
            var modals = document.querySelectorAll('.modal-custom');
            modals.forEach(function(modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            });
        }
    }

    // Validador interactivo de grupos seleccionados en el cliente
    document.addEventListener('DOMContentLoaded', function () {
        const selectsGrupos = document.querySelectorAll('.select-grupos-max');
        selectsGrupos.forEach(function (select) {
            let opcionesPrevias = [];
            select.addEventListener('change', function () {
                const maximo = parseInt(this.getAttribute('data-max')) || 4;
                const opcionesSeleccionadas = Array.from(this.options).filter(opt => opt.selected);
                
                if (opcionesSeleccionadas.length > maximo) {
                    alert(`Solo puedes seleccionar un máximo de ${maximo} grupos para el docente.`);
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
@endsection