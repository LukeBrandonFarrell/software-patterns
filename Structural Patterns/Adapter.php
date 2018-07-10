<?php

/**
 * Services used to retrive data
 * from external source.
 */

class AnalyticsCsvService {
  public function fetchData(){
    $csvFile = file('data/analytics.csv');
    $data = [];

    foreach($csvFile as $line){
      $data[] = $line;
    }

    return $data;
  }
}


/*
* Adapter used to convert data to the
* correct format.
*/

class ChartAdapterCsv extends Chart {
  public $service;

  public function __construct(AnalyticsCsvService $service) {
    $this->service = $service;
  }

  public function displayData() {
    $data = $this->service->fetchData();

    $array = [];
    $array['views'] = str_replace(',', '', $data[0]);
    $array['likes'] = str_replace(',', '', $data[1]);
    $array['dislikes'] = str_replace(',', '', $data[2]);

    return json_encode($array);
  }
}

/*
  Default behaviour
*/

class Chart {
  public function displayData() {
    // Display data - default json behvaiour
    return json_encode(array('views' => '456', 'likes' => '6', 'dislikes' => '2'));
  }
}

/*
* Client code
*/

function client(Chart $chart){
  $data = json_decode($chart->displayData());
  print('Views: ' . $data->views . '<br>');
  print('Likes: ' . $data->likes . '<br>');
  print('Dislikes: ' . $data->dislikes . '<br>');
}

// Default data source
print('<b>Default Data</b> <br><br>');
$chart = new Chart();
client($chart);

print('<br><br><br>');

print('<b>CSV Data</b> <br><br>');
$csvChart = new ChartAdapterCsv(new AnalyticsCsvService);
client($csvChart);
