<?php

/**
 * State interface
 */
abstract class State {
    protected $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    abstract function clickPlay();
}

class PausedState extends State {
    public function clickPlay()
    {
        $this->player->startPlayback();
    }
}

class PlayingState extends State {
    public function clickPlay()
    {
        $this->player->stopPlayback();
    }
}

class LockedState extends State {
    public function clickPlay()
    {
        $this->player->lockPlayback();
    }
}

/**
 * Application Context
 */
class Player {
    protected $state;

    public function __construct()
    {
        $this->state = new PausedState($this);
    }

    public function changeState(State $state){
        $this->state = $state;
    }

    public function clickPlay(){
        $this->state->clickPlay();
    }

    public function startPlayback(){
        echo "Playback has been started <br>";
    }

    public function stopPlayback(){
        echo "Playback has been stopped <br>";
    }

    public function lockPlayback(){
        echo "Playback has been locked <br>";
    }
}

/* Client Code */
function clientCode(Player $player, State $state){
    $player->changeState($state);
    echo "Changing state <br>";
    $player->clickPlay();
}

$player = new Player();
$pausedState = new PausedState($player);
$playingState = new PlayingState($player);
$lockedState = new LockedState($player);

clientCode($player, $pausedState);
clientCode($player, $playingState);
clientCode($player, $lockedState);