<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Vosfacture extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return \App\Libs\Vosfacture\Vosfacture::class;
    }

}