<?php

namespace App\Libs\vosfacture;

use Infusionsoft\Http\ArrayLogger;
use Illuminate\Session\Middleware\StartSession;
use App\Libs\Facades\Option;
use Infusionsoft\Http\GuzzleHttpClient;

class Vosfacture
{

    protected $httpClient ;

    protected $httpLogAdapter;

    protected $tokenUri = 'https://ahheldino.vosfactures.fr';

    function __construct()
    {
    
    }

    public function getHttpLogAdapter()
    {
        // If a log adapter hasn't been set, we default to the null adapter
        if ( ! $this->httpLogAdapter) {
            $this->httpLogAdapter = new ArrayLogger();
        }

        return $this->httpLogAdapter;
    }


    public function setHttpLogAdapter(LoggerInterface $httpLogAdapter)
    {
        $this->httpLogAdapter = $httpLogAdapter;

        return $this;
    }
    

    //récupération 
    public function getHttpClient()
    {
        if ( ! $this->httpClient) {
            return new GuzzleHttpClient(false, $this->getHttpLogAdapter());
        }

        return $this->httpClient;
    }

    //récupération de 
    public function auth( $login , $password )
    {

        $params = array(
            "login"=> $login ,
            "password"=> $password 
        );

        
        $client = $this->getHttpClient();

        try {

            $tokenInfo = $client->request('POST',$this->tokenUri.'/login.json', [
                'body'    => json_encode($params),
                'headers' => ['Accept' => 'application/json','Content-Type' => 'application/json']
                //'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
            ]); 

            return json_decode($tokenInfo, true) ; 

        } catch (\Exception $e) {
            if( $e->getCode() == 400 || $e->getCode() == 401 )
                return 'vosfacture auth error' ; 
            return 'general error' ;
        } 

    }
    
    public function findAuth( array $data )
    {
        $auth = $this->auth( $data['login'] , $data['password'] ); 
        if( isset($auth['api_token']) ){
            return array( 'accessToken' => $auth['api_token'] , 'url' => $auth['url'] ) ; 
        }
        return $auth ; 
    }

    //récupération de l'IF i
    public function findAuthToken( array $data )
    {

        $client = $this->getHttpClient();

        try {

            $tokenInfo = $client->request('GET', $data['url'].'/account.json?api_token='.$data['accessToken'], [
                'headers' => ['Accept' => 'application/json','Content-Type' => 'application/json']
                //'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
            ]); 

            return json_decode($tokenInfo, true) ; 

        } catch (\Exception $e) {
            if( $e->getCode() == 400 || $e->getCode() == 401 )
                return 'vosfacture auth error' ; 
            return 'general error' ;
        } 

    }

}

