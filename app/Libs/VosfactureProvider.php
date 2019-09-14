<?php

namespace App\Libs;

use App\Libs\Vosfacture\Vosfacture;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;

class VosfactureProvider extends ServiceProvider
{
	public function register()
	{
	    $this->app->singleton('Vosfacture', function($app) {
	        return new Vosfacture() ; 
	    });
	}

}