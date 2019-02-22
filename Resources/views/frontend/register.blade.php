@extends('layouts.master')

@section('title')
    {{ trans('user::auth.register') }} | @parent
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
                            <h3 style="margin-top: 0px">Register to account</h3>
                            <p>Lorem ipsum dolor sit amet!</p>
                        </div>
                        @include('partials.notifications')
                        {!! Form::open(['route' => 'account.register.post', 'class' => 'form-content row','autocomplete' => 'off']) !!}
                            <div class="form-group col-12 col-md-6 has-feedback {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                {{ Form::text('first_name', old('first_name'),['required'=>true,'class'=>"form-control",'placeholder' => trans('user::auth.form.first-name')]) }}
                                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group col-12 col-md-6 has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                {{ Form::text('last_name', old('last_name'),['required'=>true,'class'=>"form-control",'placeholder' => trans('user::auth.form.last-name')]) }}
                                {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group col-12 has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                {{ Form::email('email', old('email'),['required'=>true,'class'=>"form-control",'placeholder' => trans('user::auth.email')]) }}
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group col-12 has-feedback {{ $errors->has('tel') ? ' has-error' : '' }}">
                                {{ Form::text('tel', old('tel'),['required'=>true,'class'=>'form-control','placeholder' => trans('user::auth.tel')]) }}
                                {!! $errors->first('tel', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group col-12 has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                {{ Form::password('password',['required'=>true,'class'=>'form-control','placeholder' => trans('user::auth.password')]) }}
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group col-12 has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                {{ Form::password('password_confirmation',['required'=>true,'class'=>'form-control','placeholder' => trans('user::auth.password_confirmation')]) }}
                                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-button col-12">
                                {{ Form::submit(trans('user::auth.register me'),['class'=>'btn btn-primary mr-2']) }}
                                {{ link_to(route('account.login'),trans('user::auth.I already have a membership'),[]) }}
                            </div>
                            <div class="other-links col-12">
                                <p class="mb-0"><small>Or register with</small></p>
                                <a href="#"><i class="fa fa-facebook"></i> <span>facebook</span></a>
                                <a href="#"><i class="fa fa-twitter"></i> <span>twitter</span></a>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
