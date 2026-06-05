@extends('layouts.app')

@section('title', 'Importar Datos')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-upload"></i> Importación de Datos</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <!-- Importar Postulantes -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-users"></i> Importar Postulantes</h5>
                        </div>
                        <div class="card-body">
                            <p>Importa postulantes desde un archivo CSV/Excel.</p>
                            <p><strong>Formato requerido:</strong> CI, nombres, apellidos, email, primera_carrera, segunda_carrera</p>
                            <form method="POST" action="{{ route('importacion.import') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" name="archivo" class="form-control" accept=".csv,.xlsx,.xls" required>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-upload"></i> Importar Postulantes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Importar Usuarios -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-user-plus"></i> Importar Usuarios</h5>
                        </div>
                        <div class="card-body">
                            <p>Importa docentes o coordinadores desde un archivo CSV/Excel.</p>
                            <p><strong>Formato requerido:</strong> CI, nombres, apellidos, email, profesion, especialidad</p>
                            <a href="{{ route('importacion.usuarios') }}" class="btn btn-info">
                                <i class="fas fa-arrow-right"></i> Ir a Importar Usuarios
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-3">
                <strong>📌 Nota:</strong> Descarga la plantilla de ejemplo desde la sección "Importar Usuarios" para conocer el formato exacto.
            </div>
        </div>
    </div>
</div>
@endsection