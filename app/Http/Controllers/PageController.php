<?php

namespace App\Http\Controllers;

use App\Libs\Application;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //page home controller 
    public function home()
    {
        if( Auth::check()){ 
            //récupération de la listes des menus 
            $menus = Menu::all() ; 
            $user = Auth::user() ;
            //récupération des permitions de ces roles
            //envoyer aussi l'autorisation de l'utilisateur courant 
            return view('application',[ 'menus' => $menus , 'permissions' => $user->getPermissions()->toArray() ]);    
        }else    
            return view('welcome');    
    }

    //apres redirection infusionsoft 
    public function ifusionsoft( Request $request )
    {
        $code = $request->get('code') ; 
        $scope = explode( '|' , $request->get('scope') ); 
        $url = null ; 
        if( isset($scope[1]) ){
            $url = $scope[1]; 
        }
        $state = $request->get('state') ; 
        return Application::ifusionsoft( compact('code' , 'scope' , 'state' , 'url' ) ) ;
    }
    
}
