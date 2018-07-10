<?php

/**
 * Bridge patterm
 * Types of cars with attributes of
 * colour and wheels.
 */

 /*
 * Abstraction
 */

abstract class Car {
  protected $wheels;
  protected $body;

  public function __construct(Wheels $wheels, Body $body){
    $this->wheels = $wheels;
    $this->body = $body;
  }

  abstract public function drive();
}

/*
* Refinded abstraction
*/

class AlfaRomeo extends Car {
  public function drive(){
    return 'Driving Alfa Romeo with ' . $this->wheels->getMaterial() . ' wheels and a ' . $this->body->getColour() . ' body paint.';
  }
}

class BMW extends Car {
  public function drive(){
    return 'Driving BMW with ' . $this->wheels->getMaterial() . ' wheels and a ' . $this->body->getColour() . ' body paint.';
  }
}

class AstonMartin extends Car {
  public function drive(){
    return 'Driving Aston Martin with ' . $this->wheels->getMaterial() . ' wheels and a ' . $this->body->getColour() . ' body paint.';
  }
}



/*
* Implementation
*/

interface Wheels {
  public function getMaterial();
}

interface Body {
  public function getColour();
}

/*
* Concrete classes
*/

class GeneralWheels implements Wheels {
  public function getMaterial(){
    return 'Steel';
  }
}

class ExpensiveWheels implements Wheels {
  public function getMaterial(){
    return 'Titanium';
  }
}

class GeneralBody implements Body {
  public function getColour(){
    return 'Red';
  }
}

class ExpensiveBody implements Body {
  public function getColour(){
    return 'Gold';
  }
}

/*
* Multiple combinations of cars
* each car can have four diffrent
* combinations of attributes without
* adding multiple subclasses. E.g. in
* the AbstractFactory.php examples.
*
* Bridge and AbstractFactory can work
* together.
*/

$generalWheels = new GeneralWheels();
$expensiveWheels = new ExpensiveWheels();
$generalBody = new GeneralBody();
$expensiveBody = new ExpensiveBody();

$alfaRomeo = new AlfaRomeo($generalWheels, $generalBody);
$bmw = new BMW($expensiveWheels, $generalBody);
$astonMartin = new AstonMartin($generalWheels, $expensiveBody);

echo $alfaRomeo->drive() . '<br>';
echo $bmw->drive(). '<br>';
echo $astonMartin->drive(). '<br>';
