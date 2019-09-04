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
<div class="col-md-10">
<div class="card">
<div class="card-body">
@foreach($data as $user)

<div class="row">
    <div class="col-md-10 pr-1">
        <div class="form-group" style="width: 100%;">
            <div style="display: flex;width: 100%;">
            <img class="img_for" src="{{$user['icon']}}">
            <div style="display: flex;width: calc(90% - 124px);flex-direction: column;margin-left: 10px;">
                <div style="display: flex;flex-direction: column;">
                    <p class="login_for">{{$user['login']}}</p>
                    <p class="first_last_for">({{$user['first_name'] . ' ' . $user['last_name']}})</p>
                </div>
                <label>Rating:</label>
                <div class="progress" style="height: 3.5vh;background-color: #e74c3c;">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="70"
                    aria-valuemin="0" aria-valuemax="100" style="width:{{$user['rating'] . '%'}};height: 3.5vh;">
                        <p>{{$user['rating']}}</p>
                    </div>
                </div>
                @if (!empty($user['age']))
                <div>
                    <label>Age: </label>
                    <span>{{$user['age']}}</span>
                </div>
                @endif
                @if (!empty($user['location']))
                <div>
                    <label>Location: </label>
                    <span>{{$user['location']['country'] . ', ' . $user['location']['city']}}</span>
                </div>
                @endif
            </div>
            </div>
            <div>
                <label>Interests: </label>
                @if ($user['interests'] && !empty($user['interests'][0]))
                    @foreach ($user['interests'] as $tag)
                        <p class="tag_for">#{{$tag}}</p>
                    @endforeach
                @endif
            </div>
            <div>
                <label>About:</label>
                <span>{{$user['about']}}</span>
            </div>
        </div>
    </div>
</div>
<div class="row gap_for"></div>
@endforeach
</div>
</div>
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