<?php
    $datos = file_get_contents('php://input');
    $datos = json_decode($datos);
    switch($datos->Suc){
        case 1:
            include 'Basededatos/conexion.php';
            break;
        case 3:
            include 'Basededatos/conexion_pjc.php';
            break;
        default:
            die(json_encode('{"exito":null, "error": "No se pudo conectar a la sucursal"}'));
    }

    $num_cliente = $datos->CtdId;
    $tipo_doc = $datos->CtdTDoc;
    $doc_cliente = $datos->CtdDoc;
    $query = "SELECT * FROM clientesext WHERE CtdId = '$num_cliente'";
    $result = mysqli_query($conection, $query);
    $row = $result->fetch_assoc();
    $query = "SELECT * FROM clientesext WHERE CtdDoc = '$doc_cliente'";
    $result = mysqli_query($conection, $query);
    $row2 = $result->fetch_assoc();
    if($row === null){
        if($row2 === null || $row2['CtdTDoc'] != $tipo_doc){
            $query = "INSERT INTO clientesext(CtdId,CtdTDoc,CtdDoc) VALUES ('$num_cliente','$tipo_doc','$doc_cliente')";
            $result = mysqli_query($conection, $query);
            if(!$result){    
                die(json_encode('{"exito":"null", "error": "Fallo la insercion"}'));
            }
        }
        else{
            die (json_encode('{"exito":"null", "error": "El usuario ya esta registrado, CI Ya existe"}'));
        }
    }
    else{
        die (json_encode('{"exito":"null", "error": "El usuario ya esta registrado, numero de cliente Ya existe"}'));
    }

    echo json_encode('{"exito":"Cargado con Exito", "error": "null"}');
?>