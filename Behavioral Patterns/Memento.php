<?php

/**
 * The following showcases the memento pattern for restoring state.
 */

interface Memento {
    public function getSnapshotDate();
}


interface History {
    public function save();
    public function restore(Memento $memento);
}


/**
 * Class EditorMemento - Concrete memento class for
 */
class EditorMemento implements Memento {
    private $text;
    private $timestamp;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function getText(){
        return $this->text;
    }

    public function getSnapshotDate(){
        return $this->timestamp;
    }
}


/**
 * Class Editor - Concrete class for editor
 */
class Editor implements History  {
    private $text;

    public function edit($text){
        $this->text = $this->text . $text;
        echo "Input value: $this->text <br>";
    }

    public function save(){
        echo "Saved to history: $this->text <br>";
        return new EditorMemento($this->text);
    }

    public function restore(Memento $memento){
        if(!$memento instanceof EditorMemento){
            throw new \Exception("Unknown memento class ".get_class($memento));
        }

        $this->text = $memento->getText();

        echo "Restored from history: $this->text <br>";
    }
}

/**
 * Class History - Keeps a stack of all memento objects for UNDO behaviour
 */
class HistoryManager {
    private $mementos = [];

    private $history;

    public function __construct(History $history)
    {
        $this->history = $history;
    }

    public function save(){
        $this->mementos[] = $this->history->save();
    }

    public function undo(){
        if(! count($this->mementos)){
            return;
        }

        $memento = array_pop($this->mementos);

        $this->history->restore($memento);
    }
}

/**
 * Client Code
 */
$editor = new Editor();
$history = new HistoryManager($editor);
$editor->edit("Hello");
$history->save();
$editor->edit("World");
$history->undo();
$history->save();
$editor->edit("!");
$history->undo();
$history->save();