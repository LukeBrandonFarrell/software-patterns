<?php

/**
 * The following showcases the strategy pattern.
 */

interface FetchData {
    function run($url, $params);
}

class FetchDataFromUrlUsingHTTP implements FetchData {
    public function run($url, $params){
        return "This data is returned from a HTTP connection... using " . $url . " and parameters: " . $params;
    }
}

class FetchDataFromUrlUsingTCP implements FetchData {
    public function run($url, $params){
        return "This data is returned from a TCP connection... " . $url . " and parameters: " . $params;
    }
}

class Context {
    private $dataFetcher; // < -- This is the strategy

    public function __construct(FetchData $dataFetcher)
    {
        $this->dataFetcher = $dataFetcher;
    }

    public function setFetcher(FetchData $dataFetcher){
        $this->dataFetcher = $dataFetcher;
    }

    public function runFetcher($url, $params) {
        return $this->dataFetcher->run($url, $params);
    }
}

/* Client code  */
function clientCode($method){
    $fetcher = null;

    if($method == "tcp"){
        $fetcher = new FetchDataFromUrlUsingTCP();
    } else if($method == "http") {
        $fetcher = new FetchDataFromUrlUsingHTTP();
    } else {
        return;
    }

    $context = new Context($fetcher);

    echo $context->runFetcher("http://lotsof.data", "ordered, trimmed, with-photo");
}

clientCode('tcp');

echo "<br><br>";

clientCode('http');
