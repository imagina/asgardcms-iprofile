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

                            <span class="title">Reiniciar contraseña</span>

                            <div class="formulario">
                                <p class="login-box-msg">{{ trans('user::auth.to reset password complete this form') }}</p>
                                @include('partials.notifications')

                                {!! Form::open(['route' => 'account.reset.post']) !!}
                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="email">{{ trans('user::auth.email') }}</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" autofocus
                                                   name="email" value="{{ old('email')}}" required>
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="submit" class="btn btn-success  btn-flat pull-right">
                                            {{ trans('user::auth.reset password') }}
                                        </button>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                                <hr>
                                <p class="text-center">
                                    <a href="{{ route('account.login') }}"
                                       class="text-center">{{ trans('user::auth.I remembered my password') }}</a>
                                </p>
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
