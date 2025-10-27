<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fritz C.A | Gestión de Stock de Equipos</title>

            <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const htmlElement = document.documentElement;
            
            if (savedTheme) {
                htmlElement.setAttribute('data-bs-theme', savedTheme);
            } else {
                // Tema por defecto
                const defaultTheme = 'light';
                localStorage.setItem('theme', defaultTheme);
                htmlElement.setAttribute('data-bs-theme', defaultTheme);
            }
        })();
    </script>
    
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
            width: 85px;
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
            background: linear-gradient(135deg, #ca36ddff 0%, #4615a1ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .description-badge {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
        }
        
        .stock-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
        }
        
        .available-badge {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            border: none;
        }
        
        .assigned-badge {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
        }
        
        .low-stock {
            background-color: #fff3cd !important;
            border-left: 4px solid #ffc107;
        }
        
        .critical-stock {
            background-color: #f8d7da !important;
            border-left: 4px solid #dc3545;
        }
        
        .currency {
            font-family: 'Courier New', monospace;
            font-weight: bold;
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
            
            <div class="text-center mb-4 py-3 border-bottom border-secondary">
            <center><img src="{{asset('img/logo-fritz-web.webp')}}" alt="logoo"  style="width: 65px; height: 50px;"></center>
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
                    <a class="nav-link text-white sidebar-link active" href="{{ route('stock_equipos.index') }}">
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
                    <a class="nav-link text-white sidebar-link" href="{{ route('equipos_asignados.index') }}">
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
                                <li class="breadcrumb-item active text-white" aria-current="page">Gestión de Stock de Equipos</li>
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
                            <i class="bi bi-box-seam me-2 text-danger"></i>
                            Gestión de Stock de Equipos
                        </h2>
                        <p class="text-muted mb-0">Administra el inventario de equipos tecnológicos</p>
                    </div>
                    <div>
                        <button class="btn btn-fritz" data-bs-toggle="modal" data-bs-target="#createStockEquipoModal">
                            <i class="bi bi-plus-circle me-1"></i> Nuevo Equipo
                        </button>
                    </div>
                </div>

                <!-- Alert Messages -->
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

                <!-- Resumen de Stock -->
  <div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- Contar el total de TODOS los equipos -->
                        <h4 class="mb-0">{{ \App\Models\stock_equipos::sum('cantidad_total') }}</h4>
                        <small>Total Equipos</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <!-- Contar el total disponible de TODOS los equipos -->
                        <h4 class="mb-0">{{ \App\Models\stock_equipos::sum('cantidad_disponible') }}</h4>
                        <small>Disponibles</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-3"></i>
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
                        <!-- Contar el total asignado de TODOS los equipos -->
                        <h4 class="mb-0">{{ \App\Models\stock_equipos::sum('cantidad_asignada') }}</h4>
                        <small>Asignados</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-person-check fs-3"></i>
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
                        <!-- Usar la variable del controlador que ya cuenta todos los equipos con stock bajo -->
                        <h4 class="mb-0">{{ $stockBajoCount }}</h4>
                        <small>Stock Bajo</small>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                
                <!-- Stock Equipos Management Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-list-ul me-2 text-danger"></i> Lista de Equipos en Stock
                            </h5>
                             <div class="dropdown">
    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-download me-1"></i> Exportar
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="#" onclick="generarPDFStock()">
                <i class="bi bi-file-pdf me-2"></i>Descargar PDF Stock
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" onclick="verPDFStock()">
                <i class="bi bi-eye me-2"></i>Ver PDF Stock
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
                                <input type="text" class="form-control form-control-sm" placeholder="Buscar por marca o modelo..." id="searchName">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="filterTipo">
                                    <option value="">Todos los tipos</option>
                                    @foreach($tipo_equipo as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="filterStock">
                                    <option value="">Todo el stock</option>
                                    <option value="bajo">Stock Bajo</option>
                                    <option value="critico">Stock Crítico</option>
                                </select>
                            </div>
                            <div class="col-md-3 ">
                                <button class="btn btn-sm me-2 " id="resetFilters" style="float:right; box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4);">
                                    <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de Stock de Equipos -->
                        <div class="table-responsive">
                            <table class="table table-hover" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50px">ID</th>
                                        <th>Equipo</th>
                                        <th>Tipo</th>
                                        <th>Stock</th>
                                        <th>Valor</th>
                                        <th>Fecha Adquisición</th>
                                        <th width="120px" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockEquipos as $equipo)
                                    <tr class="@if($equipo->cantidad_disponible <= $equipo->minimo_stock && $equipo->cantidad_disponible > 0) low-stock @endif @if($equipo->cantidad_disponible == 0) critical-stock @endif">
                                        <td class="fw-bold">{{ $equipo->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="equipo-icon me-3">
                                                    {{ strtoupper(substr($equipo->marca, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $equipo->marca }} {{ $equipo->modelo }}</div>
                                                    <small class="text-muted">{{ Str::limit($equipo->descripcion, 25) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary rounded-pill">
                                                {{ $equipo->tipoEquipo->nombre ?? 'Sin tipo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <span class="badge available-badge rounded-pill">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    {{ $equipo->cantidad_disponible }} Disp.
                                                </span>
                                                <span class="badge assigned-badge rounded-pill">
                                                    <i class="bi bi-person-check me-1"></i>
                                                    {{ $equipo->cantidad_asignada }} Asig.
                                                </span>
                                                <small class="text-muted">Mín: {{ $equipo->minimo_stock }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="currency">${{ number_format($equipo->valor_adquisicion, 2) }}</span>
                                        </td>
                                        <td>
                                            {{ $equipo->fecha_adquisicion->format('d/m/Y') }}
                                        </td>
                                        <td class="table-actions text-center">
                                            <button class="btn btn-sm btn-outline-info action-btn me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewStockEquipoModal"
                                                    onclick="viewStockEquipoData({{ $equipo }})"
                                                    title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning action-btn me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editStockEquipoModal"
                                                    onclick="loadStockEquipoData({{ $equipo }})"
                                                    title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger action-btn"
                                                    onclick="confirmDelete({{ $equipo->id }}, '{{ $equipo->marca }} {{ $equipo->modelo }}')"
                                                    title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                 <!-- Paginación -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Mostrando 
                                <strong>{{ $stockEquipos->firstItem() ?: 0 }}</strong> 
                                a 
                                <strong>{{ $stockEquipos->lastItem() ?: 0 }}</strong> 
                                de 
                                <strong>{{ $stockEquipos->total() }}</strong> 
                                equipos
                            </div>
                            
                            <nav aria-label="Paginación de stock de equipos">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- Enlace anterior -->
                                    <li class="page-item {{ $stockEquipos->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $stockEquipos->previousPageUrl() }}" aria-label="Anterior">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Enlaces de páginas -->
                                    @foreach ($stockEquipos->getUrlRange(1, $stockEquipos->lastPage()) as $page => $url)
                                        @if ($page == $stockEquipos->currentPage())
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
                                    <li class="page-item {{ !$stockEquipos->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $stockEquipos->nextPageUrl() }}" aria-label="Siguiente">
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

    <!-- Modal para Crear Stock de Equipo -->
    <div class="modal fade" id="createStockEquipoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-box-seam me-2"></i> Nuevo Equipo en Stock
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('stock_equipos.store') }}" method="POST" id="createStockEquipoForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Equipo*</label>
                                    <select class="form-select" name="tipo_equipo_id" required>
                                        <option value="">Seleccione un tipo</option>
                                        @foreach($tipo_equipo ?? [] as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Marca*</label>
                                    <input type="text" class="form-control" name="marca" required placeholder="Ingrese la marca">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Modelo*</label>
                                    <input type="text" class="form-control" name="modelo" required placeholder="Ingrese el modelo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Adquisición*</label>
                                    <input type="date" class="form-control" name="fecha_adquisicion" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cantidad Total*</label>
                                    <input type="number" class="form-control" name="cantidad_total" required min="0" id="cantidad_total">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cantidad Disponible*</label>
                                    <input type="number" class="form-control" name="cantidad_disponible" required min="0" id="cantidad_disponible">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cantidad Asignada*</label>
                                    <input type="number" class="form-control" name="cantidad_asignada" required min="0" id="cantidad_asignada" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stock Mínimo*</label>
                                    <input type="number" class="form-control" name="minimo_stock" required min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Valor Adquisición*</label>
                                    <input type="number" step="0.01" class="form-control" name="valor_adquisicion" required min="0" placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción del equipo"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-fritz">Guardar Equipo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Stock de Equipo -->
    <div class="modal fade" id="editStockEquipoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i> Editar Equipo en Stock
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editStockEquipoForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Equipo*</label>
                                    <select class="form-select" name="tipo_equipo_id" id="edit_tipo_equipo_id" required>
                                        <option value="">Seleccione un tipo</option>
                                        @foreach($tipo_equipo ?? [] as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Marca*</label>
                                    <input type="text" class="form-control" name="marca" id="edit_marca" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Modelo*</label>
                                    <input type="text" class="form-control" name="modelo" id="edit_modelo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Adquisición*</label>
                                    <input type="date" class="form-control" name="fecha_adquisicion" id="edit_fecha_adquisicion" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cantidad Total*</label>
                                    <input type="number" class="form-control" name="cantidad_total" id="edit_cantidad_total" required min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cantidad Disponible*</label>
                                    <input type="number" class="form-control" name="cantidad_disponible" id="edit_cantidad_disponible" required min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Cantidad Asignada*</label>
                                    <input type="number" class="form-control" name="cantidad_asignada" id="edit_cantidad_asignada" required min="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stock Mínimo*</label>
                                    <input type="number" class="form-control" name="minimo_stock" id="edit_minimo_stock" required min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Valor Adquisición*</label>
                                    <input type="number" step="0.01" class="form-control" name="valor_adquisicion" id="edit_valor_adquisicion" required min="0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar Equipo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Stock de Equipo -->
    <div class="modal fade" id="viewStockEquipoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-eye me-2"></i> Detalles del Equipo en Stock
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="equipo-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;" id="view_icon">
                            <!-- Icono se llena con JavaScript -->
                        </div>
                        <h4 id="view_marca_modelo"></h4>
                        <p class="text-muted" id="view_id"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID:</strong>
                            <p id="view_equipo_id" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tipo de Equipo:</strong>
                            <p id="view_tipo_equipo" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Marca:</strong>
                            <p id="view_marca" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Modelo:</strong>
                            <p id="view_modelo" class="mb-2"></p>
                        </div>
                        <div class="col-12">
                            <strong>Descripción:</strong>
                            <p id="view_descripcion" class="mb-2"></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Cantidad Total:</strong>
                            <p id="view_cantidad_total" class="mb-2"></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Cantidad Disponible:</strong>
                            <p id="view_cantidad_disponible" class="mb-2"></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Cantidad Asignada:</strong>
                            <p id="view_cantidad_asignada" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Stock Mínimo:</strong>
                            <p id="view_minimo_stock" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Valor Adquisición:</strong>
                            <p id="view_valor_adquisicion" class="mb-2 currency"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Adquisición:</strong>
                            <p id="view_fecha_adquisicion" class="mb-2"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Asignaciones:</strong>
                            <p id="view_asignaciones_count" class="mb-2"></p>
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
        // Función para calcular cantidad asignada automáticamente
        function calcularCantidadAsignada() {
            const total = parseInt(document.getElementById('cantidad_total').value) || 0;
            const disponible = parseInt(document.getElementById('cantidad_disponible').value) || 0;
            const asignada = total - disponible;
            document.getElementById('cantidad_asignada').value = asignada >= 0 ? asignada : 0;
        }

        // Función para calcular cantidad asignada en edición
        function calcularCantidadAsignadaEdit() {
            const total = parseInt(document.getElementById('edit_cantidad_total').value) || 0;
            const disponible = parseInt(document.getElementById('edit_cantidad_disponible').value) || 0;
            const asignada = total - disponible;
            document.getElementById('edit_cantidad_asignada').value = asignada >= 0 ? asignada : 0;
        }

        // Función para cargar datos en el modal de edición
        function loadStockEquipoData(equipo) {
            document.getElementById('editStockEquipoForm').action = `/stock_equipos/${equipo.id}`;
            document.getElementById('edit_tipo_equipo_id').value = equipo.tipo_equipo_id;
            document.getElementById('edit_marca').value = equipo.marca;
            document.getElementById('edit_modelo').value = equipo.modelo;
            document.getElementById('edit_descripcion').value = equipo.descripcion || '';
            document.getElementById('edit_cantidad_total').value = equipo.cantidad_total;
            document.getElementById('edit_cantidad_disponible').value = equipo.cantidad_disponible;
            document.getElementById('edit_cantidad_asignada').value = equipo.cantidad_asignada;
            document.getElementById('edit_minimo_stock').value = equipo.minimo_stock;
            document.getElementById('edit_fecha_adquisicion').value = equipo.fecha_adquisicion.split('T')[0];
            document.getElementById('edit_valor_adquisicion').value = equipo.valor_adquisicion;
        }

        // Función para cargar datos en el modal de visualización
        function viewStockEquipoData(equipo) {
            document.getElementById('view_icon').textContent = equipo.marca.charAt(0).toUpperCase();
            document.getElementById('view_marca_modelo').textContent = `${equipo.marca} ${equipo.modelo}`;
            document.getElementById('view_id').textContent = `ID: ${equipo.id}`;
            document.getElementById('view_equipo_id').textContent = equipo.id;
            document.getElementById('view_tipo_equipo').textContent = equipo.tipo_equipo ? equipo.tipo_equipo.nombre : 'Sin tipo';
            document.getElementById('view_marca').textContent = equipo.marca;
            document.getElementById('view_modelo').textContent = equipo.modelo;
            document.getElementById('view_descripcion').textContent = equipo.descripcion || 'Sin descripción';
            document.getElementById('view_cantidad_total').textContent = equipo.cantidad_total;
            document.getElementById('view_cantidad_disponible').textContent = equipo.cantidad_disponible;
            document.getElementById('view_cantidad_asignada').textContent = equipo.cantidad_asignada;
            document.getElementById('view_minimo_stock').textContent = equipo.minimo_stock;
            document.getElementById('view_valor_adquisicion').textContent = `$${parseFloat(equipo.valor_adquisicion).toFixed(2)}`;
            document.getElementById('view_fecha_adquisicion').textContent = new Date(equipo.fecha_adquisicion).toLocaleDateString('es-ES');
            document.getElementById('view_asignaciones_count').innerHTML = equipo.asignaciones_count ? 
                `<span class="badge bg-primary">${equipo.asignaciones_count} Asignaciones</span>` : 
                '<span class="badge bg-secondary">0 Asignaciones</span>';
            
            // Mostrar el modal
            $('#viewEquipoAsignadoModal').modal('show');
           
        }

        // Función para confirmar eliminación
        function confirmDelete(equipoId, equipoName) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Vas a eliminar el equipo "${equipoName}". Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear formulario de eliminación
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/stock_equipos/${equipoId}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }


        
        // Filtros y eventos
        $(document).ready(function() {
            // Eventos para calcular cantidades
            $('#cantidad_total, #cantidad_disponible').on('input', calcularCantidadAsignada);
            $('#edit_cantidad_total, #edit_cantidad_disponible').on('input', calcularCantidadAsignadaEdit);

            // Inicializar cálculos
            calcularCantidadAsignada();


            // Toggle del sidebar
            $('#sidebarToggle').click(function() {
                $('.sidebar').toggleClass('sidebar-collapsed');
                $(this).find('i').toggleClass('bi-chevron-double-left bi-chevron-double-right');
            });

            

            // Mobile sidebar toggle
            $('#mobileSidebarToggle').click(function() {
                $('.sidebar').toggleClass('sidebar-collapsed');
            });
        });

            // ===== FUNCIONES UNIVERSALES PARA EL TEMA =====
    function applySavedTheme() {
        const savedTheme = localStorage.getItem('theme');
        const htmlElement = document.documentElement;
        
        if (savedTheme) {
            htmlElement.setAttribute('data-bs-theme', savedTheme);
            
            const themeIcon = document.querySelector('.theme-switcher i');
            if (themeIcon) {
                if (savedTheme === 'dark') {
                    themeIcon.classList.remove('bi-moon-stars');
                    themeIcon.classList.add('bi-sun');
                } else {
                    themeIcon.classList.remove('bi-sun');
                    themeIcon.classList.add('bi-moon-stars');
                }
            }
        } else {
            localStorage.setItem('theme', 'light');
        }
    }

    function toggleTheme() {
        const htmlElement = document.documentElement;
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        const themeIcon = document.querySelector('.theme-switcher i');
        
        htmlElement.setAttribute('data-bs-theme', newTheme);
        
        if (themeIcon) {
            if (newTheme === 'dark') {
                themeIcon.classList.remove('bi-moon-stars');
                themeIcon.classList.add('bi-sun');
            } else {
                themeIcon.classList.remove('bi-sun');
                themeIcon.classList.add('bi-moon-stars');
            }
        }
        
        localStorage.setItem('theme', newTheme);
    }

    // ===== INICIALIZACIÓN =====
    document.addEventListener('DOMContentLoaded', function() {
        applySavedTheme();
        
        // Sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('sidebar-collapsed');
                
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-chevron-double-left');
                icon.classList.toggle('bi-chevron-double-right');
            });
        }

        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
            });
        }

        // Tema
        const themeSwitcher = document.querySelector('.theme-switcher');
        if (themeSwitcher) {
            themeSwitcher.addEventListener('click', toggleTheme);
        }
    });

        // ===== FUNCIONES UNIVERSALES PARA EL TEMA =====
    function applySavedTheme() {
        const savedTheme = localStorage.getItem('theme');
        const htmlElement = document.documentElement;
        
        if (savedTheme) {
            htmlElement.setAttribute('data-bs-theme', savedTheme);
            
            const themeIcon = document.querySelector('.theme-switcher i');
            if (themeIcon) {
                if (savedTheme === 'dark') {
                    themeIcon.classList.remove('bi-moon-stars');
                    themeIcon.classList.add('bi-sun');
                } else {
                    themeIcon.classList.remove('bi-sun');
                    themeIcon.classList.add('bi-moon-stars');
                }
            }
        } else {
            localStorage.setItem('theme', 'light');
        }
    }

    function toggleTheme() {
        const htmlElement = document.documentElement;
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        const themeIcon = document.querySelector('.theme-switcher i');
        
        htmlElement.setAttribute('data-bs-theme', newTheme);
        
        if (themeIcon) {
            if (newTheme === 'dark') {
                themeIcon.classList.remove('bi-moon-stars');
                themeIcon.classList.add('bi-sun');
            } else {
                themeIcon.classList.remove('bi-sun');
                themeIcon.classList.add('bi-moon-stars');
            }
        }
        
        localStorage.setItem('theme', newTheme);
    }

    // ===== INICIALIZACIÓN =====
    document.addEventListener('DOMContentLoaded', function() {
        applySavedTheme();
        
        // Sidebar - SOLO ESTA VERSIÓN (JavaScript puro)
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                const mainContent = document.querySelector('.main-content');
                
                sidebar.classList.toggle('sidebar-collapsed');
                
                // Si existe main-content, aplicar la clase correspondiente
                if (mainContent) {
                    mainContent.classList.toggle('main-content-expanded');
                }
                
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-chevron-double-left');
                icon.classList.toggle('bi-chevron-double-right');
            });
        }

        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        if (mobileSidebarToggle) {
            mobileSidebarToggle.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('sidebar-collapsed');
            });
        }

        // Tema
        const themeSwitcher = document.querySelector('.theme-switcher');
        if (themeSwitcher) {
            themeSwitcher.addEventListener('click', toggleTheme);
        }
    });

