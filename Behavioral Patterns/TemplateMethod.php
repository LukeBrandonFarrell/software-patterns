<?php
/**
 * The following showcases the template method pattern.
 */

class Cryptography {
    protected $p = 0;
    protected $q = 0;
    protected $n = 0;

    protected $message;

    public function __construct($p, $q, $message){
        $this->p = $p;
        $this->q = $q;
        $this->message = $message;
    }

    public function run(){
        $this->setVariables($this->p, $this->q);
        $this->calculatePrime();
        $this->encryptMessage($this->message);
        $this->sendMessage();
    }

    public function setVariables($p, $q){
        $this->p = $p / 2;
        $this->q = $q * 4;
    }

    public function calculatePrime(){
        $this->n = $this->p * $this->q;
    }

    public function encryptMessage($message){
        $this->message = $message * $this->n;
    }

    public function sendMessage(){
        echo "Send message: " . $this->message . " via FTP";
    }
}

/**
 * Custom algorithms which override certain parts of our template method
 */
class PublicPrivateKey extends Cryptography {
    public function sendMessage(){
        echo "Send message: " . $this->message . " via HTTPS";
    }
}

class CustomEncryption extends Cryptography {
    public function calculatePrime(){
        $this->n = ($this->p * $this->q) + rand(25, 500);
    }
}

function clientCode(Cryptography $algorithm){
    $algorithm->run();
}

clientCode(new PublicPrivateKey(5, 6, 5422));
echo "<br/>";
clientCode(new CustomEncryption(5, 6, 5422));