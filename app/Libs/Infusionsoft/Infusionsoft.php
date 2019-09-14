<?php

namespace App\Libs\infusionsoft;

use App\Libs\Option;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use App\Libs\Application;

class Infusionsoft

{

    private $infusionsoft ; 

    function __construct()
    {
        $this->infusionsoft = null ;   
    }

    public function getInfusionsoft( $accessToken = null )
    {
        if ( $this->infusionsoft )
            return $this->infusionsoft ; 
        
        $this->infusionsoft = new \Infusionsoft\Infusionsoft(array(
            'clientId'     => env( 'INFUSIONSOFT_KEY' ),
            'clientSecret' => env( 'INFUSIONSOFT_SECRET' ),
            'redirectUri'  => env( 'APP_URL' ) . '/application/ifusionsoft' ,
        ));

        if ( $accessToken ){

            $this->infusionsoft->setToken( $accessToken );
            $now = Carbon::now() ;
            $date = Carbon::parse( $accessToken->endOfLife ) ;

            if( $now > $date ){
                $t = $this->infusionsoft->refreshAccessToken();
                Application::updateIFS( array( 'accessToken' => $t ) ) ; 
            }
            //on update le plugin ici         
        }
        return $this->infusionsoft ; 
    }

    public function makeAuthUrl()
    {
        $infusionsoft = $this->getInfusionsoft() ;
        $infusionsoft->getToken() ;
        return $infusionsoft->getAuthorizationUrl() ;
    }

    public function findAccessToken( string $code )
    {
        $infusionsoft = $this->getInfusionsoft() ;
        return $infusionsoft->requestAccessToken( $code ) ; 
    }

    /**
     *  Récupération des ID de l'utilisateur qui a crée le token 
     *  Dans le compte infusionsoft a crée 
     *  */
    public function userAuth( int $id , $accessToken )
    {
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $users = $this->users( $id , $accessToken ) ; 
        $auth = $infusionsoft->userinfo()->get() ; 

        foreach( $users as $user){
            if( $user['global_user_id'] == $auth['global_user_id'] ){
                return $user ; 
            }
        }

        return null ; 
    }

    /**
     * Récupération de la liste de l'intégralité de l'utilisateur ICI 
     * les membres de l'équipe dans IFS 
     */
    public function users( int $id , $accessToken )
    {
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $user = $infusionsoft->restfulRequest('GET',$infusionsoft->getBaseUrl().'/rest/v1/users') ;
        if( isset($user['users']) )
            return $user['users'] ; 
        return [] ;
    }


    public function contacts( int $id , $query = array() )
    {
        $page = 1 ; 
        if( isset($query['page']) ){
            $page = (int) $query['page'] ; 
        }

        $search = "" ; 
        if( isset($query['search']) ){
            $search = $query['search'] ; 
        }
                
        $precached = Cache::get( "contact${id}" , collect( [] )) ; 
        $limit = 10 ; 
        $show = ( $page - 1 ) * $limit ; 

        $filterd = $precached->filter(function ($value, $key) use( $search ) {
            if( $search == "" )
                return true ;
            return ( ( strpos( $value['full_name'] , $search ) !== false ) || ( strpos( $value['emailText'] , $search ) !== false ) ) ? true : false ; 
        });

        $count = $filterd->count(); 

        $responce = $filterd->slice( $show , $limit )->values();

        return array('data' => $responce , 'total' => $count , 'search' => $search , 'maxpage' => ceil ( ( $count / $limit ) )  ) ;
    
    }

