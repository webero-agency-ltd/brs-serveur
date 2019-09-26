<?php

namespace App\Http\Controllers;

use App\Libs\Application;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    //page home controller 
    public function home()
    {
        if( Auth::check()){ 
            $user = Auth::user() ;
            $menus = Cache::get( "menu_".$user->id ) ; 
            $permission = $user->getPermissions()->toArray() ; 
            if( !$menus ){
                //récupération de la listes des menus 
                //récupération des permitions de ces roles
                $menus = Menu::all() ; 
                $menus = $menus->filter(function ($value, $key) use( $permission ) {
                    if( $value->permition == "*" )
                        return true ;
                    $all = explode( "|" , $value->permition ) ; 
                    foreach( $permission as $item ){
                        if( in_array( $item["slug"] , $all ) )
                            return true ;
                    }
                    return false ;
                })->values();
                $formates = array() ; 
                $menus = $menus->toArray() ; 
                $childs = array() ; 
                foreach( $menus as $menu ){
                    $menu['childs'] = array() ; 
                    if( $menu['parent'] )
                        $childs[] = $menu ;
                    else
                        $formates[] = $menu ;  
                }
                foreach( $childs as $child ){
                    foreach( $formates as &$menu ){
                        if( $menu['id'] == $child['parent'] ){
                            $menu['childs'][] = $child ; 
                        }  
                    }
                }
                $menus = $formates ; 
                Cache::forever( "menu_".$user->id , $menus ) ;
            }
            
            //envoyer aussi l'autorisation de l'utilisateur courant 
            return view('application',[ 'menus' => $menus , 'permissions' => $permission ]);    
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
