<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Infusionsoft extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return \App\Libs\Infusionsoft\Infusionsoft::class;
    }

}