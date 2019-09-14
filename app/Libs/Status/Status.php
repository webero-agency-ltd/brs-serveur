<?php

namespace App\Libs\src\status;

use Illuminate\Auth\AuthManager;

class Status
{
    public $auth ; 
    
    public function __construct( AuthManager $auth )
    {
        $this->auth = $auth ;     
    }
    
}
