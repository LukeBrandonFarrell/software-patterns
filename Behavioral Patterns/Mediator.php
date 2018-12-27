<?php

interface Mediator {
    function notify($sender, $event);
}

class CheckBox {
    protected $mediator;

    public function __construct($mediator)
    {
        $this->mediator = $mediator;
    }

    public function check(){
        echo "CheckBox has been checked" . "<br />";
        $this->mediator->notify($this, "click");
    }
}

class TextBox {
    protected $mediator;

    public function __construct($mediator)
    {
        $this->mediator = $mediator;
    }

    public function input(){
        echo "TextBox has been updated" . "<br />";
        $this->mediator->notify($this, "click");
    }
}

class ConcreteMediator implements Mediator {
    public function notify($sender, $event)
    {
        if($event === "click") {
            if ($sender instanceof TextBox) {
                echo "Focus TextBox" . "<br />";
            }

            if ($sender instanceof CheckBox) {
                echo "Focus CheckBox" . "<br />";
            }
        }
    }
}

$mediator = new ConcreteMediator();
$textbox = new TextBox($mediator);
$checkbox = new CheckBox($mediator);

$textbox->input("A");
$checkbox->check();