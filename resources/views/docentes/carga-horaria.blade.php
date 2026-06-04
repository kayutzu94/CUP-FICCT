@extends('layouts.app')
@section('title', 'Mi Carga Horaria')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Mi Carga Horaria - {{ $docente->nombre_completo }}</h4>
    </div>
    <div class="card-body">
        @if($cargaHoraria->isEmpty())
            <div class="alert alert-warning">No tienes horarios asignados aún.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Día</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Grupo</th>
                            <th>Materia</th>
                            <th>Aula</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cargaHoraria as $horario)
                        <tr>
                            <td>{{ $horario->dia }}</td>
                            <td>{{ $horario->hora_inicio }}