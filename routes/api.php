<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'middleware' => 'auth:api'], function() {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //route des applications 
    Route::resource('/application', 'Api\ApplicationController', ['except' => ['create','edit']]);
    //Route::resource('/permissions', 'Api\ApplicationController', ['except' => ['create', 'edit']]);

    //ici on chech dans IFS s'il l'application IFS na pas encore initiélisé ces contacts 
    Route::get('/infusionsoft/readycontact', 'Api\ApplicationController@readycontact') ; 
    Route::get('/infusionsoft/fetchContact', 'Api\InfusionsoftController@fetchContact') ; 
    
});
