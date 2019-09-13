<div class="click-closed"></div>
<div class="box-collapse">
  <div class="title-box-d">
    <h3 class="title-d">Search Property</h3>
  </div>
  <span class="close-box-collapse right-boxed ion-ios-close"></span>
  <div class="box-collapse-wrap form">
      <form class="form-a">
        <div class="row">
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label for="Type">Keyword</label>
              <input type="text" class="form-control form-control-lg form-control-a" placeholder="Search">
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="country_search">Country</label>
              <select class="form-control" id="country_search">
                <option>Select Country</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="city">City</label>
              <select class="form-control" id="city_search">
                <option>All City</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="bedrooms">Sort by</label>
              
                <div class="row">
                    <label class="name_SF">Age:</label>
                    <input id="age__ham" class="sort_age f_imp_check" type="checkbox" name="toppings" value=false><label for="age__ham" class="f_lab_check" data="0"><div class="sort_checker"></div></label>
                </div>
                <div class="row">
                    <label class="name_SF">Distance:</label>
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
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="garages">Filter by</label>
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
                        <div class='multi-range multi-range-one-km less_100 distance_inp' data-lbound='0'>
                        <input class="slider" type="range" min="0" step="1" max="100" value="0" oninput='setDistance(this);'>
                        </div>
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
<!--           <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="bathrooms">Bathrooms</label>
              <select class="form-control form-control-lg form-control-a" id="bathrooms">
                <option>Any</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
              </select>
            </div>
          </div> -->
          <!-- <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="price">Min Price</label>
              <select class="form-control form-control-lg form-control-a" id="price">
                <option>Unlimite</option>
                <option>$50,000</option>
                <option>$100,000</option>
                <option>$150,000</option>
                <option>$200,000</option>
              </select>
            </div>
          </div> -->
          <div class="col-md-12">
            <p class="btn btn-b">Search</p>
          </div>
        </div>
      </form>
    </div>
  </div>