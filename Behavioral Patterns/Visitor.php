<?php

/**
 * The following showcases the visitor pattern.
 *
 * Exporter is the visitor interface
 */
interface Exporter {
    function visitCircle(Circle $circle);
    function visitRectangle(Rectangle $rectangle);
}

class ExportText implements Exporter {
    public function visitCircle(Circle $circle){
        echo "Circle at {$circle->x}, {$circle->y} with a size of {$circle->width}, {$circle->height}";
    }

    public function visitRectangle(Rectangle $rectangle){
        echo "Rectangle at {$rectangle->x}, {$rectangle->y} with a size of {$rectangle->width}, {$rectangle->height}";
    }
}

class ExportHTML implements Exporter {
    public function visitCircle(Circle $circle){
        echo "<div style='width:{$circle->width}; height:{$circle->height}; background-color: pink; border-radius: 50%;'></div>";
    }

    public function visitRectangle(Rectangle $rectangle){
        echo "<div style='width:{$rectangle->width}; height:{$rectangle->height}; background-color: red;'></div>";
    }
}

/**
 * Abstract implementation
 */
abstract class Shape {
    public $x, $y, $width, $height;

    abstract function set($x, $y);
    abstract function size($width, $height);
    abstract function accept(Exporter $visitor);
}

/**
 * Concrete implementation
 */
class Circle extends Shape {
    public function set($x, $y){
       $this->x = $x;
       $this->y = $y;
    }

    public function size($width, $height){
        $this->width = $width;
        $this->height = $height;
    }

    public function accept(Exporter $visitor){
        $visitor->visitCircle($this);
    }
}

class Rectangle extends Shape {
    public function set($x, $y){
        $this->x = $x;
        $this->y = $y;
    }

    public function size($width, $height){
        $this->width = $width;
        $this->height = $height;
    }

    public function accept(Exporter $visitor){
        $visitor->visitRectangle($this);
    }
}

/**
 * The client can extend exporter to export shapes in any format they want without having to change code in the shape
 * classes.
 */
function clientCode(Shape $shape, Exporter $visitor){
    $shape->accept($visitor);
}

$circle = new Circle();
$circle->set(30, 40);
$circle->size(50, 50);

$rectangle = new Rectangle();
$rectangle->set(30, 40);
$rectangle->size(20, 50);

$components = [$circle, $rectangle];

$exportHtmlVisitor = new ExportHTML();
$exportTextVisitor = new ExportText();

clientCode($circle, $exportHtmlVisitor);
clientCode($circle, $exportTextVisitor);
clientCode($rectangle, $exportHtmlVisitor);
clientCode($rectangle, $exportTextVisitor);