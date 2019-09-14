<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Infusionsoft;

class InfusionsoftController extends Controller
{
    public function fetchContact( Request $request )
    {
        $infusionsoft = \App\Application::where('type','infusionsoft')->first() ;
        if( !$infusionsoft ){
            return response()->json(
                []
            );    
        }
        return response()->json(
            Infusionsoft::fetchContact( $infusionsoft->accessToken )
        );
    }
}
