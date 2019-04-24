@extends('layouts.app')

@section('content')
    <users-manage :users="{{ $users }}"></users-manage>
@endsection
