<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//@todo : Récupération de la liste de link dans les menus
use App\Menu;
use Illuminate\Support\Facades\App;

if (!App::runningInConsole()) {
    $menu = Menu::all()->map->link->filter(function ($value, $key) {
        return $value;
    })->values()->toArray(); 

    Route::get('/{name?}', 'PageController@home')
        ->where('name','('.implode ('|' , $menu ).')')
        ->name('home');
}

Auth::routes();

//redirection apres auth IFS 
Route::get('/application/ifusionsoft', 'PageController@ifusionsoft');

//ajoute de route 404