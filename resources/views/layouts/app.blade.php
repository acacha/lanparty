<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ formatted_logged_user() }}">
    <link rel="manifest" href="/manifest.json">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify@1.0.0-beta.6/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-corner-indicator.min.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
   <v-app id="app" v-cloak>
       <v-snackbar
               :timeout="6000"
               :color="snackbarColor"
               v-model="snackbar"
               :multi-line="true"
       >
           @{{ snackbarText }}<br/>
           @{{ snackbarSubtext }}
           <v-btn dark flat @click.native="snackbar = false">Tancar</v-btn>
       </v-snackbar>
       <main-navigation-drawer v-model="drawer"></main-navigation-drawer>
       <main-toolbar title="{{ config('app.shortname', 'Laravel') }}"
                     @toggleleft="drawer=!drawer"
                     @toggleright="drawerRight=!drawerRight"
       ></main-toolbar>

       <v-navigation-drawer
               fixed
               v-model="drawerRight"
               right
               clipped
               app
       >
           <v-card>
               <v-container fluid grid-list-md class="grey lighten-4">
                   <v-layout row wrap>
                       <v-flex xs12>
                           <gravatar :user="{{ $user }}" size="100px"></gravatar>
                       </v-flex>
                       <v-flex xs12>
                           <h3>@{{ user.name }}</h3>
                           <a href="https://en.gravatar.com/connect/">Canvia el teu avatar a Gravatar</a>
                       </v-flex>
                   </v-layout>
               </v-container>
               <v-card-text class="px-0 grey lighten-3">
                   <v-form class="pl-3 pr-1 ma-0">
                       <v-text-field :readonly="!editingUser"
                                     label="Email"
                                     :value="user.email"
                                     ref="email"
                                     @input="updateEmail"
                       ></v-text-field>
                       <v-text-field :readonly="!editingUser"
                                     label="Nom usuari"
                                     :value="user.name"
                                     @input="updateName"
                       ></v-text-field>
                       <v-text-field :readonly="!editingUser"
                                     label="Nom"
                                     :value="user.givenName"
                                     @input="updateGivenName"
                       ></v-text-field>
                       <v-text-field :readonly="!editingUser"
                                     label="1r Cognom"
                                     :value="user.sn1"
                                     @input="updateSn1"
                       ></v-text-field>
                       <v-text-field :readonly="!editingUser"
                                     label="2n Cognom"
                                     :value="user.sn2"
                                     @input="updateSn2"
                       ></v-text-field>
                       <v-text-field readonly
                                     label="Created at"
                                     value="{{ $user->formatted_created_at_date }}"
                                     readonly
                       ></v-text-field>
                   </v-form>
               </v-card-text>
               <v-card-actions>
                   <v-spacer></v-spacer>
                   <v-btn :loading="updatingUser" flat color="green" @click="updateUser" v-if="editingUser">
                       <v-icon right dark>save</v-icon>
                       Guardar
                   </v-btn>
                   <v-btn flat color="orange" @click="editUser()" v-else>
                       <v-icon right dark>edit</v-icon>
                       Editar
                   </v-btn>
                   <v-btn :loading="logoutLoading" @click="logout" flat color="orange">
                       <v-icon right dark>exit_to_app</v-icon>
                       Sortir</v-btn>
                   <v-spacer></v-spacer>
               </v-card-actions>
               <v-card-actions>
                   <v-spacer></v-spacer>
                    <v-btn :loading="changingPassword" flat color="red" @click="changePassword">Canviar Paraula de pas</v-btn>
                   <v-spacer></v-spacer>
               </v-card-actions>
               <v-card-actions>
                   <v-spacer></v-spacer>
                    <a href="https://en.gravatar.com/connect/">Canvia el teu avatar a Gravatar</a>
                   <v-spacer></v-spacer>
               </v-card-actions>
           </v-card>
       </v-navigation-drawer>
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
