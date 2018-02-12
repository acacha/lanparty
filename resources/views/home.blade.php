@extends('layouts.app')

@section('content')
    <v-container fluid grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12 md8>
                <events :events="{{ $events }}"></events>
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
