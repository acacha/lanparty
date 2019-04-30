@extends('layouts.app')

@section('content')
    @if(Session::has('status'))
        <participants-manage
                :tickets="{{ $tickets }}"
                :users="{{ $users }}"
                :events="{{ $events }}"
                :numbers="{{ $numbers }}"
                :status="{{ Session::get('status')}}"></participants-manage>
    @else
        <participants-manage
                :tickets="{{ $tickets }}"
                :users="{{ $users }}"
                :events="{{ $events }}"
                :numbers="{{ $numbers }}"
        ></participants-manage>
    @endif
@endsection
