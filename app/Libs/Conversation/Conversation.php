<?php

namespace App\Libs\src\conversation;

use Illuminate\Auth\AuthManager;
use \App\Libs\Facades\Bot ; 
use \App\Libs\Facades\Message ; 

class Conversation
{
    public $auth ; 
    public $message ; 
    public $bot ; 
    
    public function __construct( AuthManager $auth , Message $message , Bot $bot )
    {
        $this->auth = $auth ;     
        $this->message = $message ;     
        $this->bot = $bot ;     
    }

    public function index( array $search = [] )
    {
        $user = $this->auth->user() ;
        $bot = $this->bot::me() ; 
        
        $unread = $this->message::unread( $bot ) ;
        //on selection d'abord tout les message en distinc sur la colun from_id or to_id
        $id = $bot->id ; 
        $qm = $this->message::query()
            ->whereRaw("( from_id = {$id} OR to_id = {$id} )" )
            ->where('islast' , 1 )
            ->orderBy('created_at', 'DESC')
            ->get();
        
        $arrayBots = array() ;
        $existe = array() ;
    
        if ( isset($search['existe']) ){
            $existe = $search['existe'] ; 
        } 
    
        foreach ($qm as $key => $value) {
            $inter = null ;
            $value->from_id == $id ? $inter = $value->to_id : $inter = $value->from_id ; 
            if (!in_array($inter, $existe)) {
                $arrayBots[] = $inter ; 
            }
        }

        
        $qbots = $this->bot::query()
            ->select('*')
            ->where('id' , '!=', $bot->id ) ;
            //->where('user_id' , $user->role == "client"?'=':'!=', NULL );
            
        if ( isset($search['search']) && $search['search'] !== '' ){
            $sr = $search['search'] ; 
            $qbots->whereRaw("psoeudo LIKE '%{$sr}%' ") ;
        }
    
        if ( $user->role == "client" ){ 
            $qbots->whereIn('id', $arrayBots) ;
        }else if ( $user->role == "operateur" ){
            //suprime cette ligne si pour un operateur peut envoyer un message le premier a un client
            $qbots->whereIn('id', $arrayBots) ;
        }
    
        $bots = $qbots->orderByRaw('FIELD (`id`,'.implode(',',$arrayBots).')')->limit( 4 )->get() ;

        $this->setUnread( $bots , $unread ) ;

        foreach( $bots as $ibot ){
            
            $item = $qm->filter(function ($value, $key) use( $ibot ) {
                return $value->to_id == $ibot->id || $value->from_id == $ibot->id ;
            })->values();
            if( isset( $item[0] ) ){
                $m = $item[0] ; 
                $ibot['lastMessage'] = $m->content ;
                $ibot['isMeLastPosted'] = $bot->id == $m->from_id ? true : false ;
            }
            
        }
        
        $res = [
            'data'  => $bots->toArray() ,
            'order' => array_merge( $existe , $arrayBots ) , 
            'count' =>  $qbots->count() ,
        ];
        return $res ;

    }
    

    public function setUnread( &$bots , $unread ){
        foreach ( $bots as $item ){
            if ( isset( $unread[ $item->id ] ) ){
                $item->unread = $unread[ $item->id ];
            }else{
                $item->unread = 0 ;
            }
        }
        return $bots  ;
    }


}
