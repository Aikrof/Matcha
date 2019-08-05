@extends('layouts.default')

@section('home')
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

{{Auth::user()}}
<br>{{' index page'}}

<div class="dropdown open">
  <p class="btn btn-secondary dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sexual orientations</p>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="display: flex;flex-direction: column;">
  	<label>
  		<input style="display: none;" type="checkbox" name="sexual_prev" value="Heterosexual">
    	<span class="dropdown-item">Heterosexual</span>
    </label>
   <label>
  		<input style="display: none;" type="checkbox" name="sexual_prev" value="Bisexual">
    	<span class="dropdown-item">Bisexual</span>
	</label>
	<label>
  		<input style="display: none;" type="checkbox" name="sexual_prev" value="Homosexual">
    	<span class="dropdown-item">Homosexual</span>
	</label>
  </div>
</div>
@endsection
<!-- /CONTENT -->
