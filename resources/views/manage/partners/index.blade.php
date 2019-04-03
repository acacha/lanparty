@extends('layouts.app')

@section('content')
    <partners-manage :partners="{{ $partners }}"></partners-manage>
@endsection
