<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:title" content="LAN PARTY Institut de l'Ebre" />
    <meta property="subtitle" content="La LAN Party de les Terres de l'Ebre" />
    <meta property="og:url" content="https://registre.lanparty.iesebre.com" />
    <meta property="og:image" content="https://registre.lanparty.iesebre.com/img/logo512x512.png" />
    <meta property="og:sitename" content="registre.lanparty.iesebre.com" />
    <meta property="og:url" content="https://registre.lanparty.iesebre.com" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@Institut_Ebre" />
    <meta name="twitter:creator" content="@Institut_Ebre" />

    <title>Premis LAN Party Institut de l'Ebre</title>
    <link rel="manifest" href="/manifest.json">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify@1.0.0-beta.6/dist/vuetify.min.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<div id="app">
    <v-app>
        <prizes :prizes="{{ $prizes }}"></prizes>
    </v-app>
</div>
@stack('beforeScripts')
<script src="{{ mix('js/app.js') }}"></script>
@stack('afterScripts')
</body>
</html>