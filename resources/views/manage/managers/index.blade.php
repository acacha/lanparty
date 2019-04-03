@extends('layouts.app')

@section('content')
    <managers-manage :managers="{{ $managers }}"></managers-manage>
@endsection
