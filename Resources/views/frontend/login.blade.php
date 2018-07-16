@extends('layouts.master')

@section('title')
    {{ trans('user::auth.login') }} | @parent
@stop

@section('content')
    <div class="iprofile iprofile-login iprofile-border">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-5 col-lg-4 bloque-login py-5">


                    <h2 class="text-center mt-3 mb-0">
                        {{trans('iprofile::profiles.title.login')}}
                    </h2>

                    <!--  FACEBOOK
                    <div class="omb_socialButtons text-center mt-3">
                        <a href="{{url()->route('account.social.auth',['facebook'])}}"
                           class="btn btn-lg
                                  omb_btn-facebook
                                  text-white">
                           <i class="fa fa-facebook visible-xs"></i>
                           <span class="hidden-xs">Ingresar con Facebook</span>
                        </a>
                    </div>-->

                    <hr>

                    <!-- FORMULARIO -->
                    <div class="container formulario">
                        @include('partials.notifications')
                        {!! Form::open(['route' => 'login.post']) !!}
                            <!-- email -->
                            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label for="email">
                                        <i class="fa fa-at"></i>
                                        {{ trans('user::auth.email') }}
                                    </label>
                                    <input type="email"
                                           class="form-control"
                                           name="email"
                                           value="{{ old('email')}}"
                                           required>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <!-- pass -->
                            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label for="">
                                        <i class="fa fa-lock"></i>
                                        {{ trans('user::auth.password') }}
                                    </label>
                                    <input type="password"
                                           class="form-control"
                                           name="password"
                                           value="{{ old('password')}}"
                                           required>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}

                                </div>
                            </div>

                            <!-- remember account -->
                            <div class="row">
                                <div class="col-6 p-0 text-left">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember_me">
                                                {{ trans('user::auth.remember me') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 p-0 text-right">
                                    <button type="submit"
                                            class="btn btn-primary btn-block btn-flat">
                                        {{ trans('user::auth.login') }}
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}

                        <!-- RECUPERAR CONTRASEÑA -->
                        <hr>
                        <div class="col-12">
                            <p class="text-center">
                                <a href="{{ route('account.reset')}}">
                                    {{ trans('user::auth.forgot password') }}
                                </a>
                            </p>
                        </div>


                        <!-- CREAR CUENTA -->
                        @if (config('asgard.user.config.allow_user_registration'))
                            <div>
                                <hr>
                                <div class="featured-contests-block-right
                                            float-right text-primary">
                                    <b>
                                        <i class="fa fa-key"></i>
                                        <a  href="{{ route('account.register')}}"
                                            class="text-center">{{ trans('user::auth.register')}}</a>
                                    </b>
                                </div>
                            </div>
                        @endif


                        <!--
                            <div class="links-extras">
                                <hr>
                                <div class="col-xs-12 col-sm-6">
                                    <p class="text-left">
                                        <a href="{{ route('account.reset')}}">{{ trans('user::auth.forgot password') }}</a>
                                    </p>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <p class="text-right">
                                        @if (config('asgard.user.config.allow_user_registration'))
                                            <a href="{{ route('account.register')}}"
                                               class="text-center">{{ trans('user::auth.register')}}</a>
                                        @endif
                                    </p>
                                </div>
                            </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop