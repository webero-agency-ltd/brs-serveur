<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationUpdateRequest extends FormRequest
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
        $data['name'] = 'Sometimes|string|max:255' ; 
        $all = $this->all() ; 
        if( isset($all['auth']) && $all['auth'] == 'accessToken' && $all['type']!=='infusionsoft' ){
            $data['accessToken'] = 'Sometimes|string|max:255' ; 
            $data['url'] = 'Sometimes|string|max:255' ; 
        }else if($all['type']!=='infusionsoft'){
            $data['login'] = 'Sometimes|string|max:255' ; 
            $data['password'] = 'Sometimes|string|max:255' ; 
        }
        return $data ;
    }
}
