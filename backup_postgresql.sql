-- PostgreSQL database dump
BEGIN;

-- Table: cache
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- Table: cache_locks
CREATE TABLE cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

-- Table: departamentos
CREATE TABLE departamentos (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Data for departamentos
INSERT INTO departamentos (id, nombre, created_at, updated_at) VALUES
(1, 'Logística', '2025-10-08 17:23:14', '2025-10-08 17:23:14'),
(2, 'Contabilidad', '2025-10-08 18:08:18', '2025-10-08 18:08:18'),
(3, 'Tesorería', '2025-10-08 21:00:45', '2025-10-08 21:00:45'),
(4, 'Compra', '2025-10-14 19:12:45', '2025-10-14 19:12:45'),
(5, 'Producción', '2025-10-14 22:43:49', '2025-10-14 22:43:49');

-- Table: equipo_asignados
CREATE TABLE equipo_asignados (
    id BIGSERIAL PRIMARY KEY,
    usuarios_id BIGINT NOT NULL,
    stock_equipos_id BIGINT NOT NULL,
    fecha_asignacion TIMESTAMP NOT NULL,
    ip_equipo TEXT NOT NULL,
    fecha_devolucion TIMESTAMP NULL,
    observaciones TEXT NULL,
    usuario_id BIGINT NOT NULL,
    estado VARCHAR(30) CHECK (estado IN ('activo','devuelto','obsoleto')) NOT NULL DEFAULT 'activo',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Data for equipo_asignados
INSERT INTO equipo_asignados (id, usuarios_id, stock_equipos_id, fecha_asignacion, ip_equipo, fecha_devolucion, observaciones, usuario_id, estado, created_at, updated_at) VALUES
(1, 1, 1, '2025-10-09 00:00:00', '192.168.1.155', '2025-10-14 15:17:24', 'bhb', 1, 'devuelto', '2025-10-09 19:32:55', '2025-10-14 19:17:24'),
(2, 3, 1, '2025-10-09 00:00:00', '192.168.1.101', '2025-10-09 19:56:02', 'laptop para Iliada', 1, 'devuelto', '2025-10-09 22:32:33', '2025-10-09 23:56:02');

-- Table: failed_jobs
CREATE TABLE failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table: jobs
CREATE TABLE jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INTEGER NULL,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

-- Table: job_batches
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT NULL,
    cancelled_at INTEGER NULL,
    created_at INTEGER NOT NULL,
    finished_at INTEGER NULL
);

-- Table: migrations
CREATE TABLE migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INTEGER NOT NULL
);

-- Data for migrations
INSERT INTO migrations (id, migration, batch) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_06_013711_create_departamentos_table', 1),
(5, '2025_10_06_013712_create_sedes_table', 1),
(6, '2025_10_06_013713_create_usuarios_table', 1),
(7, '2025_10_06_013717_create_usuarios_table', 1),
(8, '2025_10_06_013722_create_tipo_equipos_table', 1),
(9, '2025_10_06_013829_create_stock_equipos_table', 1),
(10, '2025_10_06_013900_create_equipos_asignados_table', 1);

