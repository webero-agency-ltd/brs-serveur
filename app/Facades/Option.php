<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Option extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return \App\Libs\Option\Option::class;
    }

}