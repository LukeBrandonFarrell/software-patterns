<?php

class StandardIterator implements Iterator {
    private $collection;

    /**
     * @var int Stores the current traversal position. An iterator may have a
     * lot of other fields for storing iteration state, especially when it is
     * supposed to work with a particular kind of collection.
     */
    private $position = 0;

    /**
     * @var bool This variable indicates the traversal direction.
     */
    private $reverse = false;

    public function __construct($collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }


    public function rewind()
    {
        $this->position = $this->reverse ?
            count($this->collection->getItems()) - 1 : 0;
    }

    public function current()
    {
        return $this->collection->getItems()[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position = $this->position + ($this->reverse ? -1 : 1);
    }

    public function valid()
    {
        return isset($this->collection->getItems()[$this->position]);
    }
}

class ArrayCollection implements IteratorAggregate {
    private $items = [];

    public function getItems(){
        return $this->items;
    }

    public function addItem($item){
        $this->items[] = $item;

        return $this;
    }

    public function getIterator()
    {
        return new StandardIterator($this);
    }

    public function getReverseIterator(){
        return new StandardIterator($this, true);
    }
}

$collection = new ArrayCollection();
$collection->addItem("A")->addItem("B")->addItem("C");

echo "Standard Traversal <br />";
foreach ($collection->getIterator() as $item){
    echo $item . "--";
}

echo "<br />";

echo "Reverse Traversal <br />";
foreach ($collection->getReverseIterator() as $item){
    echo $item . "--";
}