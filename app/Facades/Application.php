<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Application extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return \App\Libs\Application\Application::class;
    }

}