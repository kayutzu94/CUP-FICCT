<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Postulantes - CUP FICCT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            margin: 20px;
            padding: 0;
            background: white;
        }
        
        /* Encabezado profesional */
        .header {
            margin-bottom: 25px;
            border-bottom: 3px solid #0a2b5e;
            padding-bottom: 15px;
        }
        .header-table {
            width: 100%;
        }
        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }
        .logo-cell {
            width: 80px;
            text-align: left;
        }
        .logo-cell img {
            width: 65px;
            height: auto;
        }
        .title-cell {
            text-align: center;
        }
        .title-cell h1 {
            color: #0a2b5e;
            font-size: 22px;
            margin: 0;
        }
        .title-cell h3 {
            color: #1a4a8a;
            font-size: 14px;
            margin: 5px 0 0;
        }
        .date-cell {
            width: 120px;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
        
        /* Resumen en una sola fila - 4 columnas */
        .summary-row {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .summary-row td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            background-color: #f8f9fc;
        }
        .summary-number {
            font-size: 22px;
            font-weight: bold;
            display: block;
        }
        .summary-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
            display: block;
        }
        .summary-total .summary-number { color: #0a2b5e; }
        .summary-aprobados .summary-number { color: #28a745; }
        .summary-reprobados .summary-number { color: #dc3545; }
        .summary-promedio .summary-number { color: #17a2b8; }
        
        /* Tabla */
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        th {
            background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);
            color: white;
            padding: 10px 8px;
            font-weight: bold;
            text-align: center;
        }
        td {
            border: 1px solid #e0e0e0;
            padding: 8px;
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Badges de estado */
        .badge-aprobado {
            background-color: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-reprobado {
            background-color: #dc3545;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-inscrito {
            background-color: #ffc107;
            color: #333;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #999;
        }
        .footer p {
            margin: 3px 0;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- ENCABEZADO PROFESIONAL -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('images/Escudo_FICCT.png') }}" alt="Escudo FICCT">
                </td>
                <td class="title-cell">
                    <h1>CUP FICCT</h1>
                    <h3>Curso Preuniversitario</h3>
                </td>
                <td class="date-cell">
                    <strong>Fecha:</strong><br>
                    {{ date('d/m/Y H:i:s') }}
                </td>
            </tr>
        </table>
    </div>

    <!-- RESUMEN EN UNA SOLA FILA (4 COLUMNAS) -->
    @php
        $total = $postulantes->count();
        $aprobados = $postulantes->where('estado_academico', 'aprobado')->count();
        $reprobados = $postulantes->where('estado_academico', 'reprobado')->count();
        $promedio = $postulantes->avg('promedio_final') ?? 0;
        $tasa = $total > 0 ? round(($aprobados / $total) * 100, 1) : 0;
    @endphp

    <table class="summary-row">
        <tr>
            <td class="summary-total">
                <span class="summary-number">{{ $total }}</span>
                <span class="summary-label">Total Postulantes</span>
            </td>
            <td class="summary-aprobados">
                <span class="summary-number">{{ $aprobados }}</span>
                <span class="summary-label">Aprobados</span>
            </td>
            <td class="summary-reprobados">
                <span class="summary-number">{{ $reprobados }}</span>
                <span class="summary-label">Reprobados</span>
            </td>
            <td class="summary-promedio">
                <span class="summary-number">{{ number_format($promedio, 2) }}</span>
                <span class="summary-label">Promedio General</span>
            </td>
        </tr>
    </table>

    <!-- TABLA DE POSTULANTES -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th width="8%">CI</th>
                    <th width="15%">Nombres</th>
                    <th width="15%">Apellidos</th>
                    <th width="18%">Email</th>
                    <th width="18%">Carrera Asignada</th>
                    <th width="8%">Promedio</th>
                    <th width="18%">Estado</th>
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
                    <td><strong>{{ number_format($p->promedio_final ?? 0, 2) }}</strong></td>
                    <td>
                        @if($p->estado_academico == 'aprobado')
                            <span class="badge-aprobado">APROBADO</span>
                        @elseif($p->estado_academico == 'reprobado')
                            <span class="badge-reprobado">REPROBADO</span>
                        @else
                            <span class="badge-inscrito">INSCRITO</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PIE DE PÁGINA -->
    <div class="footer">
        <p>Sistema de Admisión Universitaria - Facultad FICCT - UAGRM</p>
        <p>Santa Cruz - Bolivia</p>
    </div>
</body>
</html>