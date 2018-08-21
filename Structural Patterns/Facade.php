<?php

/*
 * The following is the Facade pattern to hide and decouple
 * complex systems from the client code.
 */

class BankFacade {
    protected $bankHandler;
    protected $currencyTransfer;
    protected $receiptHandler;

    public function __construct(
        BankHandler $bankHandler,
        CurrencyTransfer $currencyTransfer,
        RecieptHandler $receiptHandler
    )
    {
        $this->bankHandler = $bankHandler;
        $this->currencyTransfer = $currencyTransfer;
        $this->receiptHandler = $receiptHandler;
    }


    public function pay($amount, $email){
        if($this->bankHandler->checkBalance($amount)){
            $customer = $this->currencyTransfer->findCustomer($email);

            $this->currencyTransfer->transfer($customer);

            $this->receiptHandler->emailReciept;

            return $email . ' has been paid <br>';
        }

        return 'Not enough in bank to pay ' . $email . '<br>';
    }
}

/*
 * Complex subsystems
 */

class BankHandler {
    private $balance = 100;

    public function checkBalance($amount){
        if($amount < $this->balance){
            $this->balance = $this->balance - $amount;
            return true;
        }

        return false;
    }
}

class CurrencyTransfer {
    public function findCustomer($email){
        return 'Customer object';
    }

    public function transfer($customer){
        return 'transfer done to ' . $customer;
    }
}

class RecieptHandler {
    public function emailReciept(){
         return 'reciept has been emailed';
    }
}


function clientCode(BankFacade $facade){
    echo $facade->pay(20,'test@email.com');
    echo $facade->pay(200,'test@email.com');
}

// Subsystems
$bankHandler = new BankHandler();
$currencyTransfer = new CurrencyTransfer();
$receiptHandler = new RecieptHandler();

// Facade
$facade = new BankFacade($bankHandler, $currencyTransfer, $receiptHandler);
clientCode($facade);