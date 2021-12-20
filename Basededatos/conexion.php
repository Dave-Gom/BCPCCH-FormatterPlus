<?php
    $conection = mysqli_connect(
        'localhost',
        'root',
        '',
        'tests_davesystem'
    );
    if($conection)
        echo "Basededatos Conectada!";
?>