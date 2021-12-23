<?php
    $conection = mysqli_connect(
        'localhost',
        'root',
        '',
        'chaco_matriz'
    );
    if(!$conection)
        die (json_encode("{error: 'No se pudo conectar a la Base de Datos'"));
        
?>