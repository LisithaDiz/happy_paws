<?php

class VetRequest
{
    use Controller;

    public function index()
    {
        $this->view('vetrequest');
    }
}