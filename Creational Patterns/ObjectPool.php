<?php
/**
 * Object pool pattern. Would make sense
 * if you were making a game which needed
 * multiple objects to be created.
 */

class MissilePool {
  private static $instance;
  public $occupiedMissles = [];
  public $freeMissles = [];

  protected function __construct(){} // Private construct
  protected function __clone(){} // Not cloneable

  public static function getInstance() : MissilePool {

    if (! isset(self::$instance)) {
        self::$instance = new static;
    }

    return self::$instance;
  }

  public function getMissle(){
    if(count($this->freeMissles) == 0){
      $missle = new Missle;
      array_push($this->occupiedMissles, $missle);
    } else {
      $missle = array_pop($this->freeMissles);
    }

    return $missle;
  }

  public function release(Missle $missle){
    foreach($this->occupiedMissles as $value){
      if($value->id == $missle->id){
        // Remove missle from occupied
        $this->occupiedMissles = array_filter($this->occupiedMissles, function($item) use ($missle) {
          return ($item->id != $missle->id);
        });

        // Push missle into free missles
        array_push($this->freeMissles, $missle);
      }
    }
  }
}

class Missle {
  public $id;
  protected $x = 0;
  protected $y = 0;

  public function __construct(){
    $this->id = base64_encode(random_bytes(10));
  }

  public function setLocation($x, $y){
    $this->x = $x;
    $this->y = $y;
  }

  public function locate(){
    return "Missle is at x: " . $this->x . " and y: " . $this->y . "<br>";
  }
}

function client(){
  $payload = MissilePool::getInstance();

  $missleOne = $payload->getMissle();
  $missleOne->setLocation(345, 133);
  echo $missleOne->locate();

  $missleTwo = $payload->getMissle();
  $missleTwo->setLocation(122, 255);
  echo $missleTwo->locate();

  $payload->release($missleOne);

  $missleThree = $payload->getMissle();
  echo $missleThree->locate(); // Will have the same coordinates as missleOne as it has not been reset (for showcase)
}

client();
