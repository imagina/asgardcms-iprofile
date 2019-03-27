@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('iprofile::userfields.title.create userfield') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li>
            <a href="{{ route('admin.iprofile.profiles.index') }}">{{ trans('iprofile::userfields.title.userfields') }}</a>
        </li>
        <li class="active">{{ trans('iprofile::userfields.title.create userfield') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        {!! Form::open(['route' => ['admin.iprofile.profiles.store'], 'method' => 'post']) !!}
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
                                        @include('iprofile::admin.users.partials.create-fields', ['lang' => $locale])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                        </div>
                        <div class="box-body ">
                            <div class='form-group{{ $errors->has("first_name") ? ' has-error' : '' }}'>
                                {!! Form::label("first_name", trans('iprofile::profile.form.first_name')) !!}
                                {!! Form::text("first_name", old("first_name"), ['class' => 'form-control', 'placeholder' => trans('iprofile::profile.form.first_name')]) !!}
                                {!! $errors->first("first_name", '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class='form-group{{ $errors->has("last_name") ? ' has-error' : '' }}'>
                                {!! Form::label("last_name", trans('iprofile::profile.form.last_name')) !!}
                                {!! Form::text("last_name", old("last_name"), ['class' => 'form-control', 'placeholder' => trans('iprofile::profile.form.last_name')]) !!}
                                {!! $errors->first("last_name", '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class='form-group{{ $errors->has("email") ? ' has-error' : '' }}'>
                                {!! Form::label("email", trans('user::auth.email') ) !!}
                                {!! Form::text("email", old("email"), ['class' => 'form-control', 'placeholder' => trans('iprofile::profile.form.email')]) !!}
                                {!! $errors->first("email", '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class='form-group{{ $errors->has("password") ? ' has-error' : '' }}'>
                                {!! Form::label("password", trans('user::auth.password') ) !!}
                                <input type="password" name="password" class="form-control" placeholder="{{ trans('user::auth.password') }}">
                                {!! $errors->first("password", '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class='form-group{{ $errors->has("confirm_password") ? ' has-error' : '' }}'>
                                {!! Form::label("password_confirmation", trans('user::auth.password confirmation')) !!}
                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('user::auth.password confirmation') }}">
                                {!! $errors->first("password_confirmation", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                  <div class="box box-primary">
                    <div class="box-header">
                    </div>
                    <div class="box-body ">
                      <div class='form-group{{ $errors->has("birthdate") ? ' has-error' : '' }}'>
                        {!! Form::label("birthdate", trans('iprofile::profile.form.birthdate')) !!}
                        {!! Form::text("birthdate", old("birthdate"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iprofile::profile.form.birthdate')]) !!}
                        {!! $errors->first("birthdate", '<span class="help-block">:message</span>') !!}
                      </div>
                      <div class='form-group{{ $errors->has("cel") ? ' has-error' : '' }}'>
                        {!! Form::label("cel", trans('iprofile::profile.form.cel')) !!}
                        {!! Form::text("cel", old("cel"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('iprofile::profile.form.cel')]) !!}
                        {!! $errors->first("cel", '<span class="help-block">:message</span>') !!}
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                        </div>
                        <div class="box-body ">
                            <div class="box-footer">
                                <button type="submit"
                                        class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                                <a class="btn btn-danger pull-right btn-flat"
                                   href="{{ route('admin.iprofile.profiles.index')}}"><i
                                            class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <label>{{trans('iprofile::variables.form.variables')}}</label>
                            </div>
                        </div>
                        <div class="box-body">

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>{{trans('iprofile::profile.form.password')}}</label>
                            </div>
                        </div>
                        <div class="box-body">

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>{{trans('iprofile::profile.form.address')}}</label>
                            </div>
                            <div class="box-body">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{-- end nav-tabs-custom --}}
        </div>
    </div>
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
