<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Postulantes</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Sistema CUP FICCT</h2>
        <h3>Reporte de Postulantes</h3>
        <p>Fecha: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>CI</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Carrera Asignada</th>
                <th>Promedio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postulantes as $p)
            <tr>
                <td>{{ $p->ci }}</td>
                <td>{{ $p->nombres }}</td>
                <td>{{ $p->apellidos }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->carreraAsignada->nombre ?? 'Pendiente' }}</td>
                <td>{{ number_format($p->promedio_final ?? 0, 2) }}</td>
                <td>
                    @if($p->estado_academico == 'aprobado')
                        APROBADO
                    @elseif($p->estado_academico == 'reprobado')
                        REPROBADO
                    @else
                        INSCRITO
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Total de postulantes: {{ $postulantes->count() }}</p>
        <p>Generado por Sistema CUP FICCT</p>
    </div>
</body>
</html>