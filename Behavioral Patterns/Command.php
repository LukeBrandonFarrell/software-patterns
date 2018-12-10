<?php

/**
* The following showcases the command pattern for restoring state.
*/

interface Command {
    public function execute();
}

class PrintCommand implements Command {
    private $receiver;

    public function __construct($receiver)
    {
        $this->receiver = $receiver;
    }

    public function execute()
    {
        echo "Print command executed <br>";
        $this->receiver->run();
    }
}

class SaveCommand implements Command {
    private $receiver;

    public function __construct($receiver)
    {
        $this->receiver = $receiver;
    }

    public function execute()
    {
        echo "Save command executed <br>";
        $this->receiver->run();
    }
}

class Sender {
    protected $command;

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    public function executeCommand(){
        if($this->command instanceof Command) {
            $this->command->execute();
        }
    }
}

/*
 * Receiver interface
 */
interface Receiver {
    public function run();
}

/*
 * This is a receiver class.
 * Any class can serve as a receiver.
 */
class Printer implements Receiver {
    public function run(){
        echo "Document has been printed <br>";
    }
}

/*
 * This is a receiver class.
 * Any class can serve as a receiver.
 */
class Saver implements Receiver {
    public function run(){
        echo "Document has been Saved <br>";
    }
}

/**
 * Client Code
 */

$sender = new Sender();
$printer = new Printer();
$saver = new Saver();
$sender->setCommand(new PrintCommand($printer));
$sender->executeCommand();

$sender->setCommand(new SaveCommand($saver));
$sender->executeCommand();

