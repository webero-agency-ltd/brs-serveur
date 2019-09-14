<?php

namespace App\Libs\src\message;

use App\Events\newMessage;
use Illuminate\Auth\AuthManager;
use \App\Libs\Facades\Bot ; 
use \App\Libs\Facades\Credit ;
use Illuminate\Support\Carbon;

class Message
{
    public $auth ; 
    public $message ; 
    public $bot ; 
    public $credit ; 
    
    public function __construct( AuthManager $auth , \App\Message $message , Bot $bot, Credit $credit )
    {
        $this->auth = $auth ;     
        $this->message = $message ;     
        $this->bot = $bot ;     
        $this->credit = $credit ;     
    } 

    public function query()
    {
        return $this->message->newQuery() ; 
    }
    
    /**
     * Récupération des messages d'un utilisateur en question 
     */
    public function index( $bot )
    {
        $bot = $this->bot::find( $bot ) ; 
        if( !$bot )
            return null ; 
        $me = $this->bot::me() ; 
        //@todo:voire si vous avez le droit d'access a l'utilisateur en questions 
        $q = $this->query()
        ->select('content','id','created_at','from_id','to_id')
        ->whereRaw("( ( from_id = {$bot->id} AND to_id = $me->id ) OR ( from_id = $me->id AND to_id = {$bot->id} ) )" )
        ->orderBy('id', 'DESC') ; 
        $this->readAll( $me->id , $bot->id ) ;
        return $q ;
    }

    /*
     * récupération des message d'un utilisatreur connecter
     * */
    public function getMessages( Bot $from , Bot $to ){
        $megs = $this->queryFindMsg( $from , $to ) ;
        return $megs ;
    }

    //récupération des messages pas encore lu et qui est destiner a l'utilisateur qui a le bit en question
    public function unread( \App\Bot $form ){
        $megs = $this->query()
            ->where('to_id',$form->id)
            ->groupBy('from_id' )
            ->selectRaw('from_id , COUNT(id) as count' )
            ->whereRaw('read_at IS NULL' )
            ->get()
            ->pluck('count','from_id') ;
        return $megs ;
    }

    /*
     * Marque tout comme lue
     * */
    private function readAll( $me , $from ){
        //@todo : seuelement si le message ma été destiner 
        $all = $this->query()
            ->where(array( 'to_id'=>$me ,'from_id'=>$from ,'read_at'=>null ))
            ->get() ;
        $all->each(function ( $item ) {
            $item->read_at = Carbon::now() ;
            $item->save() ;
        });
    }

    /**
     * Création de message
     */
    public function create( $content , $to )
    {

        $user = $this->auth->user() ;
        $from = $this->bot::me() ;
        $to = $this->bot::find( $to ) ;

        if( $user->role == "client" ){
            //on check si l'utilisateur a encore le droit d'envoier de crédi
            if ( !$this->credit::hasCredit() )
                //@lang : :langue de lany crédi 
                return array('error' , array('message'=>'lany ny credinao') )  ;
        }

        $msg = [
            'content' => $content,
            'from_id' => $from->id,
            'to_id' => $to->id,
            'islast' => 1 ,
        ];

        if ( $user->role == "client" ){
            $op = $this->bot::query()->where(array( 'id' => $to->id , 'faker' => true ))->where('user_id','!=',null)->first() ; 
            if ( $op ){
                $msg['operateur_id'] = $op->user_id ;
            }
        }else{
            $msg['operateur_id'] = $user->id ;
        }
            
        $userTo = $to->load('user')->user()->first() ; 
        //on selectionne le lisate message d'abord pour la conversation et on update 
        $this->query()
            ->whereRaw("( ( from_id = {$from->id} AND to_id = $to->id ) OR ( from_id = $to->id AND to_id = {$from->id} ) )" )
            ->update([ 'islast' => false ]) ;  

        $newmsg = $this->query()->create( $msg ) ;
        event(  new newMessage( $newmsg , $userTo , $user->role == "operateur" ? "operateur" : "client" ) ) ;
        return $newmsg ;

    }

}
