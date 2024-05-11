const mysql = require('mysql2/promise');
const connection = mysql.createPool({
    host: 'db',
    user: 'root',
    password: 'password',
    database: 'colegio'
});

async function obtenerDatosUsuario(usuarioId) {
    try {
        const query = 'SELECT * FROM notas WHERE id = ?';
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

async function agregarNota(nuevaNota) {
    try {
        const query = 'INSERT INTO notas (id, nombre, grado, num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        const { id, nombre, grado, num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias } = nuevaNota;
        await connection.query(query, [id, nombre, grado, num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias]);
        console.log('Nota agregada correctamente');
    } catch (error) {
        console.error('Error al agregar nota:', error);
        throw error;
    }
}

async function editarNota(notaId, nuevosDatos) {
    try {
        const notaExistente = await obtenerDatosUsuario(notaId);
        if (!notaExistente) {
            throw new Error('La nota no existe');
        }

        const { num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias } = nuevosDatos;
        const query = 'UPDATE notas SET num_premios = ?, programa = ?, puntaje_mat = ?, puntaje_ing = ?, puntaje_ciencias = ? WHERE id = ?';
        await connection.query(query, [num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias, notaId]);
        
        console.log('Nota actualizada correctamente');
    } catch (error) {
        console.error('Error al editar nota:', error);
        throw error;
    }
}

async function eliminarNota(notaId) {
    try {
        const query = 'DELETE FROM notas WHERE id = ?';
        await connection.query(query, [notaId]);
        console.log('Nota eliminada correctamente');
    } catch (error) {
        console.error('Error al eliminar la nota:', error);
        throw error;
    }
}
module.exports = { obtenerDatosUsuario, obtenerTodasLasNotas, obtenerDatosGrado, agregarNota, editarNota, eliminarNota };
