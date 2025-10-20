<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Stock de Equipos - FRITZ C.A</title>
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
        }
        .info-section {
            margin-bottom: 15px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        .stat-card {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #DC2626;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
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
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background: #e9ecef;
            border-radius: 5px;
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
        .text-right {
            text-align: right;
        }
        .stock-bajo {
            background-color: #fff3cd !important;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FRITZ C.A</h1>
        <div class="subtitle">Reporte de Stock de Equipos</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Fecha de generación:</span>
            <span>{{ $fechaGeneracion }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de equipos en inventario:</span>
            <span>{{ $stockEquipos->count() }} tipos diferentes</span>
        </div>
    </div>

    <!-- Estadísticas principales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ number_format($totalEquipos) }}</div>
            <div class="stat-label">Total de Equipos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($totalDisponible) }}</div>
            <div class="stat-label">Disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($totalAsignado) }}</div>
            <div class="stat-label">Asignados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stockBajoCount) }}</div>
            <div class="stat-label">Stock Bajo</div>
        </div>
    </div>

    <!-- Distribución por tipo -->
    <div class="summary">
        <h4 style="margin: 0 0 10px 0;">Distribución por Tipo de Equipo</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
            @foreach($equiposPorTipo as $tipo => $cantidad)
            <div style="background: white; padding: 8px; border-radius: 4px; border-left: 4px solid #DC2626;">
                <strong>{{ $tipo }}</strong>: {{ $cantidad }} equipos
            </div>
            @endforeach
        </div>
    </div>

    @php
        $stockCount = is_array($stockEquipos) ? count($stockEquipos) : $stockEquipos->count();
    @endphp

    @if($stockCount > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Descripción</th>
                <th class="text-center">Total</th>
                <th class="text-center">Disponible</th>
                <th class="text-center">Asignado</th>
                <th class="text-center">Mínimo</th>
                <th class="text-center">Estado</th>
                <th class="text-right">Valor</th>
                <th>Fecha Adq.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockEquipos as $equipo)
            @php
                $equipoObj = is_array($equipo) ? (object)$equipo : $equipo;
                $esStockBajo = $equipoObj->cantidad_disponible <= $equipoObj->minimo_stock;
            @endphp
            <tr class="@if($esStockBajo) stock-bajo @endif">
                <td>{{ $equipoObj->tipoEquipo->nombre ?? 'N/A' }}</td>
                <td>{{ $equipoObj->marca ?? 'N/A' }}</td>
                <td>{{ $equipoObj->modelo ?? 'N/A' }}</td>
                <td>{{ $equipoObj->descripcion ?? 'Sin descripción' }}</td>
                <td class="text-center">{{ $equipoObj->cantidad_total ?? 0 }}</td>
                <td class="text-center">{{ $equipoObj->cantidad_disponible ?? 0 }}</td>
                <td class="text-center">{{ $equipoObj->cantidad_asignada ?? 0 }}</td>
                <td class="text-center">{{ $equipoObj->minimo_stock ?? 0 }}</td>
                <td class="text-center">
                    @php
                        $disponible = $equipoObj->cantidad_disponible ?? 0;
                        $minimo = $equipoObj->minimo_stock ?? 0;
                    @endphp
                    @if($disponible == 0)
                        <span class="badge badge-danger">Agotado</span>
                    @elseif($disponible <= $minimo)
                        <span class="badge badge-warning">Stock Bajo</span>
                    @else
                        <span class="badge badge-success">Disponible</span>
                    @endif
                </td>
                <td class="text-right">${{ number_format($equipoObj->valor_adquisicion ?? 0, 2, ',', '.') }}</td>
                <td>{{ isset($equipoObj->fecha_adquisicion) ? \Carbon\Carbon::parse($equipoObj->fecha_adquisicion)->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen financiero -->
    <div class="summary">
        <div class="info-row">
            <span class="info-label">Valor total del inventario:</span>
            <span class="info-label">${{ number_format($valorTotal, 2, ',', '.') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Equipos con stock bajo:</span>
            <span>{{ $stockBajoCount }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tasa de asignación:</span>
            <span>{{ $totalEquipos > 0 ? number_format(($totalAsignado / $totalEquipos) * 100, 1) : 0 }}%</span>
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        <h3>No hay equipos en stock</h3>
    </div>
    @endif

    <div class="footer">
        <div>Sistema de Gestión - FRITZ C.A</div>
        <div>Generado el {{ $fechaGeneracion }}</div>
    </div>
</body>
</html>