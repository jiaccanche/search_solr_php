<?php
//$consulta = "MéRIDA not YUCATÁN";
    if(isset($_GET['consulta'])) {
        $diccionario = array("and", "or","not");
        $consulta = strtolower ($_GET['consulta']);
        $consulta = strtolower ($consulta);
        $arrayDividido = explode(" ", $consulta);
        $tamaño = count($arrayDividido);
        $sentenciaSolr = 'http://localhost:8983/solr/start/selectCheck?debug.explain.structured=true&debugQuery=on&df=attr_text&hl.fl=attr_text&hl=true&q=';
        $tipoAnterior = "elemento";
        //para el primer elemento
        $sentenciaSolr = $sentenciaSolr.'(*'.quitarTildes($arrayDividido[0]).'*)';

        for ($i=1; $i < $tamaño; $i++) {
            $variable = quitarTildes($arrayDividido[$i]);
            switch ($variable) {
                case $diccionario[0]:
                    $tipoAnterior = "and";
                    break;
                case $diccionario[1]:
                    $tipoAnterior = "or";
                    break;
                case $diccionario[2]:
                    $tipoAnterior = "not";
                    break;
                default:
                    $sentenciaSolr = agregarPalabra($variable, $tipoAnterior, $sentenciaSolr);
                    $tipoAnterior = "elemento";
                    break;
            }
        }
    } else{
        echo 'error';
    }

    //echo $sentenciaSolr;
    $resultados = file_get_contents($sentenciaSolr.'&wt=json');
    echo json_encode($resultados);

    function quitarTildes($cadena) {
        $no_permitidas = array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ");
        $permitidas = array ("a","e","i","o","u","A","E","I","O","U","n","N");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    function agregarPalabra($palabra, $tipoAnterior, $sentenciaSolr){
        if ($tipoAnterior == "elemento" || $tipoAnterior == "or") {
             $sentenciaSolr = $sentenciaSolr . 'OR(*' . $palabra .'*)';
        } else if ($tipoAnterior == "not") {
            $sentenciaSolr = $sentenciaSolr . '%20NOT(*' . $palabra .'*)';
        } else { 
            $sentenciaSolr = $sentenciaSolr . 'AND(*' . $palabra . '*)';
        }
        return $sentenciaSolr;
    }

?>