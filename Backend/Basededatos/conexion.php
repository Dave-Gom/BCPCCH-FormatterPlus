<?php
    $conection = mysqli_connect(
        
    );
    if(!$conection)
        die (json_encode("{error: 'No se pudo conectar a la Base de Datos'"));
        
?>
