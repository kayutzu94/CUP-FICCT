@extends('layouts.app')

@section('title', 'Exportar Reportes')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h4><i class="fas fa-download"></i> Exportar Reportes</h4>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            Seleccione el formato en el que desea exportar el reporte de postulantes.
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <i class="fas fa-file-excel fa-5x text-success"></i>
                        <h5 class="mt-3">Exportar a Excel</h5>
                        <p class="text-muted">Exporta la lista completa de postulantes a formato CSV (compatible con Excel)</p>
                        <a href="{{ route('export.excel') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-download"></i> Descargar Excel
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="card text-center border-danger">
                    <div class="card-body">
                        <i class="fas fa-file-pdf fa-5x text-danger"></i>
                        <h5 class="mt-3">Exportar a PDF</h5>
                        <p class="text-muted">Exporta la lista completa de postulantes a formato PDF</p>
                        <a href="{{ route('export.pdf') }}" class="btn btn-danger btn-lg">
                            <i class="fas fa-download"></i> Descargar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <i class="fas fa-chart-line"></i>
                    <strong>¿Necesitas estadísticas detalladas?</strong>
                    <a href="{{ route('reportes.estadisticas') }}" class="btn btn-sm btn-info ms-3">
                        <i class="fas fa-chart-pie"></i> Ver Estadísticas por Materia
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection