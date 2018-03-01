<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ logged_user() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <template>
        <v-app id="inspire">
            <v-content>
                <v-container fill-height>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-alert type="error" :value="true">
                                Oppps!!! No hem pogut trobar la pàgina!
                            </v-alert>
                        </v-flex>
                        <v-flex xs4 offset-xs2 align-center>
                            <img src="/img/404.jpg" alt="404 not found">
                        </v-flex>
                        <v-flex xs6 offset-xs5 align-center>
                            <v-btn outline color="primary" href="/home">Tornar a la pàgina principal</v-btn>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-container fluid fill-height>

                </v-container>

            </v-content>
        </v-app>
    </template>
</div>
@stack('beforeScripts')
<script src="{{ mix('js/app.js') }}"></script>
@stack('afterScripts')
</body>
</html>
