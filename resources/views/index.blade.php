@extends('layouts.default')

@section('home')
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

{{Auth::user()}}
<br>{{' index page'}}

<div id="map" style="width:500px; height:400px"></div>
@endsection
<!-- /CONTENT -->
