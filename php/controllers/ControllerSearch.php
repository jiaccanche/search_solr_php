<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'\search_solr_php\php\services\GeneratorQuerySolr.php');

class ControllerSearch
{
    public function search($request){
        $query = new GeneratorQuerySolr();
        $resultados = file_get_contents($query->generateQuery($request).'&wt=json');
        return json_encode($resultados);
    }
}