@extends('layouts.default')

	@section('content')
	
	{{strtolower(Auth::user()->login)}}
	@endsection