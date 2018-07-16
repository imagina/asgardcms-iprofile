@extends('layouts.master')

@section('title')
    {{ trans('user::auth.reset password') }} | @parent
@stop

@section('content')
    <div class="iprofile iprofile-login iprofile-border">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-5 col-lg-4 bloque-login py-5">

                    <h2 class="text-center p-3">
                        <i class="fa fa-lock"></i>
                        {{ trans('user::auth.reset password') }}
                    </h2>
                    <hr>

                    <div class="container formulario">
                        <p class="login-box-msg">{{ trans('user::auth.to reset password complete this form') }}</p>
                        @include('partials.notifications')

                        {!! Form::open(['route' => 'account.reset.post']) !!}
                            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <i class="fa fa-at"></i>
                                <label for="email">
                                    {{ trans('user::auth.email') }}
                                </label>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       value="{{ old('email')}}"
                                       required>
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>

                            <!-- BOTON -->
                            <button type="submit"
                                    class=" btn btn-primary
                                            btn-flat">
                                {{ trans('user::auth.reset password') }}
                            </button>
                        {!! Form::close() !!}

                        <!-- RECORDE CONTRASEÑA -->
                        <div>
                            <hr>
                            <div class="featured-contests-block-right
                                        float-right text-primary">
                                <b>
                                    <i class="fa fa-user"></i>
                                    <a href="{{ route('account.login') }}"
                                       class="text-center">{{ trans('user::auth.I remembered my password') }}</a>
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
