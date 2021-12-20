<?php
    // recibe las operaciones a excluir
    $excluidos = json_decode($_POST['data']);
    // abre el archivo subido para ser editado
    $informe = fopen('upload/informe.txt','r');
    //da formato al nombre y crea un archivo para almacenar los valores corregidos
    $ayer = date('Ymd', time()-86400);
    $fname = 'TRA-3009-'.$ayer.'.txt';
    $corregido = fopen('download/'.$fname,'w');

    

    $bandera = 0;
    $cont = 0;
    $coincidencias = 0;
    while( !feof($informe)){
        //lee un alinea de texto del ARCHIVO subido
        $linea = fgets($informe);
        if( isset($_POST['data'])){
            foreach( $excluidos as $op){
                if( $op != '') {
                    if( strpos( $linea, trim($op)) !== false ){
                        $coincidencias++;
                    }
                }
            }
        }
    }
    
    rewind($informe);

    while( !feof($informe)){
        //lee un alinea de texto del ARCHIVO subido
        $linea = fgets($informe);

        if( strlen($linea) >5 ){
            /* Por cada elemento del array de operacines excluidas
             Busca el elemento del array en la linea leida del archivo, si lo encuentra 
             activa la bander y resta 1 al contador*/
            if( isset($_POST['data'])){
                foreach( $excluidos as $op){
                    if( $op != '') {
                        if( strpos( $linea, trim($op)) !== false ){
                            $bandera = 1;
                            $cont = $cont -1;
                        }
                    }
                }
            }
            
            // si la bandera no se activa corrige el archivo
            if( $bandera == 0){
                //Copia la primera linea tal cual
                if( $cont != 0){
                    $corr = codpais($linea); //corrige el codigo de pais eliminando la palabra asuncion y remlazandola por 8 espacios
                    $corr = contador($corr, $cont); // edita el contador de operaciones 
                    $corr = motiv_incor($corr); // Remplaza los motivos incorrectos
                    $corr = clientes_ur($corr); // agrega el - antes del ultimo digito a las op de clientes uruguayos CRCUY
                    $corr = clientes_py($corr); // remplaza CRCPY por CRP
                    $corr = Res902021($corr); // agrega los espacios corresp segun la resolucion  90/2021
                }
                else
                    $corr = total_operaciones($linea, $coincidencias); // resta al contador de la primera linea la cantidad de operaciones excluidas

                fprintf($corregido, $corr); // guarda las lineas coregidas en un archivo que contiene la fecha del dia anterior
            }
            $cont++;
            $bandera = 0;
        }
    }

    fclose($informe);
    fclose($corregido);
    
    echo ($fname);

    function codpais($cadena){
        // establece 8 espacios para reemplazar la palabra asuncion
        $rem = '        ';
        //busca el codigo de pais y si es igual a paraguay remplaza la palabra asuncion
        $codigoPais = substr($cadena, 185, 2);
        if( $codigoPais != 'PY'){
            $cadena = substr_replace($cadena, $rem, 187, 8);
        }

        //estableve 25 espacios para remplazar el nombre de ciudad
        $rem = '                         ';

        //Busca el codigo de pais y si es igual a US o MX remplaza el nombe
        // de la ciudad por los 25 espacion vacios
        $codigoPais = substr($cadena, 258, 2);
        if( $codigoPais == 'US' || $codigoPais == 'MX'){
            $cadena = substr_replace($cadena, $rem, 260, 25);
            
        }
        
        return $cadena;
    }

    function contador( $cadena, $contador){
        
        $cont = strval($contador);
        $ncont = '';

        for($i = 0; $i<(9-strlen($cont)); $i++){
            $ncont = '0'.$ncont;
        }

        $ncont = $ncont.$cont;
        $cadena = substr_replace($cadena, $ncont, 423, 9);
        
        return $cadena;
    }

    function total_operaciones( $cadena, $cont){
        $cad = substr($cadena,22, 9);
        $total = intval($cad) - $cont;
        $ncont = '';
        for($i = 0; $i<(9-strlen(strval($total))); $i++){
            $ncont = '0'.$ncont;
        }
        $ncont = $ncont.(strval($total));
        $cadena = substr_replace($cadena, $ncont, 22, 9);
        return $cadena;
    }

    function motiv_incor( $cadena){
        $posicion = strpos( $cadena, '010501');
        if( $posicion !== false){
            $cadena = substr_replace($cadena, '010701', $posicion, 6);
        }
        $posicion = strpos( $cadena, '010001');
        if( $posicion !== false){
            $cadena = substr_replace($cadena, '010901', $posicion, 6);
        }
        $posicion = strpos( $cadena, '020001');
        if( $posicion !== false){
            $cadena = substr_replace($cadena, '020901', $posicion, 6);
        }

        return $cadena;
    }
    //359
    function clientes_ur( $cadena){
        if( strpos($cadena, 'CRCUY')){
            $valor = trim(substr($cadena, 359, 30));
            if( $valor != ''){
                $long = strlen($valor);
                $ult = substr($valor, $long-1, 1);
                $valor = substr_replace($valor, '-'.$ult , $long-1, $long+1);
                
                while( strlen($valor)<30)
                    $valor = $valor.' ';

                // echo $valor;
                // echo strlen($valor);
                $cadena = substr_replace($cadena, $valor, 359, 30);
            }
        }

        $pos = strpos($cadena, 'CRCUY'); /* devuelve la posicion de la cadena CRUY en la linea, false si no la encuentra */
        if( $pos != false && $pos != 359){
            $valor = trim(substr($cadena, $pos, 20)); // extrae 20 posiciones a partir de la posicion de CRCUY y elimina los espaios
            $long = strlen($valor); //calcula la longitud de la cadena 
            $ult = substr($valor, $long-1, 1); // extrae el ultim valor de la cadena
            $valor = substr_replace($valor, '-'.$ult , $long-1, $long+1); // agrega el gion y lo concatena con el ultimo valor de la cadena
            
            while( strlen($valor)<20) // agrega espacios hasta que la longitud de la cad sea 20
                $valor = $valor.' ';

            // echo $valor;
            // echo strlen($valor);
            $cadena = substr_replace($cadena, $valor, $pos, 20); //remplaza la cadena en la linea 20 espacios desde la posicion de CRCUY
        }
        
        return $cadena;
    }

    function clientes_py( $cadena){
        if( strpos($cadena, 'CRCPY')){
            $valor = trim(substr($cadena, 359, 30));
            if( $valor != ''){
                $long = strlen($valor);
                $end = substr($cadena,364,$long-5);
                $valor = 'CRP'.$end;
                //echo $valor;
                while( strlen($valor)<20)
                    $valor = $valor.' ';

                // echo $valor;
                // echo strlen($valor);
                $cadena = substr_replace($cadena, $valor, 359, 30);
            }
        }
        
        $pos = strpos($cadena, 'CRCPY'); /* devuelve la posicion de la cadena CRCPY en la linea, false si no la encuentra */
        if( $pos != false && $pos != 359){
                $valor = trim(substr($cadena, $pos, 20)); 
                $long = strlen($valor);
                $end = substr($cadena,$pos+5,$long-5);
                $valor = 'CRP'.$end;
                //echo $valor;
                while( strlen($valor)<20)
                    $valor = $valor.' ';

                // echo $valor;
                // echo strlen($valor);
                $cadena = substr_replace($cadena, $valor, $pos, 20);
            
        }

        return $cadena;
    }

    function Res902021($cadena){
        $rep = '  ';
        
        $cadena = substr_replace($cadena,$rep,176,1 );
        $cadena = substr_replace($cadena, $rep, 253,1);
        return $cadena;
    }
?>