@extends('layouts.app')

@section('content')
<v-app>
    <prizes :prizes="{{ $prizes }}"></prizes>
</v-app>
@endsection
