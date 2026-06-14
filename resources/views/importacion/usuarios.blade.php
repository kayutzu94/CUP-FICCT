@extends('layouts.app')

@section('title', 'Importar Usuarios')

@section('content')
<div class="container-fluid px-0 py-2">
    
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-3 p-3">
            <i class="fas fa-check-circle fa-lg me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center mb-3 p-3">
            <i class="fas fa-exclamation-circle fa-lg me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-users fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Importación de Usuarios</h4>
                    <p class="mb-0 text-white-50 small mt-1">Carga masiva de perfiles administrativos para Docentes y Coordinadores</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-12 col-lg-7 order-2 order-lg-1">
                    <form method="POST" action="{{ route('importacion.usuarios.import') }}" enctype="multipart/form-data" class="bg-white p-3 rounded-3 border shadow-2xs">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-dark fw-medium small">Seleccionar Archivo CSV/Excel</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border text-muted"><i class="fas fa-file-csv"></i></span>
                                    <input type="file" name="archivo" class="form-control border font-size-sm" accept=".csv,.xlsx,.xls" required>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="form-label text-dark fw-medium small">Rol a Importar</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border text-muted"><i class="fas fa-user-shield"></i></span>
                                    <select name="rol" class="form-select border font-size-sm" required>
                                        <option value="">Seleccione un rol</option>
                                        <option value="docente">Docente</option>
                                        <option value="coordinador">Coordinador Académico</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning border-0 rounded-3 bg-warning bg-opacity-10 text-dark mt-3 p-3 d-flex align-items-center">
                            <i class="fas fa-shield-alt text-warning fa-lg me-2.5"></i>
                            <span class="small">⚠️ <strong>Nota de acceso:</strong> Los usuarios cargados podrán autenticarse inmediatamente utilizando su número de <strong>CI como contraseña por defecto</strong>.</span>
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('importacion.plantilla-usuarios') }}" class="btn btn-outline-secondary font-size-sm px-3 py-2 rounded-3 fw-medium w-100 w-sm-auto text-center">
                                <i class="fas fa-download me-1"></i> Descargar Plantilla CSV
                            </a>
                            <div class="d-flex gap-2 w-100 w-sm-auto justify-content-end">
                                <a href="{{ route('importacion.index') }}" class="btn btn-secondary border-0 font-size-sm px-3 py-2 rounded-3">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="submit" class="btn btn-action font-size-sm px-4 py-2 rounded-3 fw-bold shadow-sm hover-up">
                                    <i class="fas fa-upload me-1"></i> Importar Usuarios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-lg-5 order-1 order-lg-2">
                    <div class="card h-100 border-0 bg-light bg-opacity-70 rounded-3 p-3">
                        <h5 class="fw-bold text-primary-custom mb-3 font-size-md d-flex align-items-center">
                            <i class="fas fa-file-code me-2 opacity-75"></i> Estructura y Parámetros
                        </h5>
                        <p class="text-secondary small mb-2">Para asegurar el mapeo correcto en la base de datos de la facultad, verifique que los encabezados del archivo coincidan exactamente con la siguiente estructura:</p>
                        
                        <div class="table-responsive rounded-3 border bg-white shadow-2xs">
                            <table class="table table-sm table-hover mb-0 align-middle font-size-xs">
                                <thead class="table-dark font-size-2xs">
                                    <tr>
                                        <th class="py-2 px-2.5">Columna</th>
                                        <th class="py-2">Restricción / Formato</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">ci</td><td class="text-danger fw-medium"><i class="fas fa-asterisk font-size-3xs me-1"></i>Obligatorio, único</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">nombres</td><td class="text-danger fw-medium"><i class="fas fa-asterisk font-size-3xs me-1"></i>Obligatorio</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">apellidos</td><td class="text-danger fw-medium"><i class="fas fa-asterisk font-size-3xs me-1"></i>Obligatorio</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">email</td><td class="text-danger fw-medium"><i class="fas fa-asterisk font-size-3xs me-1"></i>Obligatorio, único</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">telefono</td><td class="text-muted">Opcional / Numérico</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">profesion</td><td class="text-danger fw-medium"><i class="fas fa-asterisk font-size-3xs me-1"></i>Obligatorio</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">especialidad</td><td class="text-danger fw-medium"><i class="fas fa-asterisk font-size-3xs me-1"></i>Obligatorio</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">tiene_maestria</td><td class="text-primary-custom fw-semibold">Boolean (1 = Sí, 0 = No)</td></tr>
                                    <tr><td class="px-2.5 font-monospace fw-bold text-dark">tiene_diplomado_educacion</td><td class="text-primary-custom fw-semibold">Boolean (1 = Sí, 0 = No)</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

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
    
    .btn-action {
        background-color: #0a2b5e;
        color: white;
    }
    .btn-action:hover {
        background-color: #143f7d;
        color: white;
    }

    /* Utilidades de espaciado y fuentes */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .font-size-3xs { font-size: 0.6rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush
@endsection