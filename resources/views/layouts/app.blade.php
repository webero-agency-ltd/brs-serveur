<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
        <title>{{ config('app.title', 'brs-serveur') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <script>

            @if( isset($menus) )        
            document.menus = JSON.parse("{{json_encode($menus)}}".replace(/&quot;/g,'"')) ; 
            @endif ;
            
            document.permissions = JSON.parse("{{json_encode($permissions)}}".replace(/&quot;/g,'"')) ; 
            document.csrf_token = "{{csrf_token()}}" ; 
            document.trans = JSON.parse("{{ json_encode(array_merge(trans('app'),trans('error'))) }}".replace(/&quot;/g,'"')) ; 

            
            window.htmlentities = {

                encode : function(str) {
                    var buf = [];
                    
                    for (var i=str.length-1;i>=0;i--) {
                        buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
                    }
                    
                    return buf.join('');
                },

                decode : function(str) {
                    return str.replace(/&#(\d+);/g, function(match, dec) {
                        return String.fromCharCode(dec);
                    });
                }

            };
            window.APP_URL = "{{ env( 'APP_URL' ) }}"

        </script>

    </head>
    <body>
        @yield('content')
        <script src="{{ asset('js/index.js') }}"></script>
    </body>
</html>