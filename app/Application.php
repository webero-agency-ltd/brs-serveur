<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name', 'accessToken', 'url', 'type'
    ];

    public function setAccessTokenAttribute($value)
    {
        if($this->attributes['type']=='infusionsoft'){
            $this->attributes['accessToken'] = serialize($value);;
        }else{
            $this->attributes['accessToken'] = $value;
        }
    }

    public function getAccessTokenAttribute($value)
    {
        if($this->attributes['type']=='infusionsoft'){
            return unserialize($value);
        }else{
            return $value ; 
        }
    }
    
}
