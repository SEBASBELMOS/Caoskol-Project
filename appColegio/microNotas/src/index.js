const express = require('express');
const notasController = require('./controllers/notasController');
const morgan = require('morgan');
const app = express();
app.use(morgan('dev'));
app.use(express.json());
app.use(notasController);
app.listen(3008, () => {
    console.log('Microservicio Notas ejecutandose en el puerto 3008');
});