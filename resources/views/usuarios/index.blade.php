<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fritz C.A | Gestión de Usuarios</title>

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

        .user-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .sede-badge {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
        }

        .departamento-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
        }

        .equipo-badge {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border: none;
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

.email-cell {
    max-width: 200px; /* Ajusta este valor según necesites */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Para que se vea bien en el modal de ver */
#view_correo {
    word-break: break-all;
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
                    <a class="nav-link text-white sidebar-link" href="{{ route('stock_equipos.index') }}">
                        <i class="bi bi-box-seam me-2"></i>
                        <span class="sidebar-text">Inventario</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white sidebar-link active" href="{{ route('usuarios.index') }}">
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
                                <li class="breadcrumb-item active text-white" aria-current="page">Gestión de Usuarios</li>
                            </ol>
                        </nav>
                    </div>
                    
                    <!--<div class="d-flex align-items-center">
                        
                        <div class="dropdown">
                            
                                <div class="user-avatar me-1">
                                    @auth
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @else
                                        G
                                    @endauth
                                </div>
                        </div>
                    </div>-->
                </div>
            </nav>
            
            <!-- Main Content Area -->
            <main class="p-4">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-0">
                            <i class="bi bi-people-fill me-2 text-danger"></i>
                            Gestión de Usuarios
                        </h2>
                        <p class="text-muted mb-0">Administra los usuarios del sistema</p>
                    </div>
                    <div>
                        <button class="btn btn-fritz" data-bs-toggle="modal" data-bs-target="#createUsuarioModal">
                            <i class="bi bi-plus-circle me-1"></i> Nuevo Usuario
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
                
                <!-- Usuario Management Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-list-ul me-2 text-danger"></i> Lista de Usuarios
                            </h5>
<div class="dropdown">
    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-download me-1"></i> Exportar
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="#" onclick="generarPDF()">
                <i class="bi bi-file-pdf me-2"></i>Descargar PDF
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#" onclick="verPDF()">
                <i class="bi bi-eye me-2"></i>Ver PDF
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
                                <input type="text" class="form-control form-control-sm" placeholder="Buscar por Nombre ..." id="searchName">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Buscar por Cargo..." id="searchCargo">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Buscar por Sede o Departamento..." id="searchSede">
                            </div>
                            <div class="col-md-3 ">
                                <button class="btn btn-sm me-2 " id="resetFilters" style="float:right; box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4);">
                                    <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de Usuarios -->
                        <div class="table-responsive">
                            <table class="table table-hover" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50px">ID</th>
                                        <th>Usuario</th>
                                        <th>Cargo</th>
                                        <th>Contacto</th>
                                        <th>Sede & Departamento</th>
                                        <th>Equipos</th>
                                        <th width="120px" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                    <tr>
                                        <td class="fw-bold">{{ $usuario->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-icon me-3">
                                                    {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                                                    <small class="text-muted">RDP: {{ $usuario->RDP }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $usuario->cargo }}
                                            </span>
                                        </td>
                                        <td>
    <small class="d-block email-cell" title="{{ $usuario->correo }}">
        <i class="bi bi-envelope me-1"></i>{{ $usuario->correo }}
    </small>
</td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <span class="badge sede-badge rounded-pill">
                                                    <i class="bi bi-building me-1"></i>
                                                    {{ $usuario->sede->nombre ?? 'Sin sede' }}
                                                </span>
                                                <span class="badge departamento-badge rounded-pill">
                                                    <i class="bi bi-person-badge me-1"></i>
                                                    {{ $usuario->departamento->nombre ?? 'Sin departamento' }}
                                                </span>
                                            </div>
                                        </td>
                                       <td>
    @php
        $equiposActivos = $usuario->equipos_activos_count ?? 0;
        $equiposDevueltos = $usuario->equipos_devueltos_count ?? 0;
    @endphp
    
    <span class="badge equipo-badge rounded-pill">
        <i class="bi bi-laptop me-1"></i>
        {{ $equiposActivos }} Equipos
    </span>
    @if($equiposDevueltos > 0)
    <small class="d-block text-muted mt-1">
        {{ $equiposDevueltos }} devueltos
    </small>
    @endif
</td>
                                        <td class="table-actions text-center">
                                            <button class="btn btn-sm btn-outline-info action-btn me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewUsuarioModal"
                                                    onclick="viewUsuarioData({{ $usuario }})"
                                                    title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning action-btn me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editUsuarioModal"
                                                    onclick="loadUsuarioData({{ $usuario }})"
                                                    title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger action-btn"
                                                    onclick="confirmDelete({{ $usuario->id }}, '{{ $usuario->nombre }} {{ $usuario->apellido }}')"
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
                                <strong>{{ $usuarios->firstItem() ?: 0 }}</strong> 
                                a 
                                <strong>{{ $usuarios->lastItem() ?: 0 }}</strong> 
                                de 
                                <strong>{{ $usuarios->total() }}</strong> 
                                usuarios
                            </div>
                            
                            <nav aria-label="Paginación de usuarios">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- Enlace anterior -->
                                    <li class="page-item {{ $usuarios->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $usuarios->previousPageUrl() }}" aria-label="Anterior">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Enlaces de páginas -->
                                    @foreach ($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url)
                                        @if ($page == $usuarios->currentPage())
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
                                    <li class="page-item {{ !$usuarios->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $usuarios->nextPageUrl() }}" aria-label="Siguiente">
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

    <!-- Modal para Crear Usuario -->
    <div class="modal fade" id="createUsuarioModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus me-2"></i> Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('usuarios.store') }}" method="POST" id="createUsuarioForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required placeholder="Ingrese el nombre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" class="form-control" name="apellido" required placeholder="Ingrese el apellido">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cargo</label>
                                    <input type="text" class="form-control" name="cargo" required placeholder="Ingrese el cargo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Correo Electrónico*</label>
                                    <input type="email" class="form-control" name="correo" required placeholder="Ingrese el correo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">RDP*</label>
                                    <input type="text" class="form-control" name="RDP" required placeholder="Ingrese el RDP">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Sede*</label>
                                    <select class="form-select" name="sede_id" required>
                                        <option value="">Seleccione una sede</option>
                                        @foreach($sedes ?? [] as $sede)
                                            <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Departamento*</label>
                                    <select class="form-select" name="departamento_id" required>
                                        <option value="">Seleccione un departamento</option>
                                        @foreach($departamentos ?? [] as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-fritz">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Usuario -->
    <div class="modal fade" id="editUsuarioModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i> Editar Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUsuarioForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombre*</label>
                                    <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Apellido*</label>
                                    <input type="text" class="form-control" name="apellido" id="edit_apellido" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cargo*</label>
                                    <input type="text" class="form-control" name="cargo" id="edit_cargo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Correo Electrónico*</label>
                                    <input type="email" class="form-control" name="correo" id="edit_correo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">RDP*</label>
                                    <input type="text" class="form-control" name="RDP" id="edit_rdp" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Sede*</label>
                                    <select class="form-select" name="sede_id" id="edit_sede_id" required>
                                        <option value="">Seleccione una sede</option>
                                        @foreach($sedes ?? [] as $sede)
                                            <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Departamento*</label>
                                    <select class="form-select" name="departamento_id" id="edit_departamento_id" required>
                                        <option value="">Seleccione un departamento</option>
                                        @foreach($departamentos ?? [] as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Usuario -->
    <div class="modal fade" id="viewUsuarioModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-eye me-2"></i> Detalles del Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="user-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;" id="view_icon">
                        </div>
                        <h4 id="view_nombre_completo"></h4>
                        <p class="text-muted" id="view_id"></p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <strong>ID:</strong>
                            <p id="view_usuario_id" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Cargo:</strong>
                            <p id="view_cargo" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>RDP:</strong>
                            <p id="view_rdp" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Correo:</strong>
                            <p id="view_correo" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Sede:</strong>
                            <p id="view_sede" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Departamento:</strong>
                            <p id="view_departamento" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Equipos Asignados:</strong>
                            <p id="view_equipos_count" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Fecha de Registro:</strong>
                            <p id="view_created" class="mb-2"></p>
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
        function loadUsuarioData(usuario) {
            document.getElementById('editUsuarioForm').action = `/usuarios/${usuario.id}`;
            document.getElementById('edit_nombre').value = usuario.nombre;
            document.getElementById('edit_apellido').value = usuario.apellido;
            document.getElementById('edit_cargo').value = usuario.cargo;
            document.getElementById('edit_correo').value = usuario.correo;
            document.getElementById('edit_rdp').value = usuario.RDP;
            document.getElementById('edit_sede_id').value = usuario.sede_id;
            document.getElementById('edit_departamento_id').value = usuario.departamento_id;
        }

// Función para cargar datos en el modal de visualización
function viewUsuarioData(usuario) {
    document.getElementById('view_icon').textContent = usuario.nombre.charAt(0).toUpperCase();
    document.getElementById('view_nombre_completo').textContent = `${usuario.nombre} ${usuario.apellido}`;
    document.getElementById('view_id').textContent = `ID: ${usuario.id}`;
    document.getElementById('view_usuario_id').textContent = usuario.id;
    document.getElementById('view_cargo').textContent = usuario.cargo;
    document.getElementById('view_rdp').textContent = usuario.RDP;
    document.getElementById('view_correo').textContent = usuario.correo;
    document.getElementById('view_sede').textContent = usuario.sede ? usuario.sede.nombre : 'Sin sede';
    document.getElementById('view_departamento').textContent = usuario.departamento ? usuario.departamento.nombre : 'Sin departamento';

    const equiposActivos = usuario.equipos_activos_count || 0;
    const equiposDevueltos = usuario.equipos_devueltos_count || 0;
    const equiposTotales = usuario.equipos_totales_count || 0;
    
    let equiposHTML = '';
    if (equiposActivos > 0) {
        equiposHTML = `<span class="badge bg-success">${equiposActivos} Activos</span>`;
        if (equiposDevueltos > 0) {
            equiposHTML += `<br><small class="text-muted">${equiposDevueltos} Devueltos</small>`;
        }
    } else {
        equiposHTML = '<span class="badge bg-secondary">0 Equipos Activos</span>';
        if (equiposDevueltos > 0) {
            equiposHTML += `<br><small class="text-muted">${equiposDevueltos} Devueltos</small>`;
        }
    }
    
    document.getElementById('view_equipos_count').innerHTML = equiposHTML;
    document.getElementById('view_created').textContent = new Date(usuario.created_at).toLocaleDateString('es-ES');
    
    $('#viewUsuarioModal').modal('show');
}

        

        // Función para confirmar eliminación
        function confirmDelete(usuarioId, usuarioName) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Vas a eliminar al usuario "${usuarioName}". Esta acción no se puede deshacer.`,
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
                    form.action = `/usuarios/${usuarioId}`;
                    
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

        
$(document).ready(function() {
    
    function applyFilters() {
        const nameFilter = $('#searchName').val().toLowerCase();
        const cargoFilter = $('#searchCargo').val().toLowerCase();
        const sedeFilter = $('#searchSede').val().toLowerCase();
        const statusFilter = $('#searchStatus').val();
        
        $('table tbody tr').each(function() {
            const $row = $(this);
            const name = $row.find('td:eq(1) .fw-bold').text().toLowerCase();
            const cargo = $row.find('td:eq(2)').text().toLowerCase();
            const sede = $row.find('td:eq(4)').text().toLowerCase();
            const statusBadge = $row.find('td:eq(3) .badge');
            const isActive = statusBadge.hasClass('bg-success') || statusBadge.text().includes('Activo');
            
            let nameMatch = name.includes(nameFilter);
            let cargoMatch = cargo.includes(cargoFilter);
            let sedeMatch = sede.includes(sedeFilter);
            let statusMatch = true;
            
            if (statusFilter !== '') {
                if (statusFilter === '1') {
                    statusMatch = isActive;
                } else if (statusFilter === '0') {
                    statusMatch = !isActive;
                }
            }
            
            if (nameMatch && cargoMatch && sedeMatch && statusMatch) {
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
        $('#resultCount').text(`Mostrando ${visibleRows} de ${totalRows} usuarios`);
    }

    

    // Event listeners para todos los filtros
    $('#searchName').on('input', applyFilters);
    $('#searchCargo').on('input', applyFilters);
    $('#searchStatus').change(applyFilters);
    $('#searchSede').on('input', applyFilters);
    $('#applyFilters').click(applyFilters);

    $('#resetFilters').click(function() {
        $('#searchName').val('');
        $('#searchCargo').val('');
        $('#searchStatus').val('');
        $('#searchSede').val('');
        applyFilters();
    });

    // Inicializar contador
    updateResultCount();
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

    </script>

    <script>
function generarPDF() {
  
      const url = '{{ route("usuarios.generar-pdf") }}';
    window.location.href = url;
}

function verPDF() {
    const url = '{{ route("usuarios.ver-pdf") }}';
    window.open(url, '_blank');
}
</script>
</body>
</html>