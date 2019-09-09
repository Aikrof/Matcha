@extends('layouts.default')

@section('stylesheet')

@endsection

@section($section)
{{'active'}}
@endsection

<!-- CONTENT -->
@section('content')

<div class="container-fluid">

<div class="row mr-20">
    <div class="col-md-6 resizable-choice">
        <ul class="tab-group">
            <li class="tab active sort_filter"><a class="a_sf">Sort / Filter</a></li>
        </ul>
    </div>
</div>


<div class="row" id="sf_show">
    <div class="col-md-12">
        <form class="form-group f_Sort_Filter">
        <div class="sf_cont">
            <div class="col-md-6 h540">
                <p class="pattaya_style c-e74 f_pSF">Sort</p>
                <div class="row">
                    <label class="name_SF">Age:</label>
                    <input id="age__ham" class="sort_age f_imp_check" type="checkbox" name="toppings" value=false><label for="age__ham" class="f_lab_check" data="0"><div class="sort_checker"></div></label>
                </div>
                <div class="row">
                    <label class="name_SF">Location:</label>
                    <input id="location_ham" class="sort_location f_imp_check" type="checkbox" name="toppings" value=false><label for="location_ham" class="f_lab_check" data="0"><div class="sort_checker"></div></label>
                </div>
                <div class="row">
                    <label class="name_SF">Rating:</label>
                       <input id="rating_ham" class="sort_rating f_imp_check" type="checkbox" name="toppings" value=false><label for="rating_ham" class="f_lab_check" data="0"><div class="sort_checker"></div></label>
                </div>
                <div class="row" style="display: flex;flex-direction: column;">
                    <label class="name_SF">Interests:</label>
                    <div class="col-md-10">
                    <p class="help_small_user"><small>*Add interests with tag #</small></p>
                    <p class="help_small_user"><small>*To write new tag just press # or press add</small></p>
                    <div class="interests_inp_cont">
                            <input class="form-control f_inp_interests_foll" id="interestsHelp" autocomplete="off" placeholder="Add your interests with tag #" oninput="tagHelper(this.value)" value="#">
                            <p class="btn btn_inter btn_input_interests_f">Add</p>
                    </div>
                    <div class="row pr-1 helperRel">
                        <div class="helperProfInt helperAbs" style="display: none;"></div>
                    </div>
                    <p class="help_small_user"><small>To delete tag just click to tag</small></p>
                    <div class="col-md-12 form-group interest_cont interests_cont_filter_foll sort_interests"></div>
                    </div>
                </div>
                <div class="row">
                    <label class="name_SF">Sorted by:</label>
                    <div class="col-md-12 sort_by_cont">
                        <input id="toggle-on" class="toggle toggle-left" name="toggle" value="ASC" type="radio" checked>
                        <label for="toggle-on" class="btn_lab btn">Ascending</label>
                        <input id="toggle-off" class="toggle toggle-right" name="toggle" value="DESC" type="radio">
                        <label for="toggle-off" class="btn_lab btn">Descending</label>
                        <input type="hidden" name="sorted_by">
                    </div>
                </div>
            </div>
            <div class="col-md-6 h540">
                <p class="pattaya_style c-e74 f_pSF">Filter</p>
                 <div class="row">
                    <label class="name_SF">Age:</label>
                    <div class="col-md-12">
                        <div class="multi-range multi-range-double filter_range_age" data-lbound='10' data-ubound='60'>
                        <div class="multi_range_1"></div>
                        <input class="slider" type="range" min="10" step="1" max="60" value="60" oninput='this.parentNode.dataset.ubound=this.value;'>
                        <input class="slider" type="range" min="10" step="1" max="60" value="10" oninput='this.parentNode.dataset.lbound=this.value;'>
                        <div class="multi_range_2"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                   <label class="name_SF">Location Distance:</label>
                    <div class="col-md-12">
                        <label><small class="font-s13_5">From, km:</small>
                        <input class="form-control w120 distance_inp" type="text" name="from" placeholder="From" autocomplete="off" maxlength="4"></label>
                        <span>-</span>
                        <label><small class="font-s13_5">To, km:</small>
                        <input class="form-control w120 distance_inp" type="text" name="to" placeholder="To" autocomplete="off" maxlength="4"></label>
                    </div>
                </div>
                <div class="row">
                    <label class="name_SF">Rating:</label>
                    <div class="col-md-12">
                       <div class='multi-range multi-range-one filter_rating' data-lbound='0'>
                        <input class="slider" type="range" min="0" step="1" max="100" value="0" oninput='this.parentNode.dataset.lbound=this.value;'>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;flex-direction: column;">
                    <label class="name_SF">Interests:</label>
                    <div class="col-md-10">
                     <p class="help_small_user"><small>*Add interests with tag #</small></p>
                    <p class="help_small_user"><small>*To write new tag just press # or press add</small></p>
                    <div class="interests_inp_cont">
                            <input class="form-control f_inp_interests_foll" id="interestsHelpFilter" autocomplete="off" placeholder="Add your interests with tag #" oninput="tagHelperFilter(this.value)" value="#">
                            <p class="btn btn_inter_filter btn_input_interests_f">Add</p>
                    </div>
                    <div class="row pr-1 helperRel">
                        <div class="helperProfIntFilter helperAbs" style="display: none;"></div>
                    </div>
                    <p class="help_small_user"><small>To delete tag just click to tag</small></p>
                    <div class="col-md-12 form-group interest_cont_filter interests_cont_filter_foll filter_interests"></div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-8" style="display: flex;justify-content: center;">
                <div class="row">
                    <p class="btn f_cancel_btn">Cancel</p>
                    <p class="btn f_ok_btn">OK</p>
                </div>
            </div>
        </form>
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

{{$paginate->appends(['sort' => $additional_data['sort'], 'filter' => $additional_data['filter']])->render()}}
<!-- {{$paginate->appends(['order' => 'ASC/DESC'])->links()}} -->
@endsection
<!-- /CONTENT -->

<!-- CONTENT SCRIPT -->
@section('script')
<script type="text/javascript" src="js/follow.js"></script>
@endsection
 <!-- /CONTENT SCRIPT -->