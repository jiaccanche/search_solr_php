<?php
// use ICanBoogie\Inflector;

// $datos = array();
// $urls = 'https://www.marista.edu.mx/,https://www.unimodelo.edu.mx/,https://www.uady.mx/,http://www.cesctm.edu.mx/,https://www.unam.mx/,https://www.itmerida.mx/';
// $urls = explode(",", $urls);
// writeDocs("urls.txt", $urls);

// require_once 'vendor/autoload.php';
// $detector = new LanguageDetector\LanguageDetector();
// for ($i=0; $i < count($urls); $i++) {
//     $sitioweb = curl($urls[$i]);
//     $info = sanitizarTexto($sitioweb, $detector);
//     array_push($datos, array('url' => $urls[$i], 'description' => $info));
//     $nuevasUrls = extenderUrls($sitioweb, $urls[$i]);
//     $size = 0;
//     if (count($nuevasUrls) > 5) {
//         $size = 5;
//     } else {
//         $size = count($nuevasUrls);
//     }
//     for ($j=0; $j < $size; $j++) {
//         $sitioweb = curl($nuevasUrls[$j]);
//         $info = sanitizarTexto($sitioweb, $detector);
//         array_push($datos, array('url' => $nuevasUrls[$j], 'description' => $info));
//     }
// }
// DBConection($datos);

// function DBConection($datos){
//     $servername = "localhost";
//     $username = "root";
//     $password = "admin";
//     $dbname = "busquedas";

//     // Create connection
//     $conn = new mysqli($servername, $username, $password, $dbname);
//     // Check connection
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     $sql = "TRUNCATE TABLE documents";
//     $conn->query($sql);

//     for ($i=0; $i < count($datos); $i++) { 
//         // prepare and bind
//         $stmt = $conn->prepare("INSERT INTO documents (link, descripcion) VALUES (?, ?)");
//         $stmt->bind_param("ss", $link, $description);
//         $link = $datos[$i]['url'];
//         $description = $datos[$i]['description'];
//         $stmt->execute();
//     }
//     $conn->close();
// }

// function sanitizarTexto($sitioweb, $detector) {
//     require_once 'vendor/autoload.php';
//     $info = remover_javascriptCSS($sitioweb);
//     $info = strip_tags($info);
//     $info = strtolower($info);
//     $info = quitarTildes($info);
//     $info = preg_replace('/[^\pL]/', ' ', utf8_decode($info));
//     $idioma = $detector->evaluate($info)->getLanguage();
//     if (($idioma == 'en') || ($idioma == 'es')) {
//         $stopWords = array();
//         $stopWords = readStopWords('stop-words/'. $idioma .'.txt'); //$idioma es or en
//         $palabras = explode(" ", $info);
//         $info = eliminarStopWords($palabras, $stopWords);
//         $info = singularizar($info, $idioma);
//     }
//     return $info;
// }

// function remover_javascriptCSS($html) {

//     $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
//     $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $html);
//     return $html;
// }

// function eliminarStopWords($cadena, $stopWords){
//     $info = $cadena;
//     for ($j=0; $j < count($info); $j++) {
//         for ($i=0; $i < count($stopWords); $i++) { 
//             if ($info[$j] == trim($stopWords[$i])) {
//                 $info[$j] = "";
//             }
//         }
//     }
//     return $info;
// }

// function writeDocs($fileLocation, $urls) {
//     $file = fopen($fileLocation, "w");
//     for ($i=0; $i < count($urls); $i++) {
//         fwrite($file, $urls[$i] . PHP_EOL);
//     }
//     fclose($file);
// }

// function readStopWords($fileName){
//     $stopWords = array();
//     $file = fopen($fileName, "r");
//     while(!feof($file)) {
//         array_push($stopWords, fgets($file));
//     }
//     fclose($file);
//     return $stopWords;
// }

// function curl($url) {
//     $ch = curl_init($url); // Inicia sesión cURL
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
//     $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
//     curl_close($ch); // Cierra sesión cURL
//     return $info; // Devuelve la información de la función
// }

// function quitarTildes($cadena) {
//     $no_permitidas = array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ");
//     $permitidas = array ("a","e","i","o","u","A","E","I","O","U","n","N");
//     $texto = str_replace($no_permitidas, $permitidas, $cadena);
//     return $texto;
// }

// function extenderUrls($html, $url) {
//     $doc = new DOMDocument();
//     $opts = array('output-xhtml' => true,
//                 'numeric-entities' => true);
//     $doc->loadXML(tidy_repair_string($html,$opts));
//     $xpath = new DOMXPath($doc);
//     $xpath->registerNamespace('xhtml','http://www.w3.org/1999/xhtml');
//     $enlaces = array();
//     foreach ($xpath->query('//xhtml:a/@href') as $node) {
//         $link =  (( substr($node->nodeValue,0,4) == 'http' ) ?  $node->nodeValue : $url . $node->nodeValue ) ;
//         array_push($enlaces, $link);
//     }
//     return $enlaces;
// }

// function singularizar($palabras, $idioma){
//     require_once 'vendor/autoload.php';
//     $cadena = "";
//     for ($i=0; $i < count($palabras); $i++) {
//         if ($palabras[$i] != "") {
//             $cadena = $cadena . Inflector::get($idioma)->singularize(trim($palabras[$i])) . " ";
//         }
//     }
//     return $cadena;
// }

use ICanBoogie\Inflector;


$datos = array();
$urls = 'https://www.marista.edu.mx/,https://www.unimodelo.edu.mx/,https://www.uady.mx/,http://www.cesctm.edu.mx/,https://www.unam.mx/,https://www.itmerida.mx/';
$urls = explode(",", $urls);
writeDocs("urls.txt", $urls);
    
