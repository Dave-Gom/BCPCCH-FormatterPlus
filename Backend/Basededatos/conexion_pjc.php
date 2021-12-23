<?php
    $conection = mysqli_connect(
        'localhost',
        'root',
        '',
        'chaco_pjc'
    );
    if(!$conection)
        // echo "Basededatos Conectada!";
        die( json_encode('{"exito":null, "error": "No se pudo conectar a la sucursal"}'));
    else
        
?>