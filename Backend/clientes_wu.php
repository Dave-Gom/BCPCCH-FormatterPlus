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
            die(json_encode("Error: no se "));
    }

    $num_cliente = $datos->CtdId;
    $tipo_doc = $datos->CtdTDoc;
    $doc_cliente = $datos->CtdDoc;
    $query = "INSERT INTO clientesext(CtdId,CtdTDoc,CtdDoc) VALUES ('$num_cliente','$tipo_doc','$doc_cliente')";
    $result = mysqli_query($conection, $query);
    if(!$result)
        die(json_encode("No se pudo cargar"));
    
    echo json_encode("Cargado con exito");
?>