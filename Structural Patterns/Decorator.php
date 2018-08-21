<?php

/*
 * The decorator pattern used to extend the functionality of
 * concrete classes by adding to their standard behaviour.
 */

interface DataSource {
    function readData();
}


class FileDataSource implements DataSource {
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function readData()
    {
        $csvFile = file($this->filename);
        $data = [];

        foreach($csvFile as $line){
            $data[] = $line;
        }

        return $data;
    }
}


class JsonDecorator implements DataSource {
    protected $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    // Returns the data in json format
    public function readData(){
        return json_encode($this->dataSource->readData());
    }
}

class Base64Decorator implements DataSource {
    protected $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    // Returns the data in base64 format
    public function readData(){
        return base64_encode(implode(".", $this->dataSource->readData()));
    }
}

class StripCharactersDecorator implements DataSource {
    protected $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    // Returns the data in base64 format
    public function readData(){
        return str_replace("$", "", $this->dataSource->readData());
    }
}

$fileDecorator = new FileDataSource('data/analytics.csv');
$jsonDecorator = new JsonDecorator($fileDecorator);
$base64Decorator = new Base64Decorator($fileDecorator);

echo 'Unfiltered JSON Data -> ' . $jsonDecorator->readData() . '<br>';
echo 'Unfiltered Base64 Data -> ' . $base64Decorator->readData() . '<br>';

$stripDecorator = new StripCharactersDecorator($fileDecorator);
$filteredJsonDecorator = new JsonDecorator($stripDecorator);
$filteredBase64Decorator = new Base64Decorator($stripDecorator);

echo 'Filtered JSON Data -> ' . $filteredJsonDecorator->readData() . '<br>';
echo 'Filtered Base64 Data -> ' . $filteredBase64Decorator->readData() . '<br>';