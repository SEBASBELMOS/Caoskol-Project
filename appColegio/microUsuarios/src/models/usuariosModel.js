const mysql = require('mysql2/promise');
const connection = mysql.createPool({
//host: 'localhost',
host: '192.168.100.2',
user: 'root',
port: 3306,
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

module.exports = { validarUsuario };