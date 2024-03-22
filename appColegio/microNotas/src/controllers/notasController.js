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

module.exports = router;
