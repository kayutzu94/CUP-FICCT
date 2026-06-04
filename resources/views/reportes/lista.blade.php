@extends('layouts.app')
@section('title', 'Lista de Postulantes')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Lista General de Postulantes</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr><th>CI</th><th>Nombre</th><th>Email</th><th>Carrera</th><th>Estado</th></tr>
                </thead>
                <tbody>
                    @foreach($postulantes as $p)
                    <tr>
                        <td>{{ $p->ci }}</td>
                        <td>{{ $p->nombres }} {{ $p->apellidos }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->carreraAsignada->nombre ?? 'N/A' }}</td>
                        <td>{{ $p->estado_academico }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection