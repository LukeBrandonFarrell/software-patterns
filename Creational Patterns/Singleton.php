<?php
/**
 * Singleton pattern. Although this could
 * be considered to be an anti-pattern.
 */

class Database {
  private static $instance;
  protected function __construct(){} // Private construct
  protected function __clone(){} // Not cloneable

  public static function getInstance() : Database {

    if (! isset(self::$instance)) {
        self::$instance = new static;
    }

    return self::$instance;
  }

  public function connect(){
    return 'Has been connected to database.';
  }
}

function client(){
  $instanceOne = Database::getInstance();
  $instanceTwo = Database::getInstance();

  if($instanceOne === $instanceTwo){
    echo $instanceOne->connect() . '<br>';
    echo 'Instances are the same';
  }
}

client();
