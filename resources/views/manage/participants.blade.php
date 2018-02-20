@extends('layouts.app')

@section('content')
    <v-container fluid grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card>
                    <v-card-title class="blue darken-3 white--text">
                        <h3>Usuaris</h3>
                    </v-card-title>
                    <v-card-text class="px-0 mb-2">
                        <users-search :users="{{$users}}"></users-search>
                        <manage-user></manage-user>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12>
                <v-card>
                    <v-card-title class="blue darken-3 white--text">
                        <h3>Números del sorteig</h3>
                    </v-card-title>
                    <v-card-text class="px-0 mb-2">
                        <numbers-search :numbers="{{$numbers}}"></numbers-search>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
@endsection

