<?php

namespace App\Providers;

use App\Libs\Application\Application;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;

class ApplicationProvider extends ServiceProvider
{
	public function register()
	{
	    $this->app->singleton('Application', function($app) {
	        return new Application() ; 
	    });
	}

}