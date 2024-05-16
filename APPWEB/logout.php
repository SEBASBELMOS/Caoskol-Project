<?php
    #logout de las paginas
    session_start();
    session_destroy();
    header("Location:index.html");
?>
