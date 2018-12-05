<?php

/**
 * The following showcases the observer pattern.
 */

/**
 * Listeners
 */

interface EventListener {
    public function update($filename);
}

class LoggingListener implements EventListener {
    public function update($filename){
        echo "Event logged to System " . $filename . "<br>";
    }
}

class LinterListener implements EventListener {
    public function update($filename){
        echo "Linter has been executed " . $filename . "<br>";
    }
}

class AutoSaveListener implements EventListener {
    public function update($filename){
        echo "File has been saved to system " . $filename . "<br>";
    }
}

/**
 * Publisher
 */


class EventManager {
    protected $subscribers = [];

    public function subscribe(EventListener $subscriber){
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(EventListener $subscriber){
        $key = array_search($subscriber, $this->subscribers);

        if($key !== false){
            unset($this->subscribers[$key]);
        }
    }

    public function notify($filename){
        foreach ($this->subscribers as $subscriber){
            $subscriber->update($filename);
        }
    }
}


class Editor {
    public $dispatcher;
    private $name = "./code.js";

    public function __construct(EventManager $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function open(){
        $this->dispatcher->notify($this->name);
    }
}

class Game {
    public $dispatcher;
    private $name = "./applications/game.cmd";

    public function __construct(EventManager $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function play(){
        $this->dispatcher->notify($this->name);
    }
}

/**
 * Client Code
 */

// Publisher
$dispatcher = new EventManager();

// Listeners
$logger = new LoggingListener();
$liner = new LinterListener();
$autoSave = new AutoSaveListener();

$game = new Game($dispatcher);
$game->dispatcher->subscribe($logger);
$game->play();

$editor = new Editor($dispatcher);
$editor->dispatcher->subscribe($logger);
$editor->dispatcher->subscribe($liner);
$editor->open();

echo "Now with AutoSave subscriber and without linter:" . "<br>";

$editor->dispatcher->unsubscribe($liner);
$editor->dispatcher->subscribe($autoSave);
$editor->open();