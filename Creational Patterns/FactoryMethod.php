<?php
/**
 * This is the factory method pattern.
 * This code will print a transport option
 * to the screen.
 */

interface Transport {
  public function type();
}

abstract class TransportCreator {
  public abstract function createTransport() : Transport;

  public function travel(){
    $transport = $this->createTransport();

    return 'You are currently travelling by ' . $transport->type();
  }
}

// Products
class Car implements Transport {
  public function type(){
    return 'Car';
  }
}

class Plane implements Transport {
  public function type(){
    return 'Plane';
  }
}

class Boat implements Transport {
  public function type(){
    return 'Boat';
  }
}

// Creators
class CarTravel extends TransportCreator {
  public function createTransport() : Transport {
    return new Car();
  }
}
class PlaneTravel extends TransportCreator {
  public function createTransport() : Transport {
    return new Plane();
  }
}
class BoatTravel extends TransportCreator {
  public function createTransport() : Transport {
    return new Boat();
  }
}

// Client

function client(TransportCreator $transport){
  // How is the user travelling?
  echo $transport->travel() . "<br>";
}

//client(new CarTravel());
//client(new PlaneTravel());
client(new BoatTravel());
