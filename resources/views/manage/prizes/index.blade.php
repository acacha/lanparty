@extends('layouts.app')

@section('content')
    <prizes-manage :prizes="{{ $prizes }}" uri="{{ $uri }}"></prizes-manage>
@endsection
