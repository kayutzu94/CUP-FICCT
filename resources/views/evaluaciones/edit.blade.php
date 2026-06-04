@extends('layouts.app')
@section('title', 'Registrar Notas')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Registrar Notas - {{ $materia->nombre }}</h4>
                <small>Postulante: {{ $postulante->nombre_completo }}</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('evaluaciones.update', [$postulante, $materia]) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Examen 1 (0-100)</label>
                        <input type="number" step="0.01" min="0" max="100" name="examen1" class="form-control" value="{{ $evaluacion->examen1 }}">
                    </div>
                    <div class="mb-3">
                        <label>Examen 2 (0-100)</label>
                        <input type="number" step="0.01" min="0" max="100" name="examen2" class="form-control" value="{{ $evaluacion->examen2 }}">
                    </div>
                    <div class="mb-3">
                        <label>Examen 3 (0-100)</label>
                        <input type="number" step="0.01" min="0" max="100" name="examen3" class="form-control" value="{{ $evaluacion->examen3 }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Notas</button>
                    <a href="{{ route('evaluaciones.index', $postulante) }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            let val = parseFloat(this.value);
            if (val > 100) this.value = 100;
            if (val < 0) this.value = 0;
        });
    });
</script>
@endpush
@endsection