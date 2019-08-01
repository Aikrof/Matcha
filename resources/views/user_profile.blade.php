<?php
	$curent_route = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$back = $_SERVER['HTTP_REFERER'] === $curent_route ? '/' : $_SERVER['HTTP_REFERER'];
?>

@extends('layouts.default')

@section('i')
	<div class="navigation-button second">
		<a href="{{$back}}"><p><i class="fa fa-close" aria-hidden="true"></i></p></a>
	</div>
@endsection

@section('content')
	
		
@endsection