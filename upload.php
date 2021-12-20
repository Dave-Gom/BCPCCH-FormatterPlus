<?php
    // toma el nombre del archivo cargado
    $filename = $_FILES['file']['name'];

    // elige la ruta donde guardar el erchivo
    $location = "upload/"."informe.txt";

    if( move_uploaded_file( $_FILES['file']['tmp_name'], $location ) ) {
        echo "Cargado con exito";
    }
    else{
        echo "Error";

    }

?>