<?php

interface Handler {
    function setNext($handler);
    function handle($request);
}

class BaseHandler implements Handler {
    protected $next;

    function setNext($handler)
    {
        $this->next = $handler;

        return $handler;
    }

    public function handle($request)
    {
        if($this->next) $this->next->handle($request);
    }
}

class TrimMiddleware extends BaseHandler {
    public function handle($request)
    {
        $request = trim($request);
        echo "Request Trim: " . $request . "<br />";

        parent::handle($request);
    }
}

class RemoveLetterMiddleware extends BaseHandler {
    public function handle($request)
    {
        $request = str_replace("A", "%", $request);
        echo "Request Letter Replaced: " . $request . "<br />";

        parent::handle($request);
    }
}

class ArrayMiddleware extends BaseHandler {
    public function handle($request)
    {
        $request = explode(":", $request);
        echo "Request as Array: <br />";
        var_dump($request);

        parent::handle($request);
    }
}

/*
 * Client Code
 */
$password1 = "   AAHG:SYY:AAA:7   ";
$password2 = " 3AHH:II9A";

$trimMiddleware = new TrimMiddleware();
$removeLetterMiddleware = new RemoveLetterMiddleware();
$arrayMiddleware = new ArrayMiddleware();

$trimMiddleware->setNext($removeLetterMiddleware)->setNext($arrayMiddleware);

echo "Handling: " . $password1 . "<br />";
$trimMiddleware->handle($password1);
echo "<br /><br />";
echo "Handling: " . $password2 . "<br />";
$trimMiddleware->handle($password2);

