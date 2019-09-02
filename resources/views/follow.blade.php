@extends('layouts.default')

@section($section)
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

@foreach($data as $val)
{{$val['login']}}<br>
@endforeach

{{$paginate->render()}}
@endsection
<!-- /CONTENT -->