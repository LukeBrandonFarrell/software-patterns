<?php

/**
 * Composite design pattarn.
 */

abstract class Product
{
  protected $parent;

  public function setParent(Product $product){
    $this->parent = $parent;
  }
  public function getParent() : Product {
    return $this->parent;
  }

  public abstract function getPrice();
  public function add(Product $component){}
  public function remove(Product $component){}

  public function isComposite(): bool {
    return false;
  }
}

class CokaColaBox extends Product {
  protected $children = [];

  public function getPrice() {
    $results = [];

    foreach ($this->children as $child) {
        $results[] = $child->getPrice();
    }

    return array_sum($results);
  }

  public function add(Product $component)
  {
      $this->children[] = $component;
      $component->setParent($this);
  }

  public function remove(Product $component)
  {
      $this->children = array_filter($this->children, function ($child) use ($component) {
          return $child == $component;
      });
      $component->setParent(null);
  }

  public function isComposite(): bool {
    return true;
  }
}

class CokaCola extends Product {
  public function getPrice() {
    return 1.29;
  }
}

/* Client code */

$cocacola = new CokaCola();
print('The price of one CocaCola is ' . $cocacola->getPrice() . '<br>');

$box1 = new CokaColaBox();
$box2 = new CokaColaBox();

for ($i=0; $i<8; $i++) {
  $box1->add(new CokaCola());
  $box2->add(new CokaCola());
}

$box3 = new CokaColaBox();
$box3->add($box1);
$box3->add($box2);

print('The price of 16 CocaCola is ' . $box3->getPrice() . '<br>');

/* Client code can also work with abstractions */

function client(Product $productOne, Product $productTwo){
  if($productOne->isComposite()){
    $productOne->add($productTwo);
  }

  print('The price calculated through abstract clases is ' . $productOne->getPrice());
}

client($box1, $cocacola);
