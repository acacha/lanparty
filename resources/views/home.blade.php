@extends('layouts.app')

@section('content')
    <v-container fluid grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-flex xs12 lg8>
                <events :events="{{ $events }}" :users="{{ $users }}"></events>
            </v-flex>
            <v-flex xs12 lg4>
                <user-numbers></user-numbers>
            </v-flex>
        </v-layout>
    </v-container>
@endsection
