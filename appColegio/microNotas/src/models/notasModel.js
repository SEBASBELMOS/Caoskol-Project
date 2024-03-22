const mysql = require('mysql2/promise');
const connection = mysql.createPool({
    //host: 'localhost',
    host: '192.168.100.2',
    user: 'root',
    port: 3306,
    password: 'password',
    database: 'colegio'
});

async function obtenerDatosUsuario(usuarioId) {
    try {
        const query = 'SELECT nombre, grado, programa, num_premios, puntaje_mat, puntaje_ing, puntaje_ciencias FROM notas WHERE id = ?';
        const [rows] = await connection.query(query, [usuarioId]);
        return rows.length ? rows[0] : null;
    } catch (error) {
        console.error('Error al obtener datos del usuario:', error);
        return null;
    }
}

async function obtenerDatosGrado(Grado) {
    try {
        const query = 'SELECT nombre, grado, programa, num_premios, puntaje_mat, puntaje_ing, puntaje_ciencias FROM notas WHERE grado = ?';
        const [rows] = await connection.query(query, [Grado]);
        return rows;
    } catch (error) {
        console.error('Error al obtener datos del grado:', error);
        return null;
    }
}

async function obtenerTodasLasNotas() {
    try {
        const query = 'SELECT * FROM notas';
        const [rows] = await connection.query(query);
        return rows;
    } catch (error) {
        console.error('Error al obtener todas las notas:', error);
        return null;
    }
}

module.exports = { obtenerDatosUsuario, obtenerTodasLasNotas, obtenerDatosGrado };