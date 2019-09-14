<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStoreRequest extends FormRequest
{
    
    public function authorize()
    {
        return true ;
    }

    public function expectsJson()
    {
        return true;
    }
    
    public function rules()
    {
        $data = [] ; 
        $data['name'] = 'required|string|max:255' ; 
        $all = $this->all() ;

        if( isset($all['auth']) && $all['auth'] == 'accessToken' && $all['type']!=='infusionsoft' ){
            $data['accessToken'] = 'required|string|max:255' ; 
            $data['url'] = 'required|string|max:255' ; 
        }else if($all['type']!=='infusionsoft'){
            $data['login'] = 'required|string|max:255' ; 
            $data['password'] = 'required|string|max:255' ; 
        }
        return $data ;
    }
}
