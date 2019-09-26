<?php

namespace App\Providers;

use App\Libs\Application\Application;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;

class OptionProvider extends ServiceProvider
{
	public function register()
	{
	    $this->app->singleton('Option', function($app) {
	        return new Option() ; 
	    });
	}

}