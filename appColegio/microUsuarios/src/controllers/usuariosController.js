const { Router } = require('express');
const router = Router();
const usuariosModel = require('../models/usuariosModel');
const axios = require('axios');

async function agregarNotaEstudiante(id, nombre, grado) {
        try {
            const url = `http://localhost:3031/notas/agregar/${id}/${nombre}/${grado}`;
            await axios.post(url);
        } catch (error) {
            console.error('Error al crear Nota:', error);
            throw error;
        }
}

router.get('/login/:id/:clave', async (req, res) => {
    const id = req.params.id;
    const clave = req.params.clave;
    const userData = await usuariosModel.validarUsuario(id, clave);

    if (userData) {
        // Usuario válido
        const { id, nombre, grado, rol } = userData;
        res.json({ id, nombre, grado, rol });
    } else {
        // Usuario inválido
        res.status(401).json({ message: 'Credenciales inválidas' });
    }
});

router.post('/crear/:id/:nombre/:rol/:grado/:clave', async (req, res) => {
    const { id, nombre, rol, grado, clave } = req.params;
    const nombreSinEspacios = req.params.nombre.replace(/\s+/g, '_');
    try {
        
        await usuariosModel.agregarUsuario(id, nombreSinEspacios, rol, grado, clave);

        // Si el rol es 'Estudiante', agregar una nota
        if (rol === 'Estudiante') {
            await agregarNotaEstudiante(id, nombreSinEspacios, grado);
        }

        res.status(201).json({ message: 'Usuario creado correctamente' });
    } catch (error) {
        console.error('Error al crear usuario:', error);
        res.status(500).json({ error: 'Hubo un problema al crear el usuario' });
    }
});

router.get('/todosusuarios', async (req, res) => {
    try {
        const todosusuarios = await usuariosModel.todosUsuarios();
        res.json(todosusuarios);
    } catch (error) {
        res.status(500).json({ error: 'Error al obtener todos los usuarios' });
    }
});

router.delete('/usuarios/eliminar/:id', async (req, res) => {
    const id = req.params.id;

    try {
        await usuariosModel.eliminarUsuario(id);

        const urlEliminarNota = `http://localhost:3002/notas/eliminar/${id}`;
        await axios.delete(urlEliminarNota);

        res.status(200).json({ message: 'Usuario y nota asociada eliminados correctamente' });
    } catch (error) {
        console.error('Error al eliminar usuario y nota:', error);
        res.status(500).json({ error: 'Hubo un problema al eliminar el usuario y la nota' });
    }
});

module.exports = router;