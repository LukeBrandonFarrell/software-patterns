<?php

/**
 * The following showcases the builder pattern.
 */

 // Interface
interface ShapeBuilder
{
  public function createOutline($outline);
  public function createFill($color);
  public function createSize($size);

  public function reset();
  public function getShape();
}

class CircleBuilder implements ShapeBuilder {
  private $shape;

  public function __construct(){
    $this->reset();
  }

  public function createOutline($outline){
    $this->shape->outline = $outline;
  }

  public function createFill($color){
    $this->shape->fill = $color;
  }

  public function createSize($size){
    $this->shape->size = $size;
  }

  public function reset(){
    $this->shape = new Circle();
  }

  public function getShape() : Circle {
    $result = $this->shape;
    $this->reset();

    return $result;
  }
}

class Circle {
  public $outline = 1;
  public $fill = 'red';
  public $size = 20;

  public function draw(){
    return "<div style='width:" . $this->size . "; height:" . $this->size . "; border: 2px solid " . $this->outline . "; background-color: " . $this->fill . "; border-radius: 50%;'></div>";
  }
}

$builder = new CircleBuilder();

$builder->createOutline(3);
$builder->createFill('blue');
$builder->createSize(35);
$blueCircle = $builder->getShape();
echo $blueCircle->draw();

$builder->createSize(80);
$largeCircle = $builder->getShape();
echo $largeCircle->draw();
