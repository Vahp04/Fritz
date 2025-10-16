<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Usuarios - FRITZ C.A</title>
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
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
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
            font-size: 9px;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>FRITZ C.A</h1>
        <div class="subtitle">Reporte de Usuarios y Equipos Asignados</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Fecha de generación:</span>
            <span>{{ $fechaGeneracion }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de usuarios:</span>
            <span>{{ $totalUsuarios }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Usuarios con equipos activos:</span>
            <span>{{ $totalConEquipos }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Usuarios sin equipos activos:</span>
            <span>{{ $totalSinEquipos }}</span>
        </div>
    </div>

    @php
        // Manejar si $usuarios es array o colección
        $usuariosCount = is_array($usuarios) ? count($usuarios) : $usuarios->count();
    @endphp

    @if($usuariosCount > 0)
    <table class="table">
        <thead>
            <tr>
                <!--<th>ID</th>-->
                <th>Usuario</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>RDP</th>
                <th>Sede</th>
                <th>Departamento</th>
                <th class="text-center">Eq. Totales</th>
                <th class="text-center">Eq. Activos</th>
                <th class="text-center">Eq. Devueltos</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            @php
                // Convertir a objeto si es array
                $user = is_array($usuario) ? (object)$usuario : $usuario;
            @endphp
            <tr>
              <!--  <td>{{ $user->id ?? 'N/A' }}</td>-->
                <td>{{ $user->nombre ?? 'N/A' }} {{ $user->apellido ?? '' }}</td>
                <td>{{ $user->cargo ?? 'N/A' }}</td>
                <td>{{ $user->correo ?? 'N/A' }}</td>
                <td>{{ $user->RDP ?? 'N/A' }}</td>
                <td>
                    @if(is_object($user->sede ?? null))
                        {{ $user->sede->nombre ?? 'N/A' }}
                    @else
                        {{ $user->sede ?? 'N/A' }}
                    @endif
                </td>
                <td>
                    @if(is_object($user->departamento ?? null))
                        {{ $user->departamento->nombre ?? 'N/A' }}
                    @else
                        {{ $user->departamento ?? 'N/A' }}
                    @endif
                </td>
                <td class="text-center">{{ $user->equipos_totales_count ?? 0 }}</td>
                <td class="text-center">{{ $user->equipos_activos_count ?? 0 }}</td>
                <td class="text-center">{{ $user->equipos_devueltos_count ?? 0 }}</td>
                <td class="text-center">
                    @php
                        $equiposActivos = $user->equipos_activos_count ?? 0;
                        $equiposTotales = $user->equipos_totales_count ?? 0;
                    @endphp
                    @if($equiposActivos > 0)
                        <span class="badge badge-success">Con equipos</span>
                    @elseif($equiposTotales > 0)
                        <span class="badge badge-warning">Solo devueltos</span>
                    @else
                        <span class="badge badge-secondary">Sin equipos</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        <h3>No hay usuarios registrados</h3>
    </div>
    @endif

    <div class="footer">
        <div>Sistema de Gestión - FRITZ C.A</div>
        <div>Generado el {{ $fechaGeneracion }}</div>
    </div>
</body>
</html>