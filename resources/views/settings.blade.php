@extends('layouts.default')

@section('settings')
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')
<div class="container-fluid">


<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header settings_header">

	<div class="row mr-rigtht-20">
		<div class="col-md-12">
			<p class="set_change_name">Change your login:</p>
			<p class="btn" id="set_change_login"><label>Change Login</label></p>
		</div>
	</div>
	<div class="row mr-rigtht-20">
		<div class="col-md-12">
			<p class="set_change_name">Change your password:</p>
			<p class="btn" id="set_change_passwd"><label>Change Password</label></p>
		</div>
	</div>
	<div class="row mr-rigtht-20">
		<div class="col-md-12">
			<p class="set_change_name">Change your email:</p>
			<p class="btn" id="set_change_email"><label>Change Email</label></p>
		</div>
	</div>

</div>
</div>
</div>
</div>


<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-body" style="display: flex;">

	<div class="row">
		<div class="col-md-12">
			<label>Add to Block list</label>
			<div style="display: flex; ">
				<input class="form-control" type="text" name="block" autocomplete="off">
				<p class="btn">Add</p>
			</div>
			
		</div>
	</div>

</div>
</div>
</div>
</div>

</div>
@endsection
<!-- /CONTENT -->

<!-- CONTENT SCRIPT -->
@section('script')
<script type="text/javascript" src="js/settings.js"></script>
@endsection
 <!-- /CONTENT SCRIPT -->