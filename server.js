// Importar módulos necesarios
import express from 'express';
import path from 'path';
import { fileURLToPath } from 'url';

// Configurar __dirname para ES6 modules
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Crear aplicación Express
const app = express();
const PORT = process.env.PORT || 3000;

// Middleware para parsear JSON y datos de formulario
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Servir archivos estáticos desde el directorio 'public'
app.use(express.static(path.join(__dirname, 'public')));

// Ruta principal
app.get('/', (req, res) => {
    res.send(`
        <h1>Servidor Node.js con Express</h1>
        <p>Bienvenido al servidor de ejemplo</p>
        <p>Directorio público: ${path.join(__dirname, 'public')}</p>
        <p>Puerto: ${PORT}</p>
    `);
});

// Rutas dinámicas con parámetros
app.get('/usuarios/:id', (req, res) => {
    const { id } = req.params;
    res.json({
        mensaje: `Detalles del usuario con ID: ${id}`,
        id: id,
        timestamp: new Date().toISOString()
    });
});

// Ruta con parámetros opcionales
app.get('/buscar', (req, res) => {
    const { q, limit = 10 } = req.query;
    res.json({
        mensaje: 'Resultados de búsqueda',
        query: q || 'ninguna',
        limite: limit,
        timestamp: new Date().toISOString()
    });
});

// Manejo de rutas no encontradas (404)
app.use((req, res) => {
    res.status(404).json({
        error: 'Ruta no encontrada',
        mensaje: `La ruta ${req.method} ${req.originalUrl} no existe en este servidor`,
        timestamp: new Date().toISOString()
    });
});

// Manejo de errores globales
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({
        error: 'Error interno del servidor',
        mensaje: 'Algo salió mal en el servidor',
        timestamp: new Date().toISOString()
    });
});

// Iniciar el servidor
app.listen(PORT, () => {
    console.log(`Servidor escuchando en http://localhost:${PORT}`);
    console.log(`Directorio público: ${path.join(__dirname, 'public')}`);
    console.log(`Presiona Ctrl+C para detener el servidor`);
});