-- Table: password_reset_tokens
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- Table: sedes
CREATE TABLE sedes (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    ubicacion VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Data for sedes
INSERT INTO sedes (id, nombre, ubicacion, created_at, updated_at) VALUES
(1, 'Planta Nueva', 'Zona industrial II, carrera 6 entre calle5 y C. 4', '2025-10-08 17:37:55', '2025-10-08 17:38:09'),
(2, 'Zona I', 'Calle 28 entre Carreras 4y 5, Local #35, Zona industrial I', '2025-10-09 15:48:50', '2025-10-09 15:48:50'),
(3, 'Gary', 'Carrera 4 entre calle 3 y C.4 - Zona Industrial II', '2025-10-14 19:12:26', '2025-10-14 19:12:26');

-- Table: sessions
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

-- Data for sessions
INSERT INTO sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES
('AAKGzaDuD8ZoDr9HPAb5J4w8AURQqpwqwdOfUowD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQjdNcklpVWlzY3FnUEgxT05La01zRWVrNW9qUEtoQlBLWFR3UDRaYiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1760615590),
('bJyfdkstH6J3WKNcPjvWNLk4wJgqogtGzo6YKTGQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMEpwOHFnTVdMUzAxck4wODZDNkpwWDVVSmZWZmFQdjdZRlRUalBadyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1760615817);

-- Table: stock_equipos
CREATE TABLE stock_equipos (
    id BIGSERIAL PRIMARY KEY,
    tipo_equipo_id BIGINT NOT NULL,
    marca VARCHAR(255) NOT NULL,
    modelo VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    cantidad_total INTEGER NOT NULL DEFAULT 0,
    cantidad_disponible INTEGER NOT NULL DEFAULT 0,
    cantidad_asignada INTEGER NOT NULL DEFAULT 0,
    minimo_stock INTEGER NOT NULL DEFAULT 0,
    fecha_adquisicion DATE NULL,
    valor_adquisicion DECIMAL(10,2) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Data for stock_equipos
INSERT INTO stock_equipos (id, tipo_equipo_id, marca, modelo, descripcion, cantidad_total, cantidad_disponible, cantidad_asignada, minimo_stock, fecha_adquisicion, valor_adquisicion, created_at, updated_at) VALUES
(1, 3, 'Compaq', 'QL14CBM8128', 'Laptop Compaq Intel Celeron N4020 8gb Ddr4 128gb M.2', 10, 10, 0, 2, '2025-10-01', 255.00, '2025-10-09 17:51:33', '2025-10-14 19:17:24'),
(2, 1, 'Canon', 'MF230 Series UFRII LT', 'Toners para impresora', 5, 5, 0, 1, '2025-10-02', 10.00, '2025-10-09 20:43:11', '2025-10-15 18:33:39');

-- Table: tipo_equipos
CREATE TABLE tipo_equipos (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Data for tipo_equipos
INSERT INTO tipo_equipos (id, nombre, descripcion, created_at, updated_at) VALUES
(1, 'Impresora', 'Repuestos de impresora', '2025-10-09 16:48:45', '2025-10-09 16:48:45'),
(3, 'Laptop', NULL, '2025-10-09 16:53:40', '2025-10-09 17:02:19'),
(4, 'Desktop', 'Computadora de mesa', '2025-10-09 16:58:37', '2025-10-09 17:01:57'),
(5, 'Mouse', 'Ratón de escritorio', '2025-10-09 17:02:39', '2025-10-09 17:02:39');

-- Table: users
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Data for users
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
(1, 'Test User', 'test@example.com', '2025-10-07 18:39:48', '$2y$12$DXUg1HnAUWYDb/Ltrjh7fuR6sPbbz8Mfv.5xZL/oyyeMHwbAp/dL.', '5ba7AEekzxJhCgUgf1U6f0QNAItNPuGeGqkTx4UBJmZtwGxc5HXmuCoqJmnj', '2025-10-07 18:39:48', '2025-10-07 18:39:48');

-- Table: usuario
CREATE TABLE usuario (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    activo SMALLINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Data for usuario
INSERT INTO usuario (id, name, email, password, activo, created_at, updated_at) VALUES
(1, 'valeria', 'soportetic@fritzve.com', '1231234', 1, '2025-10-01 19:54:11', '2025-10-10 19:10:55'),
(6, 'David', 'pasantetic@fritzve.com', '1231234', 1, '2025-10-08 19:50:42', '2025-10-15 19:03:46'),
(7, 'Jesús P', 'yisus@gmail.com', '286214', 1, '2025-10-08 15:51:31', '2025-10-14 21:08:06');

-- Table: usuarios
CREATE TABLE usuarios (
    id BIGSERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    cargo VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    RDP VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    sede_id BIGINT NOT NULL,
    departamento_id BIGINT NOT NULL,
    activo SMALLINT DEFAULT 1
);

-- Data for usuarios
INSERT INTO usuarios (id, nombre, apellido, cargo, correo, RDP, created_at, updated_at, sede_id, departamento_id, activo) VALUES
(1, 'Alberto', 'Alzaga', 'Jefe', 'jefecon@gmail.com', 'Jefedecontabilidad', '2025-10-08 18:11:55', '2025-10-08 18:11:55', 1, 2, 1),
(3, 'Iliada', 'Artega', 'Especialista', 'analistacon@gmail.com', 'EspecialistaContab1', '2025-10-08 20:16:35', '2025-10-08 20:16:49', 1, 2, 1),
(4, 'Yulied', 'Escobar', 'Especialista', 'Especialistacostos@fritzve.com', 'Especilistadecostos', '2025-10-09 22:45:01', '2025-10-09 22:53:18', 1, 2, 1),
(5, 'Impresora', 'Contabilidad', 'X', '123@gmail.com', 'Z', '2025-10-09 22:46:19', '2025-10-14 19:06:01', 1, 2, 1),
(6, 'Impresora', 'Logística', 'X', '1234@gmail.com', 'Y', '2025-10-14 19:08:24', '2025-10-14 19:08:24', 1, 1, 1),
(7, 'William', 'Mendez', 'Jefe de producción', 'jefeprodu@gmail.com', 'EspecialistaProduccion', '2025-10-14 22:44:31', '2025-10-14 22:44:31', 2, 5, 1);

-- Foreign keys
ALTER TABLE equipo_asignados 
    ADD CONSTRAINT fk_equipo_asignados_usuarios 
    FOREIGN KEY (usuarios_id) REFERENCES usuarios(id) ON DELETE CASCADE;

ALTER TABLE equipo_asignados 
    ADD CONSTRAINT fk_equipo_asignados_stock_equipos 
    FOREIGN KEY (stock_equipos_id) REFERENCES stock_equipos(id) ON DELETE CASCADE;

ALTER TABLE equipo_asignados 
    ADD CONSTRAINT fk_equipo_asignados_usuario 
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;

ALTER TABLE stock_equipos 
    ADD CONSTRAINT fk_stock_equipos_tipo_equipos 
    FOREIGN KEY (tipo_equipo_id) REFERENCES tipo_equipos(id) ON DELETE CASCADE;

ALTER TABLE usuarios 
    ADD CONSTRAINT fk_usuarios_sedes 
    FOREIGN KEY (sede_id) REFERENCES sedes(id) ON DELETE CASCADE;

ALTER TABLE usuarios 
    ADD CONSTRAINT fk_usuarios_departamentos 
    FOREIGN KEY (departamento_id) REFERENCES departamentos(id) ON DELETE CASCADE;

COMMIT;