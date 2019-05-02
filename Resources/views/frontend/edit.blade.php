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
    <div class="bg-breadcrumb"></div>
    
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="row profile-edit">
                
                    <div class="col-md-3 tab-menu">
                        <div class="box-header">
                            <h4 class="tab-menu-title text-uppercase">{{trans('iprofile::profiles.form.Modify')}}</h4>
                        </div>

                        <ul class="nav nav-tabs nav-stacked">
                            <li class="active">
                                <a href="#settings" data-toggle="tab">{{trans('iprofile::profiles.form.Settings')}}</a>
                            </li>
                            <li>
                                <a href="#acount" data-toggle="tab">{{trans('iprofile::profiles.form.Acount')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-9 tab-content">
                            <div class="active tab-pane" id="settings">
                                <div class="tab-heading">
                                    <h3 class="tab-title">{{trans('iprofile::profiles.form.Settings')}}</h3>
                                </div>

                                <!-- Profile Image -->

                                {!! Form::open(['route' => ['iprofile.profile.update', $profile->id], 'method' => 'put']) !!}

                                <div class="profile-picture">
                                    <label class="label-custom"><strong>Foto de perfil</strong></label>
                                    <div id="image">

                                    <div class="bgimg-profile">
                                        @if(isset($profile->options->mainimage)&&!empty($profile->options->mainimage))
                                            <img id="mainImage" class="image profile-user-img"
                                                 src="{{url($profile->options->mainimage)}}?v={{$profile->updated_at}}"/>
                                        @else
                                            <img id="mainImage" class="image profile-user-img"
                                                 src="{{url('modules/iprofile/img/default.jpg')}}"/>
                                        @endif
                                    </div>
                                    <div class="btn-group btn-upload">
                                        <label class="btn btn-primary btn-file">
                                            {{trans('iprofile::profiles.form.select photo')}}
                                            <input type="file" accept="image/*" id="mainimage"
                                                   name="mainimage"
                                                   value="mainimage"
                                                   class="form-control" style="display:none;">
                                            <input type="hidden" id="hiddenImage" name="mainimage"
                                       required>
                                        </label>
                                    </div>

                                    </div>
                                </div>

                               
                                
                                <?php $i = 0; ?>
                                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                                    <?php $i++; ?>
                                    <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}"
                                         id="tab_{{ $i }}">
                                        @include('iprofile::frontend.partials.edit-fields', ['lang' => $locale])
                                    </div>
                                @endforeach
                                <div class="tab-pane">
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-6">
                                                <div class='form-group{{ $errors->has("education") ? ' has-error' : '' }}'>
                                                    @php
                                                        if(isset($profile->options->education) && !empty($profile->options->education)){
                                                        $oldeducation = $profile->options->education;
                                                        }else{
                                                        $oldeducation=null;
                                                        }

                                                    @endphp
                                                    {!! Form::label("education", trans('iprofile::profiles.form.Education')) !!}
                                                    {!! Form::text("education", old("education",$oldeducation), ['class' => 'form-control education', 'data-education' => 'target', 'placeholder' => trans('iprofile::profiles.form.Education')]) !!}
                                                    {!! $errors->first("education", '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6">
                                                <div class='form-group{{ $errors->has("city") ? ' has-error' : '' }}'>
                                                    {!! Form::label("city", trans('iprofile::profiles.form.city')) !!}
                                                    {!! Form::text("city", old("city",$profile->city), ['class' => 'form-control education', 'data-education' => 'target', 'placeholder' => trans('iprofile::profiles.form.city')]) !!}
                                                    {!! $errors->first("city", '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6">
                                                <div class='form-group{{ $errors->has("state") ? ' has-error' : '' }}'>
                                                    {!! Form::label("state", trans('iprofile::profiles.form.state')) !!}
                                                    {!! Form::text("state", old("state",$profile->state), ['class' => 'form-control state', 'data-state' => 'target', 'placeholder' => trans('iprofile::profiles.form.state')]) !!}
                                                    {!! $errors->first("state", '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6">
                                                <div class='form-group{{ $errors->has("country") ? ' has-error' : '' }}'>
                                                    {!! Form::label("country", trans('iprofile::profiles.form.country')) !!}
                                                    {!! Form::text("country", old("country", $profile->country), ['class' => 'form-control country', 'data-country' => 'target', 'placeholder' => trans('iprofile::profiles.form.country')]) !!}
                                                    {!! $errors->first("country", '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>

                                            @if(config('asgard.iprofile.config.fields_register.identification'))
                                            <div class="col-xs-12">
                                                <div class='form-group{{ $errors->has("identification") ? ' has-error' : '' }}'>
                                                    {!! Form::label("identification", trans('iprofile::profiles.form.identification')) !!}
                                                    {!! Form::text("identification", old("identification", $profile->identification), ['class' => 'form-control identification','required' => 'required', 'data-identification' => 'target', 'placeholder' => trans('iprofile::profiles.form.identification')]) !!}
                                                    {!! $errors->first("identification", '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                            @endif

                                            @if(isset($profile->business) && !empty($profile->business))
                                            <div class="col-xs-12">
                                                <div class='form-group{{ $errors->has("business") ? ' has-error' : '' }}'>
                                                    {!! Form::label("business", trans('iprofile::profiles.form.business')) !!}
                                                    {!! Form::text("business", old("business", $profile->business), ['class' => 'form-control identification', 'required' => 'required' ,'data-business' => 'target', 'placeholder' => trans('iprofile::profiles.form.business')]) !!}
                                                    {!! $errors->first("business", '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                            @endif

                                            {{--
                                            <div class="col-xs-12">
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
                                                            @if(isset($profile->social)&& !empty($profile->social))
                                                                @foreach($profile->social as $i=>$item)
                                                                    <tr id='social[{{$i}}]'
                                                                        data-id="{{$i}}">
                                                                        <td data-name="social[{{$i}}][icono]">
                                                                            <input type="text"
                                                                                   name="social[{{$i}}][icono]"
                                                                                   id='icono'
                                                                                   placeholder='icono fa'
                                                                                   class="form-control"
                                                                                   value="{{$item->icono or ''}}"/>
                                                                        </td>
                                                                        <td data-name="link">
                                                                            <input type="url"
                                                                                   name='social[{{$i}}][link]'
                                                                                   id='link'
                                                                                   placeholder='link'
                                                                                   class="form-control"
                                                                                   value="{{$item->link or ''}}">
                                                                        </td>
                                                                        <td data-name="description">
                                                                            <input type="text"
                                                                                   name='social[{{$i}}][desc]'
                                                                                   id='description'
                                                                                   placeholder='description'
                                                                                   class="form-control"
                                                                                   value="{{$item->desc or ''}}">
                                                                        </td>
                                                                        <td data-name="del">
                                                                            <button name="del0" class='btn btn-danger glyphicon glyphicon-remove
                                    row-remove'></button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <a id="add_row"
                                                       class="btn btn-default">{{trans('iprofile::profiles.form.Social.Add Row')}}</a>
                                                </div>
                                            </div>
                                            --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit"
                                            class="btn btn-primary btn-flat">{{trans('iprofile::profiles.button.create profile')}}</button>
                                    <a class="btn btn-danger pull-right btn-flat"
                                       href="{{ route('account.profile.index')}}"><i
                                                class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}
                                    </a>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <!-- /.tab-pane admin.account.profile.update -->
                            <div class="tab-pane" id="acount">
                                <div class="box-body">
                                    {!! Form::open(['route' => ['iprofile.user.update'], 'method' => 'put']) !!}
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
                                    {!!Form::close()!!}
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    {{--<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous">
    </script>--}}
    <link media="all" type="text/css" rel="stylesheet"
          href="{{url('/themes/adminimagina/vendor/admin-lte/plugins/daterangepicker/daterangepicker.css')}}">
    <script src="{{url('/themes/adminimagina/vendor/admin-lte/plugins/daterangepicker/moment.min.js')}}"
            type="text/javascript"></script>
    <script src="{{url('/themes/adminimagina/vendor/admin-lte/plugins/daterangepicker/daterangepicker.js')}}"
            type="text/javascript"></script>
    <script src="{{url('/themes/adminimagina/js/vendor/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

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

@stop