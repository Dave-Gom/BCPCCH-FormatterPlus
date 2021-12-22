<?php
    $name = ($_POST['nombre']);

    if( !unlink( 'download/'.$name))
        echo "no se pudo eliminar el archivo ".$name;
    else    
        echo "exito";
        
?>