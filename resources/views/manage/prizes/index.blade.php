@extends('layouts.app')

@section('content')
    <prizes-manage :prizes="{{ $prizes }}" uri="{{ $uri }}" :partners="{{$partners}}" :users="{{$users}}" ></prizes-manage>
@endsection
