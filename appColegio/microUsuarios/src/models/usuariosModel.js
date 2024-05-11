const mysql = require('mysql2/promise');
const axios = require('axios');
const connection = mysql.createPool({
host: 'localhost',
user: 'root',
password: 'password',
database: 'colegio'
});

async function validarUsuario(id, clave) {
    try {
        const query = 'SELECT id, nombre, grado, rol FROM usuarios WHERE id = ? AND clave = ?';
        const [rows] = await connection.query(query, [id, clave]);
        return rows.length ? rows[0] : null;
    } catch (error) {
        console.error('Error al validar usuario:', error);
        return null;
    }
}

async function agregarUsuario(id, nombre, rol, grado, clave) {
    try {
        
        await connection.query('INSERT INTO usuarios (id, nombre, rol, grado, clave) VALUES (?, ?, ?, ?, ?)', [id, nombre, rol, grado,clave]);
    } catch (error) {
        console.error('Error al agregar usuario:', error);
        throw error;
    }
}

async function todosUsuarios() {
    const query = "SELECT nombre, grado FROM usuarios";
    const [result] = await connection.query(query); 
    return result;
}

async function eliminarUsuario(id) {
    try {
        const query = 'DELETE FROM usuarios WHERE id = ?';
        await connection.query(query, [id]);
    } catch (error) {
        console.error('Error al eliminar usuario:', error);
        throw error;
    }
}

module.exports = { validarUsuario, agregarUsuario, todosUsuarios, eliminarUsuario };