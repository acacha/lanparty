<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ logged_user() }}">

    <meta property="og:title" content="LAN PARTY Institut de l'Ebre" />
    <meta property="subtitle" content="La LAN Party de les Terres de l'Ebre" />
    <meta property="og:url" content="https://registre.lanparty.iesebre.com" />
    <meta property="og:image" content="https://registre.lanparty.iesebre.com/img/logo512x512.png" />
    <meta property="og:sitename" content="registre.lanparty.iesebre.com" />
    <meta property="og:url" content="https://registre.lanparty.iesebre.com" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@Institut_Ebre" />
    <meta name="twitter:creator" content="@Institut_Ebre" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="manifest" href="/manifest.json">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify@1.0.0-beta.6/dist/vuetify.min.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<div id="app">
    <landing-page
            action="{{ $action ?? null }}"
            :registrations-enabled="{{ json_encode($registrations_enabled) }}"
            reset-password-token="{{ $token ?? null }}"
            reset-password-email="{{ $email ?? null }}">
    </landing-page>
</div>
@stack('beforeScripts')
<script src="{{ mix('js/app.js') }}"></script>
@stack('afterScripts')
<script>
  function myMap() {
    var mapCanvas = document.getElementById("googleMap");
    var myCenter = new google.maps.LatLng(40.814757,0.515273);
    var mapOptions = {center: myCenter, zoom: 17};
    var map = new google.maps.Map(mapCanvas,mapOptions);
    var marker = new google.maps.Marker({
      position: myCenter,
    });
    var infowindow = new google.maps.InfoWindow({
      content:"<h1>Institut de L'Ebre</h1>" +
      "<ul><li>Av. de Cristòfol Colom, 34-42</li>" +
      "<li>43500 Tortosa</li>" +
      "<li>Tarragona</li>" +
      "<li>Espanya</li></ul><a href=\"https://goo.gl/maps/rFCVoZJ1VCo\">Mostra a Google Maps</a>"
    });
    var open = false
    google.maps.event.addListener(marker,'click',function() {
      if (open) {
        infowindow.close()
        open = false
      } else {
        infowindow.open(map, marker)
        open = true
      }
    });
    marker.setMap(map);
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqFb5smTuq0qs5PTGv3NLy5Q9A6Wkmxhk&callback=myMap"></script>
</body>
</html>
