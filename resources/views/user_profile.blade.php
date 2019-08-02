<?php
	$curent_route = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$back = $_SERVER['HTTP_REFERER'] === $curent_route ? '/' : $_SERVER['HTTP_REFERER'];
?>

@extends('layouts.default')

@section('i')
	<div class="navigation-button second">
		<div class="i"><a href="{{$back}}"><i class="fa fa-close"></i></a></div>
	</div>
@endsection

@section('content')
	
		
@endsection