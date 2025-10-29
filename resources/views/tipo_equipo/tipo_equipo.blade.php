<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fritz C.A | Gestión de Tipos de Equipo</title>

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

        .tipo-equipo-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(135deg, #bd6c2bff 0%, #c70e0eff 100%);
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
                <a class="nav-link text-white sidebar-link active" href="{{ route('tipo_equipo.index') }}">
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
                                <li class="breadcrumb-item active text-white" aria-current="page">Gestión de Tipos de Equipo</li>
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
                            <i class="bi bi-boxes me-2 text-danger"></i>
                            Gestión de Tipos de Equipo
                        </h2>
                        <p class="text-muted mb-0">Administra los tipos de equipo del inventario</p>
                    </div>
                    <div>
                        <button class="btn btn-fritz" data-bs-toggle="modal" data-bs-target="#createTipoEquipoModal">
                            <i class="bi bi-plus-circle me-1"></i> Nuevo Tipo
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
                
                <!-- Tipo Equipo Management Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-list-ul me-2 text-danger"></i> Lista de Tipos de Equipo
                            </h5>
                            
                        </div>
                    </div>
                    <div class="card-body">
                      
                        <!-- Tabla de Tipos de Equipo -->
                        <div class="table-responsive">
                            <table class="table table-hover" style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50px">ID</th>
                                        <th>Tipo de Equipo</th>
                                        <th>Descripción</th>
                                        <th>Requiere IP</th>
                                        <th>Equipos en Stock</th>
                                        <th>Fecha de Registro</th>
                                        <th width="120px" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tiposEquipo as $tipo)
                                    <tr>
                                        <td class="fw-bold">{{ $tipo->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="tipo-equipo-icon me-3">
                                                    {{ strtoupper(substr($tipo->nombre, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $tipo->nombre }}</div>
                                                    <small class="text-muted">ID: {{ $tipo->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($tipo->descripcion)
                                                <span class="badge description-badge rounded-pill">
                                                    <i class="bi bi-card-text me-1"></i>
                                                    {{ Str::limit($tipo->descripcion, 30) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">
                                                    <i class="bi bi-card-text me-1"></i>
                                                    Sin descripción
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($tipo->requiere_ip)
                                                <span class="badge bg-success">Sí</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge stock-badge rounded-pill">
    <i class="bi bi-box me-1"></i>
    {{ $tipo->stock_equipo_count ?? 0 }} Equipos
</span>
                                        </td>
                                        <td>
                                            {{ $tipo->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="table-actions text-center">
                                            <button class="btn btn-sm btn-outline-info action-btn me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewTipoEquipoModal"
                                                    onclick="viewTipoEquipoData({{ $tipo }})"
                                                    title="Ver">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning action-btn me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editTipoEquipoModal"
                                                    onclick="loadTipoEquipoData({{ $tipo }})"
                                                    title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger action-btn"
                                                    onclick="confirmDelete({{ $tipo->id }}, '{{ $tipo->nombre }}')"
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
            </main>
        </div>
    </div>

  <!-- Modal para Crear Tipo de Equipo -->
<div class="modal fade" id="createTipoEquipoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="bi bi-laptop me-2"></i> Nuevo Tipo de Equipo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tipo_equipo.store') }}" method="POST" id="createTipoEquipoForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Tipo*</label>
                                <input type="text" class="form-control" name="nombre" required placeholder="Ingrese el nombre del tipo">
                                <small class="text-muted">Ej: Laptop, Desktop, Impresora, Servidor, etc.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3" placeholder="Ingrese una descripción del tipo de equipo"></textarea>
                                <small class="text-muted">Descripción opcional del tipo de equipo</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Requiere dirección IP?</label>
                                <select class="form-select" name="requiere_ip" required>
                                    <option value="1">Sí (Computadoras, Servidores, etc.)</option>
                                    <option value="0">No (Mouse, Teclado, Accesorios, etc.)</option>
                                </select>
                                <small class="text-muted">Seleccione "No" para equipos que no necesiten dirección IP</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-fritz">Guardar Tipo</button>
                </div>
            </form>
        </div>
    </div>
</div>

   <!-- Modal para Editar Tipo de Equipo -->
<div class="modal fade" id="editTipoEquipoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i> Editar Tipo de Equipo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTipoEquipoForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Tipo*</label>
                                <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                                <small class="text-muted">Ej: Laptop, Desktop, Impresora, Servidor, etc.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="3"></textarea>
                                <small class="text-muted">Descripción opcional del tipo de equipo</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">¿Requiere dirección IP?</label>
                                <select class="form-select" name="requiere_ip" id="edit_requiere_ip" required>
                                    <option value="1">Sí (Computadoras, Servidores, etc.)</option>
                                    <option value="0">No (Mouse, Teclado, Accesorios, etc.)</option>
                                </select>
                                <small class="text-muted">Seleccione "No" para equipos que no necesiten dirección IP</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar Tipo</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Modal para Ver Tipo de Equipo -->
    <div class="modal fade" id="viewTipoEquipoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-eye me-2"></i> Detalles del Tipo de Equipo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="tipo-equipo-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;" id="view_icon">
                            <!-- Icono se llena con JavaScript -->
                        </div>
                        <h4 id="view_nombre"></h4>
                        <p class="text-muted" id="view_id"></p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <strong>ID:</strong>
                            <p id="view_tipo_id" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Equipos en Stock:</strong>
                            <p id="view_stock_count" class="mb-2"></p>
                        </div>
                        <div class="col-12">
                            <strong>Descripción:</strong>
                            <p id="view_descripcion" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Fecha de Registro:</strong>
                            <p id="view_created" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Última Actualización:</strong>
                            <p id="view_updated" class="mb-2"></p>
                        </div>
                        <div class="col-6">
                            <strong>Requiere IP:</strong>
                            <p id="view_requiere_ip" class="mb-2"></p>
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
        function loadTipoEquipoData(tipo) {
    document.getElementById('editTipoEquipoForm').action = `/tipo_equipo/${tipo.id}`;
    document.getElementById('edit_nombre').value = tipo.nombre;
    document.getElementById('edit_descripcion').value = tipo.descripción || '';
    document.getElementById('edit_requiere_ip').value = tipo.requiere_ip ? '1' : '0';
}

        // Función para cargar datos en el modal de visualización
function viewTipoEquipoData(tipo) {
    document.getElementById('view_icon').textContent = tipo.nombre.charAt(0).toUpperCase();
    document.getElementById('view_nombre').textContent = tipo.nombre;
    document.getElementById('view_id').textContent = `ID: ${tipo.id}`;
    document.getElementById('view_tipo_id').textContent = tipo.id;
    document.getElementById('view_descripcion').textContent = tipo.descripcion || 'Sin descripción';
    
    // Usar stock_equipo_count que viene del withCount
    const stockCount = tipo.stock_equipo_count !== undefined ? tipo.stock_equipo_count : (tipo.stockEquipo ? tipo.stockEquipo.length : 0);
    document.getElementById('view_stock_count').innerHTML = stockCount > 0 ? 
        `<span class="badge stock-badge">${stockCount} Equipos</span>` : 
        '<span class="badge bg-secondary">0 Equipos</span>';
    
    // Mostrar información de requiere IP
    const requiereIP = tipo.requiere_ip ? 
        '<span class="badge bg-success">Requiere IP</span>' : 
        '<span class="badge bg-secondary">No requiere IP</span>';
    document.getElementById('view_requiere_ip').innerHTML = requiereIP;
    
    document.getElementById('view_created').textContent = new Date(tipo.created_at).toLocaleDateString('es-ES');
    document.getElementById('view_updated').textContent = new Date(tipo.updated_at).toLocaleDateString('es-ES');
    
    $('#viewTipoEquipoModal').modal('show');
}

        // Función para confirmar eliminación
        function confirmDelete(tipoId, tipoName) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Vas a eliminar el tipo de equipo "${tipoName}". Esta acción no se puede deshacer.`,
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
                    form.action = `/tipo_equipo/${tipoId}`;
                    
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
        // Filtros
        $(document).ready(function() {
            $('#applyFilters').click(function() {
                const filterName = $('#searchName').val();
                console.log('Aplicar filtros:', { search: filterName });
                // Aquí puedes implementar la lógica de filtrado
            });

            $('#resetFilters').click(function() {
                $('#searchName').val('');
            });

           
    
            
        });
    </script>
</body>
</html>