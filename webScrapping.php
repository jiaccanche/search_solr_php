<?php
use ICanBoogie\Inflector;
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

if(isset($_GET['urls'])) {
    $datos = array();
    $urls = $_GET['urls'];
    $urls = explode(",", $urls);
    $datos = readDoc();
    writeDocs("urls.txt", $urls);
    
    $ch = curl_init("http://localhost:8983/solr/start/update/extract?commit=true"); 

    for ($i=0; $i < count($urls); $i++) {
        if (in_array($urls[$i], $datos) != 1 && $urls[$i] != null){
            $data_string = petitionGuzzle($urls[$i]);
            $html = "<meta property='url' content = '$urls[$i]'>".$data_string->getBody();
            try {
                if ($data_string->getStatusCode() == 200) {
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $html);
                    echo curl_exec($ch);
                }
            } catch (\Throwable $th) {
                echo $data_string["error"];
            }
        }
    }
    echo 'Resultados indizados';
} else {
    echo 'error';
}


    function petitionGuzzle($url){
        try {
            // Create a client and provide a base URL
            $client = new Client();
            // Create a request with basic Auth
            $response = $client->request('GET', $url);
            return $response;//->getBody();
        } catch (RequestException $e) {
            return $e->getResponse();
        } catch (ConnectException $e) {
            return $e->getHandlerContext();
        }
    }

    function remover_javascriptCSS($html) {

        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
        $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $html);
        return $html;
    }

function writeDocs($fileLocation, $urls) {
  $file = fopen($fileLocation, "w");
  for ($i=0; $i < count($urls); $i++) {
    fwrite($file, $urls[$i] . PHP_EOL);
  }
  fclose($file);
}

function readDoc(){
    $file = file("urls.txt");
    for ($i=0; $i < count($file); $i++) {
        if (strlen($file[$i]) != 2) {
            $file[$i] = preg_replace('/\n/','', utf8_decode($file[$i]));
            $file[$i] = substr($file[$i], 0, -1);
        }
    }
    return $file;
}
?>