@extends('layouts.default')

@section('home')
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

{{Auth::user()}}
@endsection
<!-- /CONTENT -->
