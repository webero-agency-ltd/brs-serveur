<?php

namespace App\Libs;

use App\Libs\Infusionsoft\Infusionsoft;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;

class InfusionsoftProvider extends ServiceProvider
{
	public function register()
	{
	    $this->app->singleton('Infusionsoft', function($app) {
	        return new Infusionsoft() ; 
	    });
	}

}