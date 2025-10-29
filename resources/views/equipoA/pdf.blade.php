<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Equipos Asignados - FRITZ C.A</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #DC2626;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #DC2626;
            margin: 0;
            font-size: 24px;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #333;
        }
    
      .stats-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .stats-table td {
            padding: 3px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        .stats-number {
            font-size: 18px;
            font-weight: bold;
            color: #DC2626;
            display: block;
        }
        .stats-label {
            font-size: 10px;
            color: #666;
            display: block;
            margin-top: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9px;
        }
        .table th {
            background-color: #DC2626;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table td {
            padding: 6px;
            border: 1px solid #ddd;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .text-center {
            text-align: center;
        }
        .activo-row {
            background-color: #d4edda !important;
        }
        .devuelto-row {
            background-color: #d1ecf1 !important;
        }
        .obsoleto-row {
            background-color: #fff3cd !important;
        }
        .distribution-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FRITZ C.A</h1>
        <div class="subtitle">Reporte de Equipos Asignados</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Fecha de generación:</span>
            <span>{{ $fechaGeneracion }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de asignaciones:</span>
            <span>{{ $totalAsignaciones }}</span>
        </div>
    </div>

    <!-- Estadísticas principales - Diseño tipo tabla -->
    <table class="stats-table">
        <tr>
            <td>
                <span class="stats-number">{{ $asignacionesActivas }}</span>
                <span class="stats-label">Activas</span>
            </td>
            <td>
                <span class="stats-number">{{ $asignacionesDevueltas }}</span>
                <span class="stats-label">Devueltas</span>
            </td>
            <td>
                <span class="stats-number">{{ $asignacionesObsoletas }}</span>
                <span class="stats-label">Obsoletas</span>
            </td>
            <td>
                <span class="stats-number">{{ $totalAsignaciones }}</span>
                <span class="stats-label">Total</span>
            </td>
        </tr>
    </table>

    <!-- Distribución por tipo de equipo -->
    <div class="summary">
        <div class="distribution-title">Distribución por Tipo de Equipo</div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
            @foreach($asignacionesPorTipo as $tipo => $cantidad)
            <div style="background: white; padding: 8px; border-radius: 4px; border-left: 4px solid #DC2626;">
                <strong>{{ $tipo }}</strong>: {{ $cantidad }} asignaciones
            </div>
            @endforeach
        </div>
    </div>

    @php
        $asignacionesCount = is_array($equiposAsignados) ? count($equiposAsignados) : $equiposAsignados->count();
    @endphp

    @if($asignacionesCount > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Cargo</th>
                <th>Sede</th>
                <th>Departamento</th>
                <th>Equipo</th>
                <th>Tipo</th>
                <th>Fecha Asignación</th>
                <th>Fecha Devolución</th>
                <th>IP Equipo</th>
                <th>Asignado Por</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equiposAsignados as $asignacion)
            @php
                // Convertir a objeto si es array
                $asig = is_array($asignacion) ? (object)$asignacion : $asignacion;
                $estadoClass = '';
                if ($asig->estado == 'activo') {
                    $estadoClass = 'activo-row';
                } elseif ($asig->estado == 'devuelto') {
                    $estadoClass = 'devuelto-row';
                } elseif ($asig->estado == 'obsoleto') {
                    $estadoClass = 'obsoleto-row';
                }
            @endphp
            <tr class="{{ $estadoClass }}">
                <td>{{ $asig->usuarios->nombre ?? 'N/A' }} {{ $asig->usuarios->apellido ?? '' }}</td>
                <td>{{ $asig->usuarios->cargo ?? 'N/A' }}</td>
                <td>{{ $asig->usuarios->sede->nombre ?? 'N/A' }}</td>
                <td>{{ $asig->usuarios->departamento->nombre ?? 'N/A' }}</td>
                <td>{{ $asig->stock_equipo->marca ?? 'N/A' }} {{ $asig->stock_equipo->modelo ?? '' }}</td>
                <td>{{ $asig->stock_equipo->tipoEquipo->nombre ?? 'N/A' }}</td>
                <td>{{ isset($asig->fecha_asignacion) ? \Carbon\Carbon::parse($asig->fecha_asignacion)->format('d/m/Y') : 'N/A' }}</td>
                <td>
                    @if($asig->fecha_devolucion)
                        {{ \Carbon\Carbon::parse($asig->fecha_devolucion)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $asig->ip_equipo ?? '-' }}</td>
                <td>{{ $asig->usuario->name ?? 'Sistema' }}</td>
                <td class="text-center">
                    @php
                        $estado = $asig->estado ?? 'desconocido';
                    @endphp
                    @if($estado == 'activo')
                        <span class="badge badge-success">Activo</span>
                    @elseif($estado == 'devuelto')
                        <span class="badge badge-secondary">Devuelto</span>
                    @elseif($estado == 'obsoleto')
                        <span class="badge badge-warning">Obsoleto</span>
                    @else
                        <span class="badge badge-danger">{{ ucfirst($estado) }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen final -->
    <div class="summary">
        <div class="info-row">
            <span class="info-label">Total de asignaciones activas:</span>
            <span>{{ $asignacionesActivas }} ({{ $totalAsignaciones > 0 ? number_format(($asignacionesActivas / $totalAsignaciones) * 100, 1) : 0 }}%)</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de asignaciones devueltas:</span>
            <span>{{ $asignacionesDevueltas }} ({{ $totalAsignaciones > 0 ? number_format(($asignacionesDevueltas / $totalAsignaciones) * 100, 1) : 0 }}%)</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de asignaciones obsoletas:</span>
            <span>{{ $asignacionesObsoletas }} ({{ $totalAsignaciones > 0 ? number_format(($asignacionesObsoletas / $totalAsignaciones) * 100, 1) : 0 }}%)</span>
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        <h3>No hay equipos asignados</h3>
    </div>
    @endif

    <div class="footer">
        <div>Sistema de Gestión - FRITZ C.A</div>
        <div>Generado el {{ $fechaGeneracion }}</div>
    </div>
</body>
</html>