@extends('layouts.default')

@section('home')
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

{{Auth::user()}}
<br>{{' index page'}}

<div class="row" style="width: 40%;">
    <div class="col">
      <input type="text" class="form-control" placeholder="First name">
       <input type="text" class="form-control" placeholder="First name">
    </div>
</div>

@endsection
<!-- /CONTENT -->
