<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fritz C.A | Equipos Asignados</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --fritz-red: #DC2626;
            --fritz-red-light: #EF4444;
            --fritz-black: #1A1A1A;
            --fritz-white: #FFFFFF;
            --fritz-gray: #F5F5F5;
        }
        
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9));
            background-size: cover;
            background-position: center;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }
        
        .sidebar-collapsed {
            width: 80px;
        }
        
        .sidebar-collapsed .sidebar-text {
            display: none;
        }
        
        .sidebar-section {
            color: var(--fritz-red);
            font-size: 0.75rem;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .sidebar-link {
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s;
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(220, 38, 38, 0.2);
            transform: translateX(5px);
        }
        
        .navbar-brand {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: var(--fritz-black) !important;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: var(--fritz-black) !important;
        }
        
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.6rem;
        }
        
        .user-avatar {
            width: 35px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--fritz-red);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .action-btn {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .badge-rol {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 50px;
        }
        
        .badge-admin {
            background-color: var(--fritz-red);
        }
        
        .badge-tecnico {
            background-color: #3498db;
        }
        
        .badge-consulta {
            background-color: #2ecc71;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            .sidebar-text {
                display: none;
            }
        }
        
        .btn-fritz {
            background-color: var(--fritz-red);
            border: none;
            color: white;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            cursor: pointer;
        }
        
        .btn-fritz:hover {
            background-color: var(--fritz-red-light);
            transform: translateY(-2px);
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .bg-gradient-danger {
            background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
        }
        
        .sidebar-user-profile {
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .sidebar-user-profile:hover {
            background-color: rgba(220, 38, 38, 0.2);
        }
        
        .text-white-50 {
            color: rgba(255, 255, 255, 0.8);
        }

        .table-actions {
            white-space: nowrap;
        }

        .equipo-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(135deg, #274ebbff 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .estado-badge {
            font-size: 0.7rem;
            padding: 0.4em 0.8em;
            border-radius: 50px;
        }
        
        
        .estado-devuelto {
            background: linear-gradient(135deg, #5160a8ff 0%, #8046b9ff 100%);
            color: black;
        }
        
        .estado-activo {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: black;
        }
        
        .estado-obsoleto {
            background: linear-gradient(135deg, #949631ff 0%, #75881eff 100%);
            color: black;
        }

        .user-badge {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
        }

        .equipo-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: black;
            border: none;
        }

        .asignador-badge {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: black;
            border: none;
        }

        .obsoleto-row {
            background-color: #fff3cd !important;
            border-left: 4px solid #188032ff;
        }
        
        .devuelto-row {
            background-color: #d1ecf1 !important;
            border-left: 4px solid #17a2b8;
        }

        .pagination .page-link {
    color: #DC2626;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #DC2626;
    border-color: #DC2626;
    color: white;
}

.pagination .page-link:hover {
    color: #DC2626;
    background-color: #f8f9fa;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
}
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar text-white p-3 position-relative">
            <!-- Toggle Button -->
            <button id="sidebarToggle" class="btn btn-sm btn-outline-light position-absolute end-0 top-0 m-3">
                <i class="bi bi-chevron-double-left"></i>
            </button>
            
            <!-- Brand -->
            <div class="text-center mb-4 py-3 border-bottom border-secondary">
                <center><img src="{{asset('img/logo-fritz-web.webp')}}" alt="logoo"  style="width: 70px; height: 55px;"></center>
                <h4 class="mb-0 text-white fw-bold sidebar-text">FRITZ C.A</h4>
            <small class="text-white sidebar-text">Sistema de Gestión</small>
            </div>
            
            <!-- User Profile -->
            <div class="sidebar-user-profile d-flex align-items-center">
            <div class="user-avatar me-3">
                @auth
                    <div class="avatar-circle bg-gradient-danger text-white">
                        @php
                            $name = auth()->user()->name ?? 'Usuario';
                            $initials = collect(explode(' ', $name))
                                ->filter()
                                ->map(fn($word) => strtoupper(mb_substr($word, 0, 1)))
                                ->take(2)
                                ->implode('');
                        @endphp
                        {{ $initials ?: 'US' }}
                    </div>
                @else
                    <div class="avatar-circle bg-danger text-white">GU</div>
                @endauth
            </div>

            <div class="user-info text-white sidebar-text">
                @auth
                    <div class="fw-bold text-truncate" style="max-width: 150px;">
                        {{ auth()->user()->name ?? 'Usuario' }}
                    </div>
                    <small class="text-white-50 d-block">
                        {{ auth()->user()->activo ? 'Activo' : 'Inactivo' }}
                    </small>
                @else
                    <div class="fw-bold">Invitado</div>
                    <small class="text-white-50">No autenticado</small>
                @endauth
            </div>
        </div>
            
            <!-- Menu -->
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <br>
                    <a class="nav-link text-white sidebar-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> 
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                
                <!-- Sección de Gestión -->
                <li class="sidebar-section">
                    <i class="bi bi-gear me-1"></i> 
                    <span class="sidebar-text">Gestión</span>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link" href="{{ route('usuario.index') }}">
                        <i class="bi bi-person-vcard me-2"></i>
                        <span class="sidebar-text">TIC</span>
                    </a>
                </li>
             

                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link" href="{{ route('stock_equipos.index') }}">
                        <i class="bi bi-box-seam me-2"></i>
                        <span class="sidebar-text">Inventario</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link" href="{{ route('usuarios.index') }}">
                        <i class="bi bi-people-fill me-2"></i>
                        <span class="sidebar-text">Usuarios</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link" href="{{ route('sedes.index') }}">
                        <i class="bi bi-building me-2"></i>
                        <span class="sidebar-text">Sedes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link" href="{{ route('departamentos.index') }}">
                        <i class="bi bi-person-badge me-2"></i>
                        <span class="sidebar-text">Departamentos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link" href="{{ route('tipo_equipo.index') }}">
                        <i class="bi bi-boxes me-2"></i>
                        <span class="sidebar-text">Categorías</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link active" href="{{ route('equipos_asignados.index') }}">
                        <i class="bi bi-laptop me-2"></i>
                        <span class="sidebar-text">Equipos Asignados</span>
                    </a>
                </li>
            </ul>
            
            <!-- Bottom -->
            <div class="mt-auto p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-sm btn-outline-light theme-switcher" title="Cambiar tema">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="sidebar-text">Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <button class="btn btn-sm btn-outline-light me-2 d-lg-none" id="mobileSidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <div class="d-flex align-items-center">
                        <span class="navbar-brand me-3 d-none d-lg-block">
                            <i class="bi bi-tools me-2 text-white"></i> FRITZ C.A
                        </span>
                        
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-white">Dashboard</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Gestión de Equipos Asignados</li>
                            </ol>
                        </nav>
                    </div>
                    
             
                </div>
            </nav>
            
            <!-- Main Content Area -->
            <main class="p-4">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-0">
                            <i class="bi bi-laptop me-2 text-danger"></i>
                            Gestión de Equipos Asignados
                        </h2>
                        <p class="text-muted mb-0">Administra las asignaciones de equipos a usuarios</p>
                    </div>
                    <div>
                        <button class="btn btn-fritz" data-bs-toggle="modal" data-bs-target="#createEquipoAsignadoModal">
                            <i class="bi bi-plus-circle me-1"></i> Nueva Asignación
                        </button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Resumen de Asignaciones -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- Contar solo las activas de TODOS los registros -->
                        <h4 class="mb-0">{{ \App\Models\EquipoAsignado::where('estado', 'activo')->count() }}</h4>
                        <small>Asignaciones Activas</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-laptop fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- Contar solo las devueltas de TODOS los registros -->
                        <h4 class="mb-0">{{ \App\Models\EquipoAsignado::where('estado', 'devuelto')->count() }}</h4>
                        <small>Devueltos</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-arrow-return-left fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- Contar solo las obsoletas de TODOS los registros -->
                        <h4 class="mb-0">{{ \App\Models\EquipoAsignado::where('estado', 'obsoleto')->count() }}</h4>
                        <small>Obsoletos</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- TOTAL GENERAL (todos los estados) -->
                        <h4 class="mb-0">{{ \App\Models\EquipoAsignado::count() }}</h4>
                        <small>Total Registros</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-archive fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                
                <!-- Equipos Asignados Management Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-list-ul me-2 text-danger"></i> Lista de Equipos Asignados
                            </h5>
                            <div class="dropdown">
    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-download me-1"></i> Exportar
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="#" onclick="generarPDFAsignaciones()">
                <i class="bi bi-file-pdf me-2"></i>Descargar PDF Asignaciones
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" onclick="verPDFAsignaciones()">
                <i class="bi bi-eye me-2"></i>Ver PDF Asignaciones
            </a>
        </li>

         <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="abrirModalSeleccionUsuario()">
                            <i class="bi bi-person me-2"></i>PDF por Usuario
                        </a>
                    </li>

                    
    </ul>
    
</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtros -->
                        <div class="row mb-4 g-2">
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Buscar por usuario ..." id="searchName">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Buscar por equipo..." id="searchEquipo">
                            </div>

                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="filterEstado">
                                    <option value="">Todos los estados</option>
                                    <option value="asignado">Activo</option>
                                    
                                    <option value="devuelto">Devuelto</option>
                                    
                                    <option value="obsoleto">Obsoleto</option>
                                </select>
                            </div>
                           
                            <div class="col-md-3 text-end">
                                 <button class="btn btn-sm me-2 " id="resetFilters" style="float:right; box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4);">
                                    <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                                </button>
                                
                            </div>
                        </div>

                        <!-- Tabla de Equipos Asignados -->
                        <div class="table-responsive">
                            <table class="table table-hover" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50px">ID</th>
                                        <th>Usuario</th>
                                        <th>Equipo</th>
                                        <th>Fecha Asignación</th>
                                        <th>Estado</th>
                                        <th>Asignado Por</th>
                                        <th width="140px" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equiposAsignados as $asignacion)
                                    <tr class="@if($asignacion->estado == 'obsoleto') obsoleto-row @endif @if($asignacion->estado == 'devuelto') devuelto-row @endif">
                                        <td class="fw-bold">{{ $asignacion->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="equipo-icon me-3">
                                                    {{ strtoupper(substr($asignacion->usuarios->nombre ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $asignacion->usuarios->nombre ?? 'N/A' }} {{ $asignacion->usuarios->apellido ?? '' }}</div>
                                                    <small class="text-muted">{{ $asignacion->usuarios->cargo ?? 'Sin cargo' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge equipo-badge rounded-pill">
                                                <i class="bi bi-pc me-1"></i>
                                                {{ $asignacion->stock_equipo->marca ?? 'N/A' }} {{ $asignacion->stock_equipo->modelo ?? '' }}
                                            </span>
                                            @if($asignacion->ip_equipo)
                                            <small class="d-block text-muted">
                                                <i class="bi bi-hdd-network me-1"></i>{{ $asignacion->ip_equipo }}
                                            </small>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="d-block">
                                                {{ $asignacion->fecha_asignacion->format('d/m/Y') }}
                                            </small>
                                            @if($asignacion->fecha_devolucion)
                                            <small class="d-block text-muted">
                                                Dev: {{ $asignacion->fecha_devolucion->format('d/m/Y') }}
                                            </small>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $estadoClass = 'estado-' . str_replace('_', '-', $asignacion->estado);
                                            @endphp
                                            <span class="badge estado-badge {{ $estadoClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $asignacion->estado)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge asignador-badge rounded-pill">
                                                <i class="bi bi-person-check me-1"></i>
                                                {{ $asignacion->usuarioAsignador->name ?? 'Sistema' }}
                                            </span>
                                        </td>
                                        <td class="table-actions text-center">
                                            <button class="btn btn-sm btn-outline-info action-btn me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewEquipoAsignadoModal"
                                                    onclick="viewEquipoAsignadoData({{ $asignacion }})"
                                                    title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @if($asignacion->estado != 'obsoleto')
                                            <button class="btn btn-sm btn-outline-warning action-btn me-1" 
        data-bs-toggle="modal" 
        data-bs-target="#editEquipoAsignadoModal"
        data-id="{{ $asignacion->id }}"
        data-usuario="{{ $asignacion->usuarios_id }}"
        data-equipo="{{ $asignacion->stock_equipos_id }}"
        data-fecha="{{ $asignacion->fecha_asignacion->format('Y-m-d') }}"
        data-estado="{{ $asignacion->estado }}"
        data-ip="{{ $asignacion->ip_equipo }}"
        data-devolucion="{{ $asignacion->fecha_devolucion ? $asignacion->fecha_devolucion->format('Y-m-d') : '' }}"
        data-observaciones="{{ $asignacion->observaciones }}"
        onclick="loadEquipoAsignadoData(this)"
        title="Editar">
    <i class="bi bi-pencil"></i>
</button>
                                            @endif
                                            @if($asignacion->estado != 'devuelto' && $asignacion->estado != 'obsoleto')
                                            <button class="btn btn-sm btn-outline-success action-btn me-1"
                                                    onclick="devolverEquipo({{ $asignacion->id }})"
                                                    title="Devolver">
                                                <i class="bi bi-arrow-return-left"></i>
                                            </button>
                                            @endif
                                            @if($asignacion->estado != 'obsoleto')
                                            <button class="btn btn-sm btn-outline-danger action-btn"
                                                    onclick="confirmDelete({{ $asignacion->id }}, '{{ $asignacion->usuarioAsignado->nombre ?? 'N/A' }} - {{ $asignacion->stockEquipo->marca ?? 'N/A' }}')"
                                                    title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    <!-- Modal para seleccionar usuario para PDF -->
<div class="modal fade" id="seleccionUsuarioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person me-2"></i> Generar PDF por Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Seleccione un usuario:</label>
                    <select class="form-select" id="usuarioSeleccionado">
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">
                                {{ $usuario->nombre }} {{ $usuario->apellido }} - {{ $usuario->cargo }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="generarPDFUsuarioSeleccionado()">
                    <i class="bi bi-download me-1"></i> Descargar PDF
                </button>
                <button type="button" class="btn btn-info text-white" onclick="verPDFUsuarioSeleccionado()">
                    <i class="bi bi-eye me-1"></i> Ver PDF
                </button>
            </div>
        </div>
    </div>
</div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                      <!-- Paginación -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Mostrando 
                                <strong>{{ $equiposAsignados->firstItem() ?: 0 }}</strong> 
                                a 
                                <strong>{{ $equiposAsignados->lastItem() ?: 0 }}</strong> 
                                de 
                                <strong>{{ $equiposAsignados->total() }}</strong> 
                                asignaciones
                            </div>
                            
                            <nav aria-label="Paginación de equipos asignados">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- Enlace anterior -->
                                    <li class="page-item {{ $equiposAsignados->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $equiposAsignados->previousPageUrl() }}" aria-label="Anterior">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Enlaces de páginas -->
                                    @foreach ($equiposAsignados->getUrlRange(1, $equiposAsignados->lastPage()) as $page => $url)
                                        @if ($page == $equiposAsignados->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                    
                                    <!-- Enlace siguiente -->
                                    <li class="page-item {{ !$equiposAsignados->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $equiposAsignados->nextPageUrl() }}" aria-label="Siguiente">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Fin Paginación -->

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal para Crear Asignación -->
    <div class="modal fade" id="createEquipoAsignadoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-laptop me-2"></i> Nueva Asignación de Equipo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('equipos_asignados.store') }}" method="POST" id="createEquipoAsignadoForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Usuario*</label>
        <select class="form-select" name="usuarios_id" required>
            <option value="">Seleccione un usuario</option>
            @foreach($usuarios as $usuario) 
                <option value="{{ $usuario->id }}">{{ $usuario->nombre }} {{ $usuario->apellido }} - {{ $usuario->cargo }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Equipo*</label>
        <select class="form-select" name="stock_equipos_id" id="create_stock_equipos_id" required>
            <option value="">Seleccione un equipo</option>
            @foreach($stock_equipos as $equipo) 
                <option value="{{ $equipo->id }}" 
                        data-requiere-ip="{{ $equipo->tipoEquipo->requiere_ip ?? 1 }}">
                    {{ $equipo->marca }} {{ $equipo->modelo }} ({{ $equipo->cantidad_disponible }} disp.)
                </option>
            @endforeach
        </select>
    </div>
</div>                       <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha de Asignación*</label>
                                    <input type="date" class="form-control" name="fecha_asignacion" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Estado*</label>
        <select class="form-select" name="estado" required>
            <option value="activo">Activo</option>
            <option value="devuelto">Devuelto</option>
            <option value="obsoleto">Obsoleto</option>
        </select>
    </div>
</div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">IP del Equipo</label>
                                    <input type="text" class="form-control" name="ip_equipo" placeholder="Ej: 192.168.1.100" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha de Devolución</label>
                                    <input type="date" class="form-control" name="fecha_devolucion">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <textarea class="form-control" name="observaciones" rows="3" placeholder="Observaciones sobre la asignación"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-fritz">Guardar Asignación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Asignación -->
    <div class="modal fade" id="editEquipoAsignadoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i> Editar Asignación de Equipo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editEquipoAsignadoForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Usuario*</label>
        <select class="form-select" name="usuarios_id" id="edit_usuarios_id" required>
            <option value="">Seleccione un usuario</option>
            @foreach($usuarios as $usuario)  
                <option value="{{ $usuario->id }}">{{ $usuario->nombre }} {{ $usuario->apellido }} - {{ $usuario->cargo }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Equipo*</label>
        <select class="form-select" name="stock_equipos_id" id="edit_stock_equipos_id" required>
            <option value="">Seleccione un equipo</option>
            @foreach($stock_equipos as $equipo)  
                <option value="{{ $equipo->id }}" 
                        data-requiere-ip="{{ $equipo->tipoEquipo->requiere_ip ?? 1 }}">
                    {{ $equipo->marca }} {{ $equipo->modelo }} ({{ $equipo->cantidad_disponible }} disp.)
                </option>
            @endforeach
        </select>
    </div>
</div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha de Asignación*</label>
                                    <input type="date" class="form-control" name="fecha_asignacion" id="edit_fecha_asignacion" required>
                                </div>
                            </div>
                            <div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Estado*</label>
        <select class="form-select" name="estado" id="edit_estado" required>
            <option value="activo">Activo</option>
            <option value="devuelto">Devuelto</option>
            <option value="obsoleto">Obsoleto</option>
        </select>
    </div>
</div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">IP del Equipo</label>
                                    <input type="text" class="form-control" name="ip_equipo" id="edit_ip_equipo" placeholder="Ej: 192.168.1.100">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha de Devolución</label>
                                    <input type="date" class="form-control" name="fecha_devolucion" id="edit_fecha_devolucion">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <textarea class="form-control" name="observaciones" id="edit_observaciones" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar Asignación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Asignación -->
    <div class="modal fade" id="viewEquipoAsignadoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-eye me-2"></i> Detalles de la Asignación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="equipo-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;" id="view_icon">
                            <!-- Icono se llena con JavaScript -->
                        </div>
                        <h4 id="view_titulo"></h4>
                        <p class="text-muted" id="view_id"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID:</strong>
                            <p id="view_asignacion_id" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Estado:</strong>
                            <p id="view_estado" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Usuario Asignado:</strong>
                            <p id="view_usuario" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Equipo:</strong>
                            <p id="view_equipo" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Asignación:</strong>
                            <p id="view_fecha_asignacion" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Devolución:</strong>
                            <p id="view_fecha_devolucion" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>IP del Equipo:</strong>
                            <p id="view_ip_equipo" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Asignado Por:</strong>
                            <p id="view_asignado_por" class="mb-2"></p>
                        </div>
                        <div class="col-12">
                            <strong>Observaciones:</strong>
                            <p id="view_observaciones" class="mb-2"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    // Función para cargar datos en el modal de edición
function loadEquipoAsignadoData(button) {
    const id = button.getAttribute('data-id');
    document.getElementById('editEquipoAsignadoForm').action = `/equipos_asignados/${id}`;
    document.getElementById('edit_usuarios_id').value = button.getAttribute('data-usuario');
    document.getElementById('edit_stock_equipos_id').value = button.getAttribute('data-equipo');
    document.getElementById('edit_fecha_asignacion').value = button.getAttribute('data-fecha');
    document.getElementById('edit_estado').value = button.getAttribute('data-estado');
    document.getElementById('edit_ip_equipo').value = button.getAttribute('data-ip');
    document.getElementById('edit_fecha_devolucion').value = button.getAttribute('data-devolucion');
    document.getElementById('edit_observaciones').value = button.getAttribute('data-observaciones');
    
    // Aplicar toggle del campo IP después de cargar los datos
    setTimeout(() => {
        const editSelect = document.getElementById('edit_stock_equipos_id');
        if (editSelect && editSelect.value) {
            toggleIPFieldBasedOnSelection(editSelect, true);
        }
    }, 100);
}

// Función para toggle del campo IP basado en data attribute
function toggleIPFieldBasedOnSelection(selectElement, isEditModal = false) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const requiereIP = selectedOption.getAttribute('data-requiere-ip') === '1';
    
    console.log('Toggle IP Field:', {
        selectedValue: selectElement.value,
        requiereIP: requiereIP,
        isEditModal: isEditModal
    });
    
    // Determinar qué campo IP usar según el modal
    let ipField, ipLabel;
    if (isEditModal) {
        ipField = document.getElementById('edit_ip_equipo');
        ipLabel = ipField ? ipField.closest('.mb-3') : null;
    } else {
        ipField = document.querySelector('[name="ip_equipo"]');
        ipLabel = ipField ? ipField.closest('.mb-3') : null;
    }
    
    if (ipField && ipLabel) {
        if (requiereIP) {
            ipLabel.style.display = 'block';
            ipField.required = true;
        } else {
            ipLabel.style.display = 'none';
            ipField.value = ''; // Limpiar el valor cuando se oculta
            ipField.required = false;
        }
    }
}

// Función para cargar datos en el modal de visualización 
function viewEquipoAsignadoData(asignacion) {
    console.log('=== DEBUG ASIGNACIÓN ===');
    console.log('Asignación completa:', asignacion);
    console.log('Usuario relación:', asignacion.usuarios);
    console.log('Stock relación:', asignacion.stock_equipo);
    console.log('Usuario asignador:', asignacion.usuario);
    console.log('======================');
    
    // Icono - usar primera letra del nombre del usuario
    let inicial = 'A';
    if (asignacion.usuarios && asignacion.usuarios.nombre) {
        inicial = asignacion.usuarios.nombre.charAt(0).toUpperCase();
    }
    document.getElementById('view_icon').textContent = inicial;
    
    document.getElementById('view_titulo').textContent = `Asignación #${asignacion.id}`;
    document.getElementById('view_id').textContent = `ID: ${asignacion.id}`;
    document.getElementById('view_asignacion_id').textContent = asignacion.id;
    
    // Estado
    const estadoClass = `estado-${asignacion.estado}`;
    const estadoTexto = asignacion.estado.charAt(0).toUpperCase() + asignacion.estado.slice(1);
    document.getElementById('view_estado').innerHTML = `<span class="badge estado-badge ${estadoClass}">${estadoTexto}</span>`;
    
    // Usuario asignado
    let usuarioTexto = 'N/A';
    if (asignacion.usuarios) {
        const usuario = asignacion.usuarios;
        usuarioTexto = `${usuario.nombre || ''} ${usuario.apellido || ''}`.trim();
        if (usuario.cargo) {
            usuarioTexto += ` - ${usuario.cargo}`;
        }
        if (usuarioTexto === '') {
            usuarioTexto = 'Usuario sin nombre';
        }
    }
    document.getElementById('view_usuario').textContent = usuarioTexto;
    
    // Equipo 
    let equipoTexto = 'N/A';
    if (asignacion.stock_equipo) {
        const equipo = asignacion.stock_equipo;
        equipoTexto = `${equipo.marca || ''} ${equipo.modelo || ''}`.trim();
        
        // Tipo de equipo
        let tipoEquipo = '';
        if (equipo.tipo_equipo && equipo.tipo_equipo.nombre) {
            tipoEquipo = equipo.tipo_equipo.nombre;
        } else if (equipo.tipoEquipo && equipo.tipoEquipo.nombre) {
            tipoEquipo = equipo.tipoEquipo.nombre;
        }
        
        if (tipoEquipo) {
            equipoTexto += ` (${tipoEquipo})`;
        }
    }
    document.getElementById('view_equipo').textContent = equipoTexto;
    
    // Fechas
    document.getElementById('view_fecha_asignacion').textContent = new Date(asignacion.fecha_asignacion).toLocaleDateString('es-ES');
    document.getElementById('view_fecha_devolucion').textContent = asignacion.fecha_devolucion ? 
        new Date(asignacion.fecha_devolucion).toLocaleDateString('es-ES') : 'No devuelto';
    
    // IP
    document.getElementById('view_ip_equipo').textContent = asignacion.ip_equipo || 'No asignada';
    
    // Asignado por
    let asignadorTexto = 'Sistema';
    if (asignacion.usuario) {
        asignadorTexto = asignacion.usuario.name || 'Usuario';
    }
    document.getElementById('view_asignado_por').textContent = asignadorTexto;
    
    // Observaciones
    document.getElementById('view_observaciones').textContent = asignacion.observaciones || 'Sin observaciones';
    
    // Mostrar el modal
    $('#viewEquipoAsignadoModal').modal('show');
}

// Función para devolver equipo
function devolverEquipo(asignacionId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas marcar este equipo como devuelto?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, devolver',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/equipos_asignados/${asignacionId}/devolver`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Función para confirmar eliminación
function confirmDelete(asignacionId, asignacionName) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `Vas a eliminar la asignación "${asignacionName}". Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/equipos_asignados/${asignacionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data) {
                    Swal.fire('Éxito', data.message || 'Asignación eliminada correctamente', 'success')
                    .then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un problema al eliminar la asignación', 'error');
            });
        }
    });
}

// Inicialización cuando el documento está listo
$(document).ready(function() {
    
    // Filtros de la tabla
    function applyFilters() {
        const nameFilter = $('#searchName').val().toLowerCase();
        const equipoFilter = $('#searchEquipo').val().toLowerCase();
        const estadoFilter = $('#filterEstado').val();
        
        $('table tbody tr').each(function() {
            const $row = $(this);
            const name = $row.find('td:eq(1) .fw-bold').text().toLowerCase();
            const equipo = $row.find('td:eq(2) .badge.equipo-badge').text().toLowerCase();
            const estado = $row.find('td:eq(4) .badge').text().toLowerCase().replace(/\s+/g, '');
            
            let nameMatch = !nameFilter || name.includes(nameFilter);
            let equipoMatch = !equipoFilter || equipo.includes(equipoFilter);
            let estadoMatch = !estadoFilter || estado === estadoFilter;
            
            // Mostrar fila solo si TODOS los filtros coinciden
            if (nameMatch && equipoMatch && estadoMatch) {
                $row.show();
            } else {
                $row.hide();
            }
        });
        
        updateResultCount();
    }

    function updateResultCount() {
        const visibleRows = $('table tbody tr:visible').length;
        const totalRows = $('table tbody tr').length;
        $('#resultCount').text(`Mostrando ${visibleRows} de ${totalRows} registros`);
    }

    // Event listeners para filtros
    $('#searchName').on('input', applyFilters);
    $('#searchEquipo').on('input', applyFilters);
    $('#filterEstado').change(applyFilters);

    $('#resetFilters').click(function() {
        $('#searchName').val('');
        $('#searchEquipo').val('');
        $('#filterEstado').val('');
        applyFilters();
    });

    // Inicializar
    updateResultCount();

    // Event listeners para los selects de equipos
    document.getElementById('create_stock_equipos_id')?.addEventListener('change', function() {
        toggleIPFieldBasedOnSelection(this, false);
    });

    document.getElementById('edit_stock_equipos_id')?.addEventListener('change', function() {
        toggleIPFieldBasedOnSelection(this, true);
    });

    // Para cuando se abre el modal de edición
    $('#editEquipoAsignadoModal').on('show.bs.modal', function() {
        setTimeout(() => {
            const editSelect = document.getElementById('edit_stock_equipos_id');
            if (editSelect && editSelect.value) {
                toggleIPFieldBasedOnSelection(editSelect, true);
            }
        }, 100);
    });

    // Para cuando se abre el modal de crear
    $('#createEquipoAsignadoModal').on('show.bs.modal', function() {
        // Resetear el select de crear
        const createSelect = document.getElementById('create_stock_equipos_id');
        if (createSelect) {
            createSelect.value = '';
            toggleIPFieldBasedOnSelection(createSelect, false);
        }
    });

    // Toggle del sidebar
    $('#sidebarToggle').click(function() {
        $('.sidebar').toggleClass('sidebar-collapsed');
        $(this).find('i').toggleClass('bi-chevron-double-left bi-chevron-double-right');
    });

    // Mobile sidebar toggle
    $('#mobileSidebarToggle').click(function() {
        $('.sidebar').toggleClass('sidebar-collapsed');
    });

    // Cambiar tema
    $('.theme-switcher').click(function() {
        $('html').attr('data-bs-theme', 
            $('html').attr('data-bs-theme') === 'dark' ? 'light' : 'dark');
        $(this).find('i').toggleClass('bi-moon-stars bi-sun');
    });
});
function abrirModalSeleccionUsuario() {
    $('#seleccionUsuarioModal').modal('show');
}

function generarPDFUsuarioSeleccionado() {
    const usuarioId = document.getElementById('usuarioSeleccionado').value;
    if (usuarioId) {
        generarPDFUsuario(usuarioId);
        $('#seleccionUsuarioModal').modal('hide');
    } else {
        Swal.fire('Error', 'Por favor seleccione un usuario', 'error');
    }
}

function verPDFUsuarioSeleccionado() {
    const usuarioId = document.getElementById('usuarioSeleccionado').value;
    if (usuarioId) {
        verPDFUsuario(usuarioId);
        $('#seleccionUsuarioModal').modal('hide');
    } else {
        Swal.fire('Error', 'Por favor seleccione un usuario', 'error');
    }
}

function generarPDFUsuario(usuarioId) {
    const url = `/equipos_asignados/usuario/${usuarioId}/pdf`;
    window.location.href = url;
}

function verPDFUsuario(usuarioId) {
    const url = `/equipos_asignados/usuario/${usuarioId}/ver-pdf`;
    window.open(url, '_blank');
}


function generarPDFAsignaciones() {
    const url = '{{ route("equipos_asignados.generar-pdf") }}';
    window.location.href = url;
}

function verPDFAsignaciones() {
    const url = '{{ route("equipos_asignados.ver-pdf") }}';
    window.open(url, '_blank');
}
    </script>
</body>
</html>