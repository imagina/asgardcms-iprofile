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
{{dd($profile)}}
@section('content')
    <div class="bg-breadcrumb"></div>

    <div class="iblock general-block31" data-blocksrc="general.block31">
        <div class="container">
            <div class="row">
                <div class="col">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-4 text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('iprofile::profiles.title.home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('account.profile.index')}}">{{trans('iprofile::profiles.title.profiles')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><strong>{{trans('iprofile::profiles.title.edit profile')}}</strong></li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row pb-5">
            <div class="col-12">
                <div class="row profile-edit">
                    <!-- MENU -->
                    <div class="col-lg-3">

                        <div class="profile-picture">

                             {!! Form::open(['route' => ['iprofile.profile.update', $profile->id], 'method' => 'put']) !!}
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
                                    <!-- btn -->
                                    <div class="btn btn-upload">
                                        <label class="btn btn-info btn-file">
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
                            {!! Form::close() !!}
                        </div>
                        
HOLA MUNDO
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item w-100">
                                <a 
                                    class="nav-link active" 
                                    id="info-tab" 
                                    data-toggle="tab" 
                                    href="#info" 
                                    role="tab" 
                                    aria-controls="info" 
                                    aria-selected="true">
                                    {{trans('iprofile::profiles.title.info')}}
                                </a>
                            </li>
                            <li class="nav-item w-100">
                                <a 
                                    class="nav-link" 
                                    id="account-tab" 
                                    data-toggle="tab" 
                                    href="#account" 
                                    role="tab" 
                                    aria-controls="account" 
                                    aria-selected="false">
                                    {{trans('iprofile::profiles.title.Account')}}
                                </a>
                            </li>
                            <li class="nav-item w-100">
                                <a 
                                    class="nav-link" 
                                    id="address-tab" 
                                    data-toggle="tab" 
                                    href="#address" 
                                    role="tab" 
                                    aria-controls="address" 
                                    aria-selected="false">
                                {{trans('iprofile::profiles.form.address')}}
                                </a>
                            </li>
                            <li class="nav-item w-100">
                                <a 
                                    class="nav-link" 
                                    id="social-tab" 
                                    data-toggle="tab" 
                                    href="#social" 
                                    role="tab" 
                                    aria-controls="social" 
                                    aria-selected="false">
                                {{trans('iprofile::profiles.title.social')}}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- PAGINAS -->
                    <div class="col-lg-9 tab-content featured-contests-block-right">

                        <!-- CONFIG PROFILE PAG(1)-->
                        <div class="active tab-pane" id="info">
                            <!-- formulario -->
                            {!! Form::open(['route' => ['iprofile.profile.update', $profile->id], 'method' => 'put']) !!}
                            <div class="row">
                                <!-- Profile Image -->
                                <div class="col-12 text-center">
                                    
                                </div>

                                <!-- Campos Formularios -->
                                <div class="col-12">

                                    @php $locale = LaravelLocalization::setLocale() ?: App::getLocale();@endphp


                                    @include('iprofile::frontend.partials.edit-fields', ['lang' => $locale])

                                </div>
                            </div>

                            <!-- BOTONES -->
                            <div class="box-footer float-right">
                                <button type="submit"
                                        class="btn btn-primary btn-flat">
                                    {{trans('iprofile::profiles.button.update profile')}}
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <!-- ACTUALIZACIÓN PERFIL PAG(2)-->
                        <div class="tab-pane" id="account">
                            <div class="box-body">
                                {!! Form::open(['route' => ['iprofile.user.update'], 'method' => 'put']) !!}
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                {{ Form::normalInput('first_name', trans('user::users.form.first-name'), $errors, $user) }}
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                {{ Form::normalInput('last_name', trans('user::users.form.last-name'), $errors, $user) }}
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                {{ Form::normalInputOfType('email', 'email', trans('user::users.form.email'), $errors, $user) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <h4>
                                            {{ trans('user::users.new password setup') }}
                                        </h4>
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                {{ Form::normalInputOfType('password', 'password', trans('user::users.form.new password'), $errors) }}
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                {{ Form::normalInputOfType('password', 'password_confirmation', trans('user::users.form.new password confirmation'), $errors) }}
                                            </div>
                                        </div>

                                        <div class="box-footer">
                                            <button type="submit"
                                                    class="btn btn-primary btn-flat">
                                                {{ trans('core::core.button.update') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {!!Form::close()!!}
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="address">
                            {!! Form::open(['route' => ['iprofile.user.update'], 'method' => 'put']) !!}
                            <div class="row">
                                <h4>{{trans('iprofile::profiles.title.information')}}</h4>
                                <div class="col-12 col-lg-6">
                                    {{ Form::normalInput('company', trans('iprofile::profiles.form.company'), $errors, $user) }}
                                </div>
                            </div>
                            {!!Form::close()!!}
                        </div>
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
          href="{{url('/themes/adminlte/vendor/admin-lte/plugins/daterangepicker/daterangepicker.css')}}">
    <script src="{{url('/themes/adminlte/vendor/admin-lte/plugins/daterangepicker/moment.min.js')}}"
            type="text/javascript"></script>
    <script src="{{url('/themes/adminlte/vendor/admin-lte/plugins/daterangepicker/daterangepicker.js')}}"
            type="text/javascript"></script>
    <script src="{{url('/themes/adminlte/js/vendor/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
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
                            "L",
                            "M",
                            "Mi",
                            "J",
                            "V",
                            "S",
                            "D"
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