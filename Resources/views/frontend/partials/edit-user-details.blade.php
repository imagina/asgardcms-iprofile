<div class="col-md-3 user-details">
    <!-- Profile Image -->
    <div id="image">
        <!-- imagen -->
        <div class="bgimg-profile mr-0">
            @if(isset($profile->options->mainimage)&&!empty($profile->options->mainimage))
                <img id="mainImage"
                     class="image profile-user-img"
                     src="{{url($profile->options->mainimage)}}?v={{$profile->updated_at}}"/>
            @else
                <img id="mainImage"
                     class="image profile-user-img"
                     src="{{url('modules/iprofile/img/default.jpg')}}"/>
            @endif
        </div>
        <br>
        <div class="row">
            <!-- btn -->
            <div class="btn btn-upload w-100">
                <label class="btn btn-info btn-file mb-0 float-right">
                    {{trans('iprofile::profiles.form.select photo')}}
                    <input type="file"
                           accept="image/*"
                           id="mainimage"
                           name="mainimage"
                           value="mainimage"
                           class="form-control"
                           style="display:none;">
                    <input type="hidden"
                           id="hiddenImage"
                           name="mainimage"
                           required>
                </label>
            </div>


        </div>
    </div>


    <div class="row">
        @include('iprofile::frontend.partials.profile-list',['menu'=> 1])
    </div>
</div>
<!-- /.col -->