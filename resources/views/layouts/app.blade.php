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
            
            @if( isset($permissions) )        
            document.permissions = JSON.parse("{{json_encode($permissions)}}".replace(/&quot;/g,'"')) ; 
            @endif ;
            
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

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>


        <script>
            window.Pages = [
                { name: 'Home', path : '/', component : null },
                { name: 'Application', path : '/application', component : null },
                { name: 'Syncronisation', path : '/syncronisation', component : null },
                { name: 'User', path : '/user', component : null },
                { name: 'Permission', path : '/permission', component : null },
                { name: 'Role', path : '/role', component : null },
            ]
        </script>


    </head>
    <body>
        @yield('content')
        <!--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        -->
        <script src="{{ asset('js/index.js') }}"></script>

    </body>
</html>