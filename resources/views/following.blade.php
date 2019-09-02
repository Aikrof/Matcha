@extends('layouts.default')

@section('following')
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

@foreach($data as $val)
{{$val['location']['country']}}
@endforeach

@endsection
<!-- /CONTENT -->