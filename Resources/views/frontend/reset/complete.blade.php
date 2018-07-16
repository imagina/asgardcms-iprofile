@extends('layouts.master')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')


    <div class="iprofile iprofile-reset iprofile-border">
        <div class="container">

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">

                    <div class="bloque-reset">

                        <div class="login-box-body">

                            <span class="title">{{trans('iprofile::profiles.messages.reset_password')}}</span>

                            <div class="formulario">

                                <p class="login-box-msg">{{ trans('user::auth.reset password') }}</p>
                                @include('partials.notifications')

                                {!! Form::open() !!}
                                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="">{{ trans('user::auth.password') }}</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" autofocus
                                                   name="password" required>
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="">{{ trans('user::auth.password confirmation') }}</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="password" name="password_confirmation" class="form-control" required>
                                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-primary btn-flat pull-right">
                                            {{ trans('user::auth.reset password') }}
                                        </button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>

            <hr>
        </div>
    </div>
@stop
