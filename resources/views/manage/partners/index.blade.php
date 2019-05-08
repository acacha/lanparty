@extends('layouts.app')

@section('content')
  <v-container fluid>
    <v-layout>
      <v-flex>
        <partners-manage :partners="{{ $partners }}"></partners-manage>
      </v-flex>
    </v-layout>
  </v-container>
@endsection
