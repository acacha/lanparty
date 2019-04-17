@extends('layouts.app')

@section('content')
    <events-manage :events="{{ $events }}"></events-manage>
@endsection
