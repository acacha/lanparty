@extends('layouts.app')

@section('content')
    <managers-manage :managers="{{ $managers }}" :users="{{ $users }}"></managers-manage>
@endsection
