<?php
    $datos = file_get_contents('php://input');
    $datos = json_decode($datos);
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
    
    $num_cliente = $datos->cliente;
    $query = "SELECT * FROM clientes where CtdId like '$num_cliente%'";
    $result = mysqli_query($conection, $query);
    if( !$result){
        die (json_encode( "{error:".mysqli_error($conection)));
    }

    $json = array();
    while( $row = mysqli_fetch_array($result)){
        $json[] = array(
            'name' => $row["CtdNomb"],
            'status' => $row["CtdSts"],
            "bloc" => $row['CtdCodInf2']
        );
    }

    $jsonstring = json_encode($json);
    echo ($jsonstring);
?>