require_once 'vendor/autoload.php';
$detector = new LanguageDetector\LanguageDetector();
for ($i=0; $i < count($urls); $i++) {
    $fecha = getModifiedDate($urls[$i]);
    if (validarFecha($urls[$i], $fecha) == false) {
        $sitioweb = curl($urls[$i]);
        $info = sanitizarTexto($sitioweb, $detector);
        array_push($datos, array('url' => $urls[$i], 'description' => $info, 'date' => $fecha));
        $nuevasUrls = extenderUrls($sitioweb, $urls[$i]);
        $size = 0;
        if (count($nuevasUrls) > 5) {
            $size = 5;
        } else {
            $size = count($nuevasUrls);
        }
        for ($j=0; $j < $size; $j++) {
            $fecha = getModifiedDate($nuevasUrls[$j]);
            if (validarFecha($nuevasUrls[$j], $fecha) == false) {
                $sitioweb = curl($nuevasUrls[$j]);
                $info = sanitizarTexto($sitioweb, $detector);
                array_push($datos, array('url' => $nuevasUrls[$j], 'description' => $info, 'date' => $fecha));
            }
        }
    }
}
DBConection($datos);
echo 'Resultados indizados';




function validarFecha($url, $fecha) {
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "busquedas";
    $flag = false;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT fecha FROM documents where link = '$url' LIMIT 1";
    $result = $conn->query($sql);
    $resultado = $result->fetch_assoc();
    if ($resultado['fecha'] == $fecha) {
        $flag = true;
    }
    return $flag;
}

function DBConection($datos){
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "busquedas";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    for ($i=0; $i < count($datos); $i++) { 

        $sql = "SELECT * FROM documents WHERE link = '" . $datos[$i]['url'] . "' Limit 1";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO documents (link, descripcion, fecha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $link, $description, $date);
            $link = $datos[$i]['url'];
            $description = $datos[$i]['description'];
            $date = $datos[$i]['date'];
            $stmt->execute();
        }
    }
    $conn->close();
}

function sanitizarTexto($sitioweb, $detector) {
    require_once 'vendor/autoload.php';
    $info = remover_javascriptCSS($sitioweb);
    $info = strip_tags($info);
    $info = strtolower($info);
    $info = quitarTildes($info);
    $info = preg_replace('/[^\pL]/', ' ', utf8_decode($info));
    $idioma = $detector->evaluate($info)->getLanguage();
    if (($idioma == 'en') || ($idioma == 'es')) {
        $stopWords = array();
        $stopWords = readStopWords('stop-words/'. $idioma .'.txt'); //$idioma es or en
        $palabras = explode(" ", $info);
        $info = eliminarStopWords($palabras, $stopWords);
        $info = singularizar($info, $idioma);
    }
    return $info;
}

function remover_javascriptCSS($html) {

    $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
    $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $html);
    return $html;
}

function eliminarStopWords($cadena, $stopWords){
    $info = $cadena;
    for ($j=0; $j < count($info); $j++) {
        for ($i=0; $i < count($stopWords); $i++) { 
            if ($info[$j] == trim($stopWords[$i])) {
                $info[$j] = "";
            }
        }
    }
    return $info;
}

function writeDocs($fileLocation, $urls) {
    $file = fopen($fileLocation, "w");
    for ($i=0; $i < count($urls); $i++) {
        fwrite($file, $urls[$i] . PHP_EOL);
    }
    fclose($file);
}

function readStopWords($fileName){
    $stopWords = array();
    $file = fopen($fileName, "r");
    while(!feof($file)) {
        array_push($stopWords, fgets($file));
    }
    fclose($file);
    return $stopWords;
}

function curl($url) {
    $ch = curl_init($url); // Inicia sesión cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
    $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
    curl_close($ch); // Cierra sesión cURL
    return $info; // Devuelve la información de la función
}

function getModifiedDate($url) {
    $ch = curl_init(); // Inicia sesión cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
    curl_setopt($ch, CURLOPT_FILETIME, true);
    $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
    $header = curl_getinfo($ch);
    curl_close($ch); // Cierra sesión cURL
    return date ("d-m-Y H:i:s", $header['filetime']); // Devuelve la información de la función
}

function quitarTildes($cadena) {
    $no_permitidas = array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ");
    $permitidas = array ("a","e","i","o","u","A","E","I","O","U","n","N");
    $texto = str_replace($no_permitidas, $permitidas, $cadena);
    return $texto;
}

function extenderUrls($html, $url) {
    $doc = new DOMDocument();
    $opts = array('output-xhtml' => true,
                'numeric-entities' => true);
    $doc->loadXML(tidy_repair_string($html,$opts));
    $xpath = new DOMXPath($doc);
    $xpath->registerNamespace('xhtml','http://www.w3.org/1999/xhtml');
    $enlaces = array();
    foreach ($xpath->query('//xhtml:a/@href') as $node) {
        $link =  (( substr($node->nodeValue,0,4) == 'http' ) ?  $node->nodeValue : $url . $node->nodeValue ) ;
        array_push($enlaces, $link);
    }
    return $enlaces;
}

function singularizar($palabras, $idioma){
    require_once 'vendor/autoload.php';
    $cadena = "";
    for ($i=0; $i < count($palabras); $i++) {
        if ($palabras[$i] != "") {
            $cadena = $cadena . Inflector::get($idioma)->singularize(trim($palabras[$i])) . " ";
        }
    }
    return $cadena;
}

?>