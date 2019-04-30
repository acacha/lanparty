
@extends('layouts.app')

@section('content')
        <v-container fluid grid-list-md text-xs-center>
            <v-layout row wrap>
                <v-flex ctf>
                      <ctf :groups="{{  json_encode($groups) }}" ></ctf>
                      <ctf-submit :mostrar="{{json_encode($registratCTF)}}"></ctf-submit>
                </v-flex>
                <v-flex>
                    <user-numbers></user-numbers>
                </v-flex>
            </v-layout>
        </v-container>
@endsection
