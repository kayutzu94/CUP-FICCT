@extends('layouts.app')

@section('title', 'Importar Usuarios')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-users"></i> Importación de Usuarios (Docentes/Coordinadores)</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="alert alert-info">
                <strong>📄 Formato del archivo CSV:</strong>
                <ul class="mb-0 mt-2">
                    <li><strong>ci</strong> - Cédula de identidad (obligatorio, único)</li>
                    <li><strong>nombres</strong> - Nombres (obligatorio)</li>
                    <li><strong>apellidos</strong> - Apellidos (obligatorio)</li>
                    <li><strong>email</strong> - Correo electrónico (obligatorio, único)</li>
                    <li><strong>telefono</strong> - Teléfono de contacto</li>
                    <li><strong>profesion</strong> - Profesión (obligatorio)</li>
                    <li><strong>especialidad</strong> - Especialidad (obligatorio)</li>
                    <li><strong>tiene_maestria</strong> - 1 o 0 (maestría)</li>
                    <li><strong>tiene_diplomado_educacion</strong> - 1 o 0 (diplomado)</li>
                </ul>
            </div>

            <div class="alert alert-warning">
                <strong>⚠️ Nota:</strong> Los usuarios importados podrán iniciar sesión con su <strong>CI como contraseña</strong>.
            </div>

            <form method="POST" action="{{ route('importacion.usuarios.import') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Seleccionar Archivo CSV/Excel</label>
                        <input type="file" name="archivo" class="form-control" accept=".csv,.xlsx,.xls" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rol a Importar</label>
                        <select name="rol" class="form-control" required>
                            <option value="">Seleccione un rol</option>
                            <option value="docente">Docente</option>
                            <option value="coordinador">Coordinador Académico</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <a href="{{ route('importacion.plantilla-usuarios') }}" class="btn btn-secondary">
                        <i class="fas fa-download"></i> Descargar Plantilla CSV
                    </a>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Importar Usuarios
                </button>
                <a href="{{ route('importacion.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </form>
        </div>
    </div>
</div>
@endsection