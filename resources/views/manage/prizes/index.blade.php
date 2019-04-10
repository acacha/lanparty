@extends('layouts.app')

@section('content')
<prizes-manage :prizes="{{ $prizes }}"></prizes-manage>
@endsection
