<?php


namespace App;


use Core\Security\OriginBase;

class Origins extends OriginBase
{
    public function __construct()
    {
        parent::__construct();

        $this->Allow("localhost")
            ->Allow("127.0.0.1")
            ->Allow("http://localhost:4200");
    }

}