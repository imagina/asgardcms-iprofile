@extends('layouts.master')

@section('content-header')
    <h1>{{trans('iprofile::profiles.title.create profile') }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.account.profile.edit') }}">{{ trans('iprofile::profiles.title.profiles') }}</a>
        </li>
        <li class="active">{{ trans('iprofile::profiles.title.create profile') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{trans('iprofile::profiles.form.Modify')}}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            @include('partials.form-tab-headers')
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-3">

                                        <!-- Profile Image -->
                                        <div class="box box-primary">
                                            <div class="box-body box-profile">
                                                <div id="image">
                                                    <div class="bgimg-profile">

                                                        @if(isset($profile->options->mainimage)&&!empty($profile->options->mainimage))
                                                            <img id="mainImage"
                                                                 class="image profile-user-img img-responsive img-circle"
                                                                 width="100%"
                                                                 src="{{url($profile->options->mainimage)}}?v={{$profile->updated_at}}"/>
                                                        @else
                                                            <img id="mainImage"
                                                                 class="image profile-user-img img-responsive img-circle"
                                                                 width="100%"
                                                                 src="{{url('modules/iprofile/img/default.jpg')}}"/>
                                                        @endif
                                                    </div>
                                                    <div class="btn-group bt-upload">
                                                        <label class="btn btn-primary btn-file">
                                                            <i class="fa fa-picture-o"></i> {{trans('iprofile::profiles.form.select photo')}}
                                                            <input
                                                                    type="file" accept="image/*" id="mainimage"
                                                                    name="mainimage"
                                                                    value="mainimage"
                                                                    class="form-control" style="display:none;">

                                                        </label>
                                                    </div>
                                                </div>
                                                <h3 class="profile-username text-center"> <?php if ($user->present()->fullname() != ' '): ?>
                            <?= $user->present()->fullName(); ?>
                        <?php else: ?>
                                                    <em>{{trans('core::core.general.complete your profile')}}.</em>
                                                    <?php endif; ?></h3>

                                                <p class="text-muted text-center">{{$user->roles->first()->name}}</p>

                                                <ul class="list-group list-group-unbordered">
                                                    <li class="list-group-item">
                                                        @if(isset($profile->social)&& !empty($profile->social))
                                                            @foreach($profile->social as $i=>$item)
                                                                <a class="btn btn-social-icon btn-{{$item->icono}}" href="{{$item->link}}"><i
                                                                            class="fa fa-{{$item->icono}}"></i></a>
                                                            @endforeach
                                                        @else
                                                            <p>{{trans('iprofile::profiles.form.Not fount')}}</p>
                                                        @endif
                                                    </li>
                                                </ul>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->

                                        <!-- About Me Box -->
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">{{trans('iprofile::profiles.form.About Me')}}</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <strong><i class="fa fa-book margin-r-5"></i>{{trans('iprofile::profiles.form.Education')}}
                                                </strong>

                                                <p class="text-muted">
                                                    @if(isset($profile->options->education)&& !empty($profile->options->education))
                                                        {{$profile->options->education}}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif
                                                </p>

                                                <hr>

                                                <strong><i class="fa fa-map-marker margin-r-5"></i> {{trans('iprofile::profiles.form.Location')}}
                                                </strong>

                                                <p class="text-muted"> @if(isset($profile->city)&& !empty($profile->city))
                                                        {{$profile->city}}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif
                                                    , @if(isset($profile->state)&& !empty($profile->state))
                                                        {{$profile->state}}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif</p>

                                                <hr>

                                                <strong><i class="fa fa-file-text-o margin-r-5"></i> {{trans('iprofile::profiles.form.bio')}}
                                                </strong>

                                                <p>@if(isset($profile->bio)&& !empty($profile->bio))
                                                        {!!$profile->bio!!}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif</p>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-9">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#settings"
                                                                      data-toggle="tab">{{trans('iprofile::profiles.form.Settings')}}</a>
                                                </li>
                                                <li><a href="#acount"
                                                       data-toggle="tab">{{trans('iprofile::profiles.form.Acount')}}</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="active tab-pane" id="settings">
                                                    {!! Form::open(['route' => ['admin.iprofile.profile.store'], 'method' => 'post']) !!}
                                                    <input type="hidden" id="hiddenImage" name="mainimage"
                                                           required>
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <?php $i = 0; ?>
                                                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                                                        <?php $i++; ?>
                                                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}"
                                                             id="tab_{{ $i }}">
                                                            @include('iprofile::admin.profiles.partials.create-fields', ['lang' => $locale])
                                                        </div>
                                                    @endforeach
                                                    <div class="tab-pane">
                                                        <div class="box-body">
                                                            <div class='form-group{{ $errors->has("education") ? ' has-error' : '' }}'>
                                                                {!! Form::label("education", trans('iprofile::profiles.form.Education')) !!}
                                                                {!! Form::text("education", old("education"), ['class' => 'form-control education', 'data-education' => 'target', 'placeholder' => trans('iprofile::profiles.form.Education')]) !!}
                                                                {!! $errors->first("education", '<span class="help-block">:message</span>') !!}
                                                            </div>
                                                            <div class='form-group{{ $errors->has("city") ? ' has-error' : '' }}'>
                                                                {!! Form::label("city", trans('iprofile::profiles.form.city')) !!}
                                                                {!! Form::text("city", old("city"), ['class' => 'form-control education', 'data-education' => 'target', 'placeholder' => trans('iprofile::profiles.form.city')]) !!}
                                                                {!! $errors->first("city", '<span class="help-block">:message</span>') !!}
                                                            </div>
                                                            <div class='form-group{{ $errors->has("state") ? ' has-error' : '' }}'>
                                                                {!! Form::label("state", trans('iprofile::profiles.form.state')) !!}
                                                                {!! Form::text("state", old("state"), ['class' => 'form-control state', 'data-state' => 'target', 'placeholder' => trans('iprofile::profiles.form.state')]) !!}
                                                                {!! $errors->first("state", '<span class="help-block">:message</span>') !!}
                                                            </div>
                                                            <div class='form-group{{ $errors->has("country") ? ' has-error' : '' }}'>
                                                                {!! Form::label("country", trans('iprofile::profiles.form.country')) !!}
                                                                {!! Form::text("country", old("country"), ['class' => 'form-control country', 'data-country' => 'target', 'placeholder' => trans('iprofile::profiles.form.country')]) !!}
                                                                {!! $errors->first("country", '<span class="help-block">:message</span>') !!}
                                                            </div>
                                                            <div class='form-group'>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover table-sortable "
                                                                           id="tab_logic">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="text-center">
                                                                                {{trans('iprofile::profiles.form.Social.icono')}}
                                                                            </th>
                                                                            <th class="text-center">
                                                                                {{trans('iprofile::profiles.form.Social.link')}}
                                                                            </th>
                                                                            <th class="text-center">
                                                                                {{trans('iprofile::profiles.form.Social.description')}}
                                                                            </th>
                                                                            <th class="text-center"
                                                                                style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr id='social[0]' data-id="0">
                                                                            <td data-name="social[0][icono]">
                                                                                <input type="text"
                                                                                       name='social[0][icono]'
                                                                                       id='icono'
                                                                                       placeholder='icono fa'
                                                                                       class="form-control"/>
                                                                            </td>
                                                                            <td data-name="social[0][link]">
                                                                                <input type="url" name='social[0][link]'
                                                                                       id='link'
                                                                                       placeholder='link'
                                                                                       class="form-control">
                                                                            </td>
                                                                            <td data-name="social[0][desc]">
                                                                                <input type="text"
                                                                                       name='social[0][desc]'
                                                                                       id='description'
                                                                                       placeholder='description'
                                                                                       class="form-control">
                                                                            </td>
                                                                            <td data-name="del">
                                                                                <button name="del0" class='btn btn-danger glyphicon glyphicon-remove
                                                row-remove'></button>
                                                                            </td>

                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <a id="add_row"
                                                                   class="btn btn-default">{{trans('iprofile::profiles.form.Social.Add Row')}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-footer">
                                                        <button type="submit"
                                                                class="btn btn-primary btn-flat">{{trans('iprofile::profiles.button.create profile')}}</button>
                                                        <a class="btn btn-danger pull-right btn-flat"
                                                           href="{{ route('admin.account.profile.edit')}}"><i
                                                                    class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}
                                                        </a>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                                <!-- /.tab-pane -->
                                                <div class=" tab-pane" id="acount">
                                                    <div class="tab-pane">
                                                        <div class="box-body">
                                                            {!! Form::open(['route' => ['admin.account.profile.update'], 'method' => 'put']) !!}
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            {{ Form::normalInput('first_name', trans('user::users.form.first-name'), $errors, $user) }}
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            {{ Form::normalInput('last_name', trans('user::users.form.last-name'), $errors, $user) }}
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            {{ Form::normalInputOfType('email', 'email', trans('user::users.form.email'), $errors, $user) }}
                                                                        </div>
                                                                    </div>
                                                                    <h4>{{ trans('user::users.new password setup') }}</h4>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            {{ Form::normalInputOfType('password', 'password', trans('user::users.form.new password'), $errors) }}
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            {{ Form::normalInputOfType('password', 'password_confirmation', trans('user::users.form.new password confirmation'), $errors) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-footer">
                                                                        <button type="submit"
                                                                                class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                        </div>
                                        <!-- /.nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
                                </div>


                                <div class="col-xs-12 col-sm-4">

                                </div>
                                <div class="col-xs-12 col-sm-8">
                                </div>
                            </div>
                        </div> {{-- end nav-tabs-custom --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'b', route: "<?= route('admin.account.profile.edit') ?>"}
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#image').each(function (index) {
                // Find DOM elements under this form-group element
                var $mainImage = $(this).find('#mainImage');
                var $uploadImage = $(this).find("#mainimage");
                var $hiddenImage = $(this).find("#hiddenImage");
                //var $remove = $(this).find("#remove")
                // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
                var options = {
                    viewMode: 2,
                    checkOrientation: false,
                    autoCropArea: 1,
                    responsive: true,
                    preview: $(this).attr('data-preview'),
                    aspectRatio: $(this).attr('data-aspectRatio')
                };


                // Hide 'Remove' button if there is no image saved
                if (!$mainImage.attr('src')) {
                    //$remove.hide();
                }
                // Initialise hidden form input in case we submit with no change
                //$.val($mainImage.attr('src'));

                // Only initialize cropper plugin if crop is set to true

                $uploadImage.change(function () {
                    var fileReader = new FileReader(),
                        files = this.files,
                        file;

                    if (!files.length) {
                        return;
                    }
                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $uploadImage.val("");
                            $mainImage.attr('src', this.result);
                            $hiddenImage.val(this.result);
                            $('#hiddenImage').val(this.result);

                        };
                    } else {
                        alert("Por favor seleccione una imagen.");
                    }
                });

            });
        });
    </script>
    <script>
        $(document).ready(function () {
            newid = 0;
            $("#add_row").on("click", function () {
                // Dynamic Rows Code

                // Get max row id and set new id
                newid = 0;
                $.each($("#tab_logic tr"), function () {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;

                var tr = $("<tr></tr>", {
                    id: "social[" + newid + "]",
                    "data-id": newid
                });

                // loop through each td and create new elements with name of newid
                $.each($("#tab_logic tbody tr:nth(0) td"), function () {
                    var cur_td = $(this);
                    var name = $(cur_td).data("name");
                    var children = cur_td.children();

                    // add new td and element if it has a nane
                    if ($(this).data("name") != undefined) {
                        var td = $("<td></td>", {
                            "data-name": name.substr(0, 7) + newid + name.substr(8)
                        });

                        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");

                        c.attr("name", name.substr(0, 7) + newid + name.substr(8));
                        c.appendTo($(td));
                        td.appendTo($(tr));
                    } else {
                        var td = $("<td></td>", {
                            'text': $('#tab_logic tr').length
                        }).appendTo($(tr));
                    }
                });
                // add the new row
                $(tr).appendTo($('#tab_logic'));

                $(tr).find("td button.row-remove").on("click", function () {
                    $(this).closest("tr").remove();
                });
            });
            // Sortable Code
            var fixHelperModified = function (e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function (index) {
                    $(this).width($originals.eq(index).width())
                });

                return $helper;
            };

            $(".table-sortable tbody").sortable({
                helper: fixHelperModified
            }).disableSelection();

            $(".table-sortable thead").disableSelection();

           // $("#add_row").trigger("click");
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('input[name="birthday"]').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    "locale": {
                        "format": "DD-MM-YYYY",
                        "separator": " - ",
                        "applyLabel": "Apply",
                        "cancelLabel": "Cancel",
                        "customRangeLabel": "Custom",
                        "weekLabel": "M",
                        "daysOfWeek": [
                            "D",
                            "L",
                            "M",
                            "Mi",
                            "J",
                            "V",
                            "S"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Augosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                    }
                },
                function (start, end, label) {
                    var years = moment().diff(start, 'years');
                });
        });
    </script>


@endpush
