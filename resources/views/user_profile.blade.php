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
            	<div class="col-md-6 pr-1">
                	<div class="form-group">
                		<label>Username</label>
                		<input type="text" class="form-control" placeholder="Username" disabled="" value="{{ucfirst(strtolower($data['user']['login']))}}">
                	</div>
            	</div>
            	<div class="col-md-6 pr-1">
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
                        <input type="text" class="form-control edit edit_inp" name="first_name" autocomplete="off" placeholder="First Name" value="{{$data['info']['first_name']}}">
                    </div>
                </div>
                <div class="col-md-6 pr-1">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control edit_inp" name="last_name" autocomplete="off" placeholder="Last Name" value="{{$data['info']['last_name']}}">
                	</div>
                </div>
            </div>
            <div class="row user_a_b">
                <div class="col-md-4 pr-1">
                    <div class="form-group">
                        <label>Gender</label>
                        <input type="text" class="form-control" placeholder="gender" disabled="" value="{{ $data['info']['gender']}}">
                    </div>
                </div>
                <div class="col-md-4 pr-1">
                    <div class="form-group">
                        <label>Orientation</label>
                        <p class="form-control dropdown-toggle nav-link flexible" data-toggle="dropdown">
                            <span>{{$data['info']['orientation']}}</span>
                        </p>
                        <input type="hidden" class="form-control">
                        <ul class="dropdown-menu orient_choose">
                            <a class="dropdown-item edit_select" name="orientation" change="flexible">Heterosexual</a>
                            <a class="dropdown-item edit_select" name="orientation" change="flexible">Bisexual</a>
                            <a class="dropdown-item edit_select" name="orientation" change="flexible">Homosexual</a>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 pr-1">
                    <div class="form-group">
                        <label>Age</label>
                        <input type="text" class="form-control edit_inp" name="age" autocomplete="off" placeholder="Age" value="{{($data['info']['age'] === 0) ? '' : $data['info']['age']}}">
                    </div>
                </div>
            </div>
            <div class="row user_a_b">
                <div class="col-md-4 pr-1">
                    <div class="form-group">
                        <label>Birth Day</label>
                        <input type="text" maxlength="2" class="form-control edit_inp" name="day" autocomplete="off" placeholder="Day" value="{{($data['birthday']['day'] === 0) ? '' : $data['birthday']['day']}}">
                    </div>
                </div>
                <div class="col-md-4 pr-1">
                    <div class="form-group">
                        <label>Birth Month</label>
                        <p class="form-control dropdown-toggle nav-link birthday_buttn" data-toggle="dropdown">
                            <span>{{$data['birthday']['month'] === null ? 'Month' : $data['birthday']['month']}}</span>
                        </p>
                        <input type="hidden" class="form-control">
                        <ul class="dropdown-menu orient_choose">
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">January</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">February</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">March</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">April</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">May</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">June</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">July</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">August</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">September</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">October</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">November</a>
                            <a class="dropdown-item edit_select" name="month" change="birthday_buttn">December</a>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 pr-1">
                    <div class="form-group">
                        <label>Birth Year</label>
                        <input type="text" maxlength="4" class="form-control edit_inp" name="year" autocomplete="off" placeholder="year" value="{{($data['birthday']['year'] === 0) ? '' : $data['birthday']['year']}}">
                    </div>
                </div>

            </div>
            <div class="row">
            	<div class="col-md-6 pr-1">
                	<div class="form-group">
                    	<label>City</label>
                    	<input type="text" class="form-control city_local"disabled="" value="{{$data['location']['user_access'] === 1 ? $data['location']['city'] : ''}}">
                	</div>
            	</div>
                <div class="col-md-6 pr-1">
                	<div class="form-group">
                    	<label>Country</label>
                    	<input type="text" class="form-control country_local" disabled="" value="{{$data['location']['user_access'] === 1 ? $data['location']['country'] : ''}}">
                	</div>
            	</div>
            </div>

            <div class="row">
                <div class="col-md-12 pr-1">
                        <label>Location</label>
                    <div class="form-group user_location_cont">
                        <p class="btn form-control user_location_add">Add Location</p>
                        <p class="btn form-control user_location_remove">Remove Location</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Add Interests</label>
                    <p class="help_small_user"><small>*Add your interests with tag #</small></p>
                    <p class="help_small_user"><small>*To save / write new tag just press # or press add</small></p>
                    <div style="display: flex;">
                            <input class="form-control" id="interestsHelp" autocomplete="off" placeholder="Add your interests with tag #" oninput="tagHelper(this.value)" value="#">
                            <p class="btn btn_inter" style="margin-left: 10px;cursor: pointer;">Add</p>
                    </div>
                    <div class="row pr-1 helperRel">
                        <div class="helperProfInt" style="display: none;"></div>
                    </div>
                    <label>Remove Interests</label>
                    <p class="help_small_user"><small>To delete tag just click to tag</small></p>
                    <div class="col-md-12 form-group interest_cont">
                        @if ($data['interests'] && !empty($data['interests'][0]))
                            @foreach ($data['interests'] as $tag)
                                <p class="tag_se">#{{$tag}}</p>
                             @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group about">
                        <label>About Me</label>
                        <p class="help_small_user"><small>*To save just click on an empty area or press button 'Add Changes'</small></p>
                        <textarea rows="4" cols="80" class="form-control edit_inp" name="about" placeholder="Here can be your description">{{$data['info']['about']}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group fle_xeble_col">
                    <p class="btn btn_inter cursor flex_end">Add Changes</p>
                </div>
            </div>
        </form>
    	</div>
    </div>
</div>
<div class="col-md-4">
    <div class="card card-user">
        <div class="card-image">
            <img src="{{'img/sidebar/' . $data['user']['backgroundImg']}}" alt="...">
       	</div>
        <div class="card-body">
            <div class="author">
                <a href="#">
                	<img class="avatar border-gray" src="{{$data['info']['icon']}}" alt="...">
                	<h5 class="title">{{$data['info']['first_name'] . " " . $data['info']['last_name']}}</h5>
                </a>
                <p class="description">{{$data['user']['login']}}</p>
            </div>
            <p class="description text-center">
                {{$data['info']['about']}}
            </p>
       	</div>
    </div>
</div>
</div>
</div>

@endsection
<!-- /CONTENT -->

<!-- CONTENT SCRIPT -->
@section('script')
    <script type="text/javascript" src="js/user.js"></script>
@endsection
 <!-- /CONTENT SCRIPT -->