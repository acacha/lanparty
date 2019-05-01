@extends('layouts.app')

@section('content')
        <v-container fluid grid-list-md text-xs-center>
            <v-layout row wrap>
                <v-flex ctf>
                    <ctf-group :group-name="{{ json_encode($groupname) }}" :flags="{{  $flags }}" ></ctf-group>
                </v-flex>
                <v-flex>
                    <user-numbers></user-numbers>
                </v-flex>
            </v-layout>
        </v-container>
@endsection