    public function fetchContact( $accessToken )
    {
        ini_set('max_execution_time', 180);
        
        $infusionsoft = $this->getInfusionsoft( $accessToken ) ;
        $offset = 0 ; 
        $option = Option::find( "fetchcontact") ; 
        $limit = 1000 ; 
        $precached = Cache::get( "contact_infusionsoft" , collect( [] )) ; 
        if( $option ){
            $offset = $option->value['offset'] + $limit ; 
            $count = $option->value['total']  ; 
            if( $offset > $count && count( $precached )!=0 )
                return array('success'=>true) ; 
            if( count( $precached )==0 )
                $offset = 0 ; 
        }else{
            $count = $infusionsoft->contacts()->count() ; 
        }

        $contact = $infusionsoft->contacts()->where('limit', $limit )->where('offset', $offset )->get();
  
        $percent = ($offset+$limit)/$count;
        $nemb = number_format( $percent * 100, 1 ) ; 
        $percent_friendly = $nemb>100?100:$nemb;

        $collection = collect($contact)->map(function ($item, $key) {
            $email = collect( $item['email_addresses'] )->map->email->values() ; 
            $emailText = $email->implode(' '); 
            $given_name = $item['given_name'] ; 
            $family_name = $item['family_name'] ; 
            $full_name = $family_name. ' ' .$given_name  ; 
            $id = $item['id'] ; 
            return compact('email','given_name','family_name','id','full_name','emailText');
        })->values() ;

        Cache::forever( "contact_infusionsoft" , $collection->concat( $precached ) ) ; 

        return Option::create( "fetchcontact" , array( "total" => $count , "offset" => $offset , "percenty" => $percent_friendly ) , null ) ;

    }

    
    /**
     * Récupération des notes 
     */
    public function notes(int $id , int $note , $accessToken  )
    {
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $noteNative = $infusionsoft->notes()->find( $note ) ; 
        return $noteNative ;  
    }

     /**
      * Récupération des taches 
      */
    public function tasks( int $id , int $task , $accessToken )
    {
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $taskNative = $infusionsoft->tasks()->find( $task ) ; 
        return $taskNative ;  
    }

    /**
     * Récupération des notes 
     */
    public function note(int $id , int $note , $accessToken  )
    {
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $noteNative = $infusionsoft->notes()->find( $note ) ; 
        return $noteNative ;  
    }

     /**
      * Récupération des taches 
      */
    public function task( int $id , int $task , $accessToken , $query )
    {
        ini_set('max_execution_time', 360 );
        
        //récupération des membres de l'équipe
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $taskNative = null ; 
        
        try {
            $taskNative = $infusionsoft->tasks()->find( $task ) ;//find( $task ) 
        } catch (\Exception $e) {} 
            
        if( $taskNative && $taskNative->id )
            return $taskNative ;
        
        $users = $this->users(  $id , $accessToken ) ; 
        $count = 0 ; 
        do{
            //@todo: voire si l'utilisateur a plus de 1000 tache attacher a son compte
            $temps = $infusionsoft->tasks()->where( 'user_id' , $users[$count]["id"] )->get() ; 
            $col = collect( $temps ) ; 
            $col = $col->filter(function ($value, $key) use( $task ) {
                return $value['id'] == $task ? true : false ; 
            })->values()->toArray();
            if( \count( $col ) ){
                $taskNative = $col[0] ; 
                break ; 
            }
            $count++ ; 
            if( $count >= \count( $users ) ){
                break ; 
            }
        }while( 1 ) ; 
        
        return $taskNative ; 
            
    }


    public function readycontact()
    {
        $apps = Application::index() ; 
        //récupération de infusionsoft 
        $apps = collect( $apps['data'] )  
            ->filter(function ($value, $key) {
                return $value["application"]["type"] == "infusionsoft" ;
            })
            ->values()
            ->toArray() ;

        $ids = [] ; 

        foreach ( $apps as $app ){
            $precached = Cache::get( "contact".$app['application']['id'] , collect( [] )) ; 
            $option = Option::find( "fetchcontact" ) ; 
            if( count( $precached ) == 0 || ($option&&$option->value['percenty'] < 100) )
                $ids[] = $app["application"]['id'] ; 
            
        }
        return $ids ; 
    }
    
    /**
     * Création de NOTE
     */
    public function taskCreate(int $id , $accessToken , $task )
    {
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $newtask = $infusionsoft->tasks()->create( $task ) ; 
        return $newtask ;  
    }


     /**
      * Création de tache 
      */

    public function noteCreate(int $id , $accessToken , $note )
    {
        $infusionsoft = $this->getInfusionsoft( $id , $accessToken ) ;
        $newtask = $infusionsoft->notes()->create( $note ) ; 
        return $newtask ; 
    }


}
