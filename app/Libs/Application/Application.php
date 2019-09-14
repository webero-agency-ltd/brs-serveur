<?php

namespace App\Libs\Application;

use Illuminate\Auth\AuthManager;
use App\Team;
use App\Libs\Infusionsoft;
use App\Libs\Option;
use App\Libs\Trello;
use App\Libs\Vosfacture ;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Application
{

    public function __construct()
    {
  
    }

    /**
     * Création d'application ( Trello on Infusionsft )
     *  */
    public function store( array $data )
    {
        //si on se trouve dans un élément vos facture, alors on crée d'abord l'app
        //puis 
        if( $data["type"] == "vosfacture" && $data["auth"] == 'auth' ){
            $auth = Vosfacture::findAuth( $data ) ; 
            if( isset($auth['accessToken']) ){
                $data = array_merge( $data , $auth );
            }else{
                $errors = array(); 
                $message = $auth ; 
                return compact('errors','message') ;
            }
        }else if( $data["type"] == "vosfacture" && $data["auth"] == 'accessToken' ){
            $auth = Vosfacture::findAuthToken( $data ) ; 
            if( isset($auth['prefix']) ){
                
            }else{
                $errors = array(); 
                $message = $auth ; 
                return compact('errors','message') ;
            }
        }
        else if( $data["type"] == "infusionsoft" ){
            //création de l'application et retourne l'URL de l'authentification 
            $redirect = Infusionsoft::makeAuthUrl() ; 
        }
        
        //enregistrement de l'applications
        $app = \App\Application::create( $data ) ; 
        if( $app ){
            $response = [ 'data' => $app , 'message' => 'application create success' ] ; 
            if( isset( $redirect ) ){
                $response['redirect'] = $redirect ; 
            }
            return $response ; 
        }       

        $errors = array(); 
        $message = 'general error'; 
        return compact('errors','message') ;
        
    }


    public function index( $data )
    {
        //récupération de l'ancien ID
        $q = \App\Application::where( $data ) ; 
        //enregistrement de la nouvelle valeur 
        return $q->get() ; 

    }


    public function show( $id , array $data )
    {
        if( !is_numeric ($id) )
            return \App\Application::where( $data )->first() ; 
        else 
            return \App\Application::where( 'id' , $id )->first() ; 
    
    }

    public function update( $id , array $data )
    {

        if( $data["type"] == "vosfacture" && $data["auth"] == 'auth' ){
            $auth = Vosfacture::findAuth( $data ) ; 
            if( isset($auth['accessToken']) ){
                $data = array_merge( $data , $auth );
            }else{
                $errors = array(); 
                $message = $auth ; 
                return compact('errors','message') ;
            }
        }else if( $data["type"] == "vosfacture" && $data["auth"] == 'accessToken' ){
            $auth = Vosfacture::findAuthToken( $data ) ; 
            if( isset($auth['prefix']) ){
                
            }else{
                $errors = array(); 
                $message = $auth ; 
                return compact('errors','message') ;
            }
        }
        
        //récupération de l'ancien ID
        $app = \App\Application::where( 'id' , $id )->first() ;  
        $app->update($data) ; 
        $app->save() ;

        return [ 'data' => $app , 'message' => 'application update success' ] ;             

    }


    //mise a jour de seuelement l'access Token d'infusionsoft
    public function updateIFS( array $data )
    {
        //récupération de l'ancien ID
        $app = \App\Application::where( 'type' , 'infusionsoft' )->first() ;  
        $app->update($data) ; 
        return $app->save() ;
    }

    //apres redirection infusionsoft 
    public function ifusionsoft( $info )
    {
        $code = Infusionsoft::findAccessToken( $info['code'] )  ; 
        $app = \App\Application::where( 'type' , 'infusionsoft' )->first() ;
        if( $app ){
            $app->accessToken = $code ; 
            $app->url = $info['url'] ; 
            $app->save() ; 
            echo "<script>window.close();</script>";
            return ;
        }
        return "ERREUR IFS AUTHENTICATE" ; 
    }

    public function readycontact()
    {
        $app = \App\Application::where('type','infusionsoft')->first() ; 
        $precached = Cache::get( "contact_infusionsoft", collect( [] )) ;
        //@todo: check s'il y a de nouveaux contact dans la partie IFS 
        $option = Option::find( "fetchcontact" ) ; 
        if( count( $precached ) == 0 || ($option&&$option->value['percenty'] < 100) )
            return array( 'ready'=> false ) ; 
        return array( 'ready'=>true , 'contact'=>count( $precached ) ) ; 
    }
    
    
}
