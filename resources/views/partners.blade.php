@extends('layouts.app')

@section('content')
<v-app>
    <partners :partners="{{ $partners }}"></partners>
</v-app>
@endsection
