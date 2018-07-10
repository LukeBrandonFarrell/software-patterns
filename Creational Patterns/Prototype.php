<?php
/**
 * This is the prototype pattern for cloning
 * multiple objects.
 */

class MissileTracker {
  public $speed;
  public $angle;
  public $type;

  public function __clone(){
    $this->speed = $this->speed;
    $this->angle = $this->angle;
    $this->type = $this->type;

    $this->type->missileTracker = $this;
  }
}

class Missile {
  public $missileTracker;
  public $name = 'Missle';

  public function __construct(MissileTracker $missileTracker){
    $this->missileTracker = $missileTracker;
  }
}


function client(){
  $missleTrackerOne = new MissileTracker();
  $missleTrackerOne->speed = '55km';
  $missleTrackerOne->angle = '257deg';
  $missleTrackerOne->type = new Missile($missleTrackerOne);

  $missleTrackerTwo = clone $missleTrackerOne;
  $missleTrackerTwo->angle = '15deg';

  echo 'Missle tracking systems [1] is at ' . $missleTrackerOne->speed . ' and ' . $missleTrackerOne->angle . ' tracking a ' . $missleTrackerOne->type->name . '<br>';
  echo 'Missle tracking systems [2] is at ' . $missleTrackerTwo->speed . ' and ' . $missleTrackerTwo->angle . ' tracking a ' . $missleTrackerTwo->type->name . '<br>';
}

client();
