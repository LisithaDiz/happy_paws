<?php

class PaymentForm
{
    use Controller;

    public function index()
    {
        $this->view('paymentform');
    }
}