<?php

namespace App\Libs;

use Illuminate\Support\Facades\Facade;

class Application extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return \App\Libs\Application\Application::class;
    }

}