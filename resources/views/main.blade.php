@extends('layouts.app')

@section('content')
    <v-container fluid grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12 md8>
                <v-card>
                    <v-card-title class="blue darken-3 white--text"><h2>Events</h2></v-card-title>
                    <v-card-text class="px-0 mb-2">
                        <v-list subheader>
                            @foreach($events as $event)
                                <v-list-tile avatar @click="">
                                    <v-list-tile-avatar :tile="true">
                                        <img src="http://via.placeholder.com/50x50">
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ $event->name }}</v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-icon>chat_bubble</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                            @endforeach
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 md4>
                <v-card>
                    <v-card-title class="blue darken-3 white--text"><h2>Números del sorteig</h2></v-card-title>
                    <v-card-text class="px-0 mb-2">
                        <v-list subheader>
                            @foreach($user->numbers as $number)
                                <li> {{ $number->value }} | {{ $number->type }}</li>
                            @endforeach
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>


@endsection
