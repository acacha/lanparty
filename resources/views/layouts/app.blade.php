<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ formatted_logged_user() }}">
    <meta name="lanparty" content="{{ lanparty_config_to_json() }}">
    <link rel="manifest" href="/manifest.json">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify@1.0.0-beta.6/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-corner-indicator.min.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
   <v-app id="app" v-cloak>
       <snackbar></snackbar>
       <main-navigation-drawer v-model="drawer"></main-navigation-drawer>
       <main-toolbar title="{{ config('app.shortname', 'Laravel') }}"
                     @toggleleft="drawer=!drawer"
                     @toggleright="drawerRight=!drawerRight"
       ></main-toolbar>

       <user-info-drawer :drawer="drawerRight"></user-info-drawer>

        <v-content>
            @yield('content')
        </v-content>
    </v-app>
    @stack('beforeScripts')
        <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    @stack('afterScripts')
</body>
</html>
