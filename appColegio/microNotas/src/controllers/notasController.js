const { Router } = require('express');
const router = Router();
const notasModel = require('../models/notasModel');

router.get('/notas/:id', async (req, res) => {
    const usuarioId = req.params.id; 
    const userData = await notasModel.obtenerDatosUsuario(usuarioId);

    if (!userData) {
        return res.status(404).json({ message: 'No se encontraron notas para este usuario' });
    }

    res.json(userData);
});

router.get('/notas/filtrado/:grado', async (req, res) => {
    const Grado = req.params.grado; 
    const userData = await notasModel.obtenerDatosGrado(Grado);

    if (!userData) {
        return res.status(404).json({ message: 'No se encontraron notas para este grado' });
    }

    res.json(userData);
});

router.get('/notas/todas/.', async (req, res) => {
    const todasLasNotas = await notasModel.obtenerTodasLasNotas();

    res.json(todasLasNotas);
});

router.post('/notas/agregar/:id/:nombre/:grado', async (req, res) => {
    const { id, nombre, grado } = req.params;

    const nuevoRegistro = {
        id,
        nombre,
        grado,
        num_premios: 0,
        programa: 'General',
        puntaje_mat: 0,
        puntaje_ing: 0,
        puntaje_ciencias: 0
    };

    try {
        await notasModel.agregarNota(nuevoRegistro);
        res.status(201).json({ message: 'Nota agregada correctamente' });
    } catch (error) {
        console.error("Error al agregar nota:", error);
        res.status(500).json({ error: "Hubo un problema al agregar la nota" });
    }
});

router.put('/notas/editar/:id/:num_premios/:programa/:puntaje_mat/:puntaje_ing/:puntaje_ciencias', async (req, res) => {
    const notaId = req.params.id;
    const { num_premios, programa, puntaje_mat, puntaje_ing, puntaje_ciencias } = req.params;

    try {
        const notaExistente = await notasModel.obtenerDatosUsuario(notaId);
        if (!notaExistente) {
            return res.status(404).json({ message: 'La nota no existe' });
        }

        await notasModel.editarNota(notaId, {
            num_premios,
            programa,
            puntaje_mat,
            puntaje_ing,
            puntaje_ciencias
        });

        res.status(200).json({ message: 'Nota editada correctamente' });
    } catch (error) {
        console.error('Error al editar nota:', error);
        res.status(500).json({ error: 'Hubo un problema al editar la nota' });
    }
});

router.delete('/notas/eliminar/:id', async (req, res) => {
    const notaId = req.params.id;
    try {
        await notasModel.eliminarNota(notaId); 
        res.status(200).json({ message: 'Nota eliminada correctamente' });
    } catch (error) {
        console.error('Error al eliminar la nota:', error);
        res.status(500).json({ error: 'Hubo un problema al eliminar la nota' });
    }
});

module.exports = router;