$(document).ready(function() {
    
    function applyFilters() {
        const nameFilter = $('#searchName').val().toLowerCase();
        const tipoFilter = $('#filterTipo').find('option:selected').text().toLowerCase();
        const stockFilter = $('#filterStock').val();
        
        $('table tbody tr').each(function() {
            const $row = $(this);
            const name = $row.find('td:eq(1) .fw-bold').text().toLowerCase();
            const tipo = $row.find('td:eq(2) .badge').text().toLowerCase();
            const tieneStockBajo = $row.hasClass('low-stock');
            const tieneStockCritico = $row.hasClass('critical-stock');
            
            let nameMatch = !nameFilter || name.includes(nameFilter);
            let tipoMatch = tipoFilter === 'todos los tipos' || tipo.includes(tipoFilter);
            let stockMatch = true;
            
            // Filtro por stock
            if (stockFilter === 'bajo') {
                stockMatch = tieneStockBajo;
            } else if (stockFilter === 'critico') {
                stockMatch = tieneStockCritico;
            }
            
            // Mostrar fila solo si TODOS los filtros coinciden
            if (nameMatch && tipoMatch && stockMatch) {
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
        $('#resultCount').text(`Mostrando ${visibleRows} de ${totalRows} equipos`);
    }

    // Event listeners
    $('#searchName').on('input', applyFilters);
    $('#filterTipo').change(applyFilters);
    $('#filterStock').change(applyFilters);

    $('#resetFilters').click(function() {
        $('#searchName').val('');
        $('#filterTipo').val('');
        $('#filterStock').val('');
        applyFilters();
    });

    // Inicializar
    updateResultCount();
});

    </script>

    <script>
function generarPDFStock() {
    const url = '{{ route("stock_equipos.generar-pdf") }}';
    window.location.href = url;
}

function verPDFStock() {
    const url = '{{ route("stock_equipos.ver-pdf") }}';
    window.open(url, '_blank');
}
</script>
</body>
</html>