<?php
    $conection = mysqli_connect(
        'localhost',
        'root',
        '',
        'chaco_pjc'
    );
    if(!$conection)
        // echo "Basededatos Conectada!";
        die( json_encode("{error: 'No se pudo conectat a la BD'}"));
    else
        
?>