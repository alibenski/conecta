<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=2.2">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        

    </head>


    <body class="font-sans antialiased">
        @include('layouts.navigation')

        {{ $slot }}



        <script>
        function skill(i) {


            var skilllist = [];


            $.getJSON("<?php echo config('app.url'); ?>/api/childskill", function(data){
                for (var i = 0, len = data.length; i < len; i++) {
                    childskill = data[i];
                    skilllist.push({'name':childskill.skillname,'id':childskill.id});
                    console.log(childskill.skillname);
                }
            });
        }
        </script>
        
        <script src="{{ asset('js/bootstrap.bundle.js') }}" defer></script>
    </body>
</html>
