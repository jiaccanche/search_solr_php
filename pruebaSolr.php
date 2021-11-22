<?php
//Important https://lucene.apache.org/solr/guide/8_7/updating-parts-of-documents.html //Tiene la guia de como actualizar y eliminar
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
addDocument();

function addDocument(){
    $urls = 'https://www.marista.edu.mx/,https://www.unimodelo.edu.mx/,https://www.uady.mx/,http://www.cesctm.edu.mx/,https://www.itmerida.mx/';
    $urls = explode(",", $urls);
    $url_sorl = "http://localhost:8983/solr/new_core/update/extract?commit=true";
    for ($i=0; $i < count($urls); $i++) {
        echo "<br/>".$urls[$i];
        $data_string = petitionGuzzle($urls[$i]);//file_get_contents($data);   
        $html = "<meta property='url' content = '$urls[$i]'>".$data_string->getBody();
        try {
            if ($data_string->getStatusCode() == 200) {
                $html = remover_javascriptCSS($html);
                //echo '<script> console.log("'.$html.'");<script/>';
                //var_dump($html);
               $client = new Client();
                $response = $client->request(
                    'POST', 
                    $url_sorl, 
                    ['body' => $html,
                     'headers' => ['Content-type' => 'application/json'] 
                    ]
                );
                var_dump($response);
            }
        } catch (\Throwable $th) {
           echo $th;
        }

    }
}

function petitionGuzzle($url){
    try {
        // Create a client and provide a base URL
        $client = new Client();
        //var_dump($client);
        // Create a request with basic Auth
        $response = $client->request('GET', $url, ['verify' => false]);
       // echo "<br/> --------------------------------------------------";
        //var_dump($response);
        // Send the request and get the response
        // echo $response->getStatusCode();
        // echo $response->getBody();
        // var_dump($response->getHeaders());
        return $response;//->getBody();
    } catch (RequestException $e) {
        var_dump($e);
        //echo "<br/> -------------------------------------------------- 1";
        return $e->getResponse();
    } catch (ConnectException $e) {
        //echo "<br/> -------------------------------------------------- 2";
        echo $e;
        return $e->getHandlerContext();
    }
}

function remover_javascriptCSS($html) {

    $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
    $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $html);
    return $html;
}

?>