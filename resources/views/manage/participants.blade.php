@extends('layouts.app')

@section('content')
    @if(Session::has('status'))
        <participants-manage
                :users="{{ $users }}"
                :events="{{ $events }}"
                :numbers="{{ $numbers }}"
                :status="{{ Session::get('status')}}"></participants-manage>
    @else
        <participants-manage
                :users="{{ $users }}"
                :events="{{ $events }}"
                :numbers="{{ $numbers }}"
        ></participants-manage>
    @endif
@endsection
