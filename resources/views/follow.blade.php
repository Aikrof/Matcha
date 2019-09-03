@extends('layouts.default')

@section($section)
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

<div class="container-fluid">

<div class="row">
    <div class="col-md-4 pr-1">
        <div class="form-group">
            <label>Sortered by:</label>
            <p class="form-control dropdown-toggle nav-link flexible" data-toggle="dropdown">
                <span>location</span>
            </p>
            <input type="hidden" class="form-control">
            <ul class="dropdown-menu orient_choose">
                <a class="dropdown-item edit_select" name="orientation" change="flexible">age</a>
                <a class="dropdown-item edit_select" name="orientation" change="flexible">location</a>
                <a class="dropdown-item edit_select" name="orientation" change="flexible">fame rating</a>
                <a class="dropdown-item edit_select" name="orientation" change="flexible">tags</a>
            </ul>
        </div>
    </div>
    <div class="col-md-4 pr-1">
        <div class="form-group">
            <label>Filtered by:</label>
            <p class="form-control dropdown-toggle nav-link flexible" data-toggle="dropdown">
            	<span></span>
            </p>
            <input type="hidden" class="form-control">
            <ul class="dropdown-menu orient_choose">
                <a class="dropdown-item edit_select" name="orientation" change="flexible">age</a>
                <a class="dropdown-item edit_select" name="orientation" change="flexible">location</a>
                <a class="dropdown-item edit_select" name="orientation" change="flexible">fame rating</a>
                <a class="dropdown-item edit_select" name="orientation" change="flexible">tags</a>
            </ul>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
@foreach($data as $user)

<div class="row mb-10">
	<div class="col-md-12 info_follow_container" style="display: flex; border: 1px solid #9A9A9A; border-radius: 4px;height: 80%;">
	   <img class="follow_user_icon" src="{{$user['icon']}}" style="align-self: center;">
        <div class="top_foll">
            <div class="top_follow_info">
                <p class="follow_user_login">{{$user['login']}}</p>
                <label>Rating</label>
                <div class="progress" style="height: 3.5vh;background-color: #e74c3c;">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="70"
                    aria-valuemin="0" aria-valuemax="100" style="width:{{$user['rating'] . '%'}};height: 3.5vh;">
                        <p>{{$user['rating']}}</p>
                    </div>
                </div>
            </div>
           <div class="">
                <label style="display: flex;">Age:
                    <p style="margin: 0">{{$user['age']}}</p>
                </label>
                <label style="display: flex;">Gender:
                    <p style="margin: 0">{{$user['gender']}}</p>
                </label>
                <label style="display: flex;">Orientation:
                    <p style="margin: 0">{{$user['orientation']}}</p>
                </label>
           </div>
       </div>
        <div class="form-group" style="width: 40%;">
            <!-- <label>Interests:</label> -->
            <div class="col-md-12" style="border: 1px solid #9A9A9A; border-radius: 4px;height: 50%;">
            @if ($user['interests'] && !empty($user['interests'][0]))
                @foreach ($user['interests'] as $tag)
                    <p class="tag_se">#{{$tag}}</p>
                @endforeach
            @endif
            </div>

            <!-- <label>About:</label> -->
            <div class="col-md-12" style="border: 1px solid #9A9A9A; border-radius: 4px;height: 50%;">
            @if ($user['interests'] && !empty($user['interests'][0]))
                @foreach ($user['interests'] as $tag)
                    <p class="tag_se">#{{$tag}}</p>
                @endforeach
            @endif
            </div>
        </div>
    </div>
</div>

@endforeach
</div>
</div>

</div>

{{$paginate->appends(['sorted' => $additional_data['sorted'], 'filtered' => 'age'])->render()}}
<!-- {{$paginate->appends(['order' => 'ASC/DESC'])->links()}} -->
@endsection
<!-- /CONTENT -->

<!-- CONTENT SCRIPT -->
@section('script')
    <script type="text/javascript" src="js/follow.js"></script>
@endsection
 <!-- /CONTENT SCRIPT -->