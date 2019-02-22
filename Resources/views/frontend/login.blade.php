@extends('layouts.master')

@section('title')
    {{ trans('user::auth.login') }} | @parent
@stop

@section('content')
    <div class="container-profile">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-4 col-lg-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-2 mx-auto">
                    <div class="login-logo text-center">
                        <a href="{{ url('/') }}">{{ setting('core::site-name') }}</a>
                    </div>
                    <div class="form-body">
                        <div class="text-center">
                            <h3 style="margin-top: 0px">Login to account</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit!</p>
                        </div>
                        @include('partials.notifications')
                        {!! Form::open(['route' => 'login.post', 'class' => 'form-content']) !!}
                            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                {{ Form::email('email', old('email'),['required','class' => "form-control",'placeholder' => trans('user::auth.email')]) }}
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                {{ Form::password('password',['required','class' => 'form-control','placeholder' => trans('user::auth.password')]) }}
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-button">
                                {{ Form::submit(trans('user::auth.login'),['class'=>'btn btn-primary mr-2']) }}
                                {{ link_to(route('reset'),trans('user::auth.forgot password'),[]) }}
                            </div>
                            <div class="other-links">
                                <p class="mb-0"><small>Or login with</small></p>
                                <a href="{{ url()->route('account.social.auth',['facebook']) }}">
                                    <i class="fa fa-facebook"></i> <span>facebook</span>
                                </a>
                                <a href="{{ url()->route('account.social.auth',['twitter']) }}">
                                    <i class="fa fa-twitter"></i> <span>twitter</span>
                                </a>
                            </div>
                            <div class="page-links">
                                {{ link_to(route('account.register'),trans('user::auth.register'),[]) }}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
