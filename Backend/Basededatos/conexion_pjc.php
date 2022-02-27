<?php
    $conection = mysqli_connect(
        
    );
    if(!$conection)
        // echo "Basededatos Conectada!";
        die( json_encode('{"exito":null, "error": "No se pudo conectar a la sucursal"}'));
    else
        
?>
