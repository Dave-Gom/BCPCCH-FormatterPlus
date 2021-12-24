<?php
    $datos = file_get_contents('php://input');
    $datos = json_decode($datos);
    $cliente = $datos->cliente;
    $sucursal = $datos->suc;

    switch($datos->suc){
        case 1:
            include 'Basededatos/conexion.php';
            break;
        case 3:
            include 'Basededatos/conexion_pjc.php';
            break;
        default:
            die(json_encode('{"exito":null, "error": "No se pudo conectar a la sucursal"}'));
    }

    $query = "UPDATE clientes SET CtdStS='HAB' where CtdId='$cliente'";
    $result = mysqli_query($conection, $query);
    if( !$result){
        die (json_encode( "{error:".mysqli_error($conection)));
    }
    else{
        echo json_encode('{"exito": "Cargado con Exito", "error": "null"}');
    }
?>