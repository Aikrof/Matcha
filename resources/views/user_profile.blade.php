@extends('layouts.default')

<!-- ACTIVE NAV-LINK -->
@section('user')
{{'active'}}
@endsection
<!-- /ACTIVE NAV-LINK -->

<!-- CONTENT -->
@section('content')

{{'user profile'}}
<div class="container-fluid">
<div class="row">
<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Profile</h4>
        </div>
        <div class="card-body">
        <form>
            <div class="row">
            	<div class="col-md-4 px-1">
                	<div class="form-group">
                		<label>Username</label>
                		<input type="text" class="form-control" placeholder="Username" disabled="" value="{{ucfirst(strtolower($data['user']['login']))}}">
                	</div>
            	</div>
            	<div class="col-md-8 pl-1">
                	<div class="form-group">
                    	<label for="exampleInputEmail1">Email address</label>
                    	<input type="email" class="form-control" placeholder="Email" disabled="" value="{{$data['user']['email']}}">
                	</div>
            	</div>
        	</div>
            <div class="row">
                <div class="col-md-6 pr-1">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="Company" value="{{$data['info']['first_name']}}">
                    </div>
                </div>
                <div class="col-md-6 pl-1">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" value="{{$data['info']['last_name']}}">
                	</div>
                </div>
            </div>
            <div class="row user_a_b">
                <div class="col-md-6 pr-1">
                    <div class="form-group">
                        <label>Gender</label>
                        <input type="text" class="form-control" placeholder="gender" disabled="" value="{{ $data['info']['gender']}}">
                    </div>
                </div>
                <div class="col-md-6 pr-1">
                    <div class="form-group">
                        <label>Orientation</label>
                        <input type="text" class="form-control" placeholder="orientation" value="{{$data['info']['orientation']}}">
                    </div>
                </div>
            </div>
            <div class="row user_a_b">
                <div class="col-md-4 pr-1">
                    <div class="form-group">
                        <label>Age</label>
                        <input type="text" class="form-control" placeholder="Age" value="{{($data['info']['age'] === 0) ? '' : $data['info']['age']}}">
                    </div>
                </div>
                <div class="col-md-8 pr-1">
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="text" class="form-control" placeholder="Birthday" value="{{$data['info']['birthday']}}">
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-4 pr-1">
                	<div class="form-group">
                    	<label>City</label>
                    	<input type="text" class="form-control" placeholder="City" disabled="" value="{{$data['location']['city']}}">
                	</div>
            	</div>
            	<div class="col-md-4 px-1">
                	<div class="form-group">
                    	<label>Country</label>
                    	<input type="text" class="form-control" placeholder="Country" disabled="" value="{{$data['location']['country']}}">
                	</div>
            	</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group interests">
                        <label>Interests</label>
                        <textarea rows="4" cols="80" class="form-control" placeholder="Add your interests with tag #">{{$data['info']['interests']}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group about">
                        <label>About Me</label>
                        <textarea rows="4" cols="80" class="form-control" placeholder="Here can be your description">{{$data['info']['about']}}</textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button>
            <div class="clearfix"></div>
        </form>
    	</div>
    </div>
</div>
<div class="col-md-4">
    <div class="card card-user">
        <div class="card-image">
            <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="...">
       	</div>
        <div class="card-body">
            <div class="author">
                <a href="#">
                	<img class="avatar border-gray" src="img/icons/spy.png" alt="...">
                	<h5 class="title">Mike Andrew</h5>
                </a>
                <p class="description">michael24</p>
            </div>
            <p class="description text-center">
                                        "Lamborghini Mercy
                                        <br> Your chick she so thirsty
                                        <br> I'm in that two seat Lambo"
            </p>
       	</div>
       	<hr>
       	<div class="button-container mr-auto ml-auto">
           	<button href="#" class="btn btn-simple btn-link btn-icon">
               	<i class="fa fa-facebook-square"></i>
            </button>
           	<button href="#" class="btn btn-simple btn-link btn-icon">
               	<i class="fa fa-twitter"></i>
            </button>
            <button href="#" class="btn btn-simple btn-link btn-icon">
                <i class="fa fa-google-plus-square"></i>
            </button>
        </div>
    </div>
</div>
</div>
</div>

@endsection
<!-- /CONTENT -->