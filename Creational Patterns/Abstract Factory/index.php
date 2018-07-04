<?php
/**
 * This is the abstract factory pattern.
 * The code will draw a circle and a Square
 * which can be configured in four diffrent
 * colours (blue, red, orange, and pink).
 */

// Abstract Factory
  interface ShapeFactory {
    public function createCircle();
    public function createSquare();
  }

  interface Square {
    public function draw();
  }

  interface Circle {
    public function draw();
  }

// Products
  // Circles
    class BlueCircle implements Circle {
      public function draw() {
        return "<div style='width:50px; height:50px; background-color: blue; border-radius: 50%;'></div>";
      }
    }
    class RedCircle implements Circle {
      public function draw() {
        return "<div style='width:50px; height:50px; background-color: red; border-radius: 50%;'></div>";
      }
    }
    class OrangeCircle implements Circle {
      public function draw() {
        return "<div style='width:50px; height:50px; background-color: orange; border-radius: 50%;'></div>";
      }
    }
    class PinkCircle implements Circle {
      public function draw() {
        return "<div style='width:50px; height:50px; background-color: pink; border-radius: 50%;'></div>";
      }
    }

  // Squares
    class BlueSquare implements Square {
      public function draw() {
        return "<div style='width:50px; height:50px; background-color: blue;'></div>";
      }
    }
    class RedSquare implements Square {
      public function draw() {
        return "<div style='width:50px; height:50px background-color: red;'></div>";
      }
    }
    class OrangeSquare implements Square {
      public function draw() {
        return "<div style='width:50px; height:50px; background-color: orange;'></div>";
      }
    }
    class PinkSquare implements Square {
      public function draw() {
        return "<div style='width:50px; height:50px; background-color: pink;'></div>";
      }
    }


// Concrete Factories
  class BlueFactory implements ShapeFactory {
    public function createCircle() : Circle {
      return new BlueCircle();
    }

    public function createSquare() : Square {
      return new BlueSquare();
    }
  }

  class RedFactory implements ShapeFactory {
    public function createCircle() : Circle {
      return new RedCircle();
    }

    public function createSquare() : Square {
      return new RedSquare();
    }
  }

  class OrangeFactory implements ShapeFactory {
    public function createCircle() : Circle {
      return new OrangeCircle();
    }

    public function createSquare() : Square {
      return new OrangeSquare();
    }
  }

  class PinkFactory implements ShapeFactory {
    public function createCircle() : Circle {
      return new PinkCircle();
    }

    public function createSquare() : Square {
      return new PinkSquare();
    }
  }

// Implementation

function createShape(ShapeFactory $factory){
  $circle = $factory->createCircle();
  $square = $factory->createSquare();

  echo $circle->draw();
  echo $square->draw();
}

createShape(new BlueFactory());
createShape(new OrangeFactory());
createShape(new RedFactory());
createShape(new PinkFactory());
