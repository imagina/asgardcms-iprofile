@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('iprofile::profiles.title.edit profile') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.iprofile.profiles.index') }}">{{ trans('iprofile::profiles.title.profiles') }}</a>
        </li>
        <li class="active">{{ trans('iprofile::profiles.title.edit profile') }}</li>
    </ol>
@stop

@section('content')
    {{-- 
    Para que el modulo de construccion de campos dinamico funcione se debe incluir @include('iprofile::admin.users.partials.fieldsConstruct') en cualquier parte de @section('content') antes de los @stack.
    Para colocar los campos dentro de la vista se debe utilizar @stack('personal'),@stack('phones') y @stack('financieros'), cada uno en la seccion que se requiera
    --}}
    @include('iprofile::admin.users.partials.fieldsConstruct')

    @php
        $prueba = ((array) $user);
    @endphp

    {!! Form::model($user,['route' => ['admin.iprofile.profiles.update', $user->id], 'method' => 'put']) !!}

    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @isset($user->main_image)
                    <img class="profile-user-img img-responsive img-circle" src="{{ Theme::url($user->main_image) }}" alt="User profile picture">
                    @endisset
                    <h3 class="profile-username text-center">{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                        <b>{{ trans('iprofile::profiles.form.email') }}</b> <a class="pull-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                        <b>{{ trans('iprofile::profiles.form.created_at') }}</b> <a class="pull-right">{{ $user->created_at }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
             <!-- /.box -->
        </div>
    
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#personal" data-toggle="tab">Personal</a></li>
                  <li><a href="#financiero" data-toggle="tab">Financiero</a></li>
                  <li><a href="#tab_peps" data-toggle="tab">PEP'S</a></li>
                  <li><a href="#tab_fonds_origin" data-toggle="tab">Origen de Fondos</a></li>
                  <li><a href="#tab_activity_international_operations" data-toggle="tab">Operaciones Internacionales</a></li>
                  <li><a href="#tab_attachments" data-toggle="tab">Archivos Adjuntos</a></li>
                  <li><a href="#tab_password" data-toggle="tab">Clave usuario</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="personal">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h4>Formulario unico de conocimiento de terceros</h4>
                                    </div>
                                    <div class="box-body ">
                                    @stack('conocimiento_terceros')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h4>Persona Natural</h4>
                                    </div>
                                    <div class="box-body ">
                                    @stack('personal')
                                    @stack('phones')
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="financiero">
                        <div class="row">
                            @stack('financieros')
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_peps">
                        <div class="row">
                            @stack('peps')
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_fonds_origin">
                        <div class="row">
                            @stack('fonds_origin')
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_activity_international_operations">
                        <div class="row">
                            @stack('activity_international_operations')
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_attachments">
                        <div class="row">
                            @stack('attachments')
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_password">
                        <div class="row">
                            <div class="col-md-12">
                                <div class='form-group{{ $errors->has("password") ? ' has-error' : '' }}'>
                                    {!! Form::label("password", trans('user::auth.password') ) !!}
                                    <input type="password" name="password" class="form-control"
                                            placeholder="{{ trans('user::auth.password') }}">
                                    {!! $errors->first("password", '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class='form-group{{ $errors->has("confirm_password") ? ' has-error' : '' }}'>
                                    {!! Form::label("password_confirmation", trans('user::auth.password confirmation')) !!}
                                    <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="{{ trans('user::auth.password confirmation') }}">
                                    {!! $errors->first("password_confirmation", '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div class="nav-tabs-custom">
                            @include('partials.form-tab-headers')
                            <div class="tab-content">
                                <?php $i = 0; ?>
                                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                                    <?php $i++; ?>
                                    <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                        @include('iprofile::admin.users.partials.edit-fields', ['lang' => $locale])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Fin de crear los campos --}}
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.iprofile.profiles.index')}}"><i
                            class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>{{trans('iprofile::profiles.form.validate')}}</label>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-groupo">
                                <label>
                                    <input type="checkbox" class="flat-blue jsInherit"
                                           name="validate"
                                           value="{{$user->validate??false}}"
                                           @if(isset($old["validate"]) && $old["validate"]==$user->validate) checked="checked" @endif> {{trans('iprofile::profiles.form.validate User')}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- end nav-tabs-custom --}}

    {!! Form::close() !!}
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
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'b', route: "<?= route('admin.iprofile.profiles.index') ?>"}
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
@endpush
