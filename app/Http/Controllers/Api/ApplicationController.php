<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;
use App\Libs\Application;

class ApplicationController extends Controller
{

    public function index(Request $request)
    {
        $all = $request->only('name', 'accessToken', 'url', 'type') ; 
        return response()->json(
            Application::index( $all )
        );
    }


    public function store(ApplicationStoreRequest $request)
    {
        $all = $request->all() ; 
        return response()->json(
            Application::store( $all )
        );
    }


    public function show( Request $request, $id )
    {
        $all = $request->only('name', 'accessToken', 'url', 'type') ; 
        return response()->json(
            Application::show( $id , $all )
        );
    }


    public function update(ApplicationUpdateRequest $request, $id)
    {
        $all = $request->all() ; 
        return response()->json(
            Application::update( $id , $all )
        );
    }


    public function destroy($id)
    {
        return response()->json(
            Application::destroy( $id , $id )
        );
    }

    //vérifier si l'application IFS n'a pas encores de contacts 
    public function readycontact()
    {
        return response()->json(
            Application::readycontact()
        );
    }

}
