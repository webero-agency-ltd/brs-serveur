<?php

namespace App\Libs\src\assignation;

use Illuminate\Auth\AuthManager;

class Assignation
{
    public $auth ; 
    
    public function __construct( AuthManager $auth )
    {
        $this->auth = $auth ;     
    }
    
}
