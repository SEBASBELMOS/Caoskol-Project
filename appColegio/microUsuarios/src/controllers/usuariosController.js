const { Router } = require('express');
const router = Router();
const usuariosModel = require('../models/usuariosModel');

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

module.exports = router;