@extends('layouts.master')
@section('title')
    {{ trans('user::auth.register') }} | @parent
@stop

@section('content')
    <div class="iprofile iprofile-login iprofile-border">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-5 col-lg-4 bloque-login py-5">

                    <h2 class="text-center p-3">
                        <i class="fa fa-user-plus"></i>
                        {{trans('iprofile::profiles.title.create account')}}
                    </h2>

                    <!--  FACEBOOK  -->
                    <!-- <div class="omb_socialButtons text-center">
                        <a href="{{url()->route('account.social.auth',['facebook'])}}"
                           class="btn btn-lg
                                  omb_btn-facebook">
                            <i class="fa fa-facebook visible-xs"></i>
                            <span class="hidden-xs">Registrarme con Facebook</span>
                        </a>
                    </div> -->

                    <hr>

                    <!-- FORMULARIO -->
                    <div class="container formulario">
                        @include('partials.notifications')
                        {!! Form::open(['route' => 'account.register.post']) !!}

                        <!-- NOMBRE -->
                        <div class="form-group has-feedback{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <i class="fa fa-user"></i>
                            {!! Form::label('first_name', trans('user::users.form.first-name').' *') !!}
                            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control','required' => 'required']) !!}
                            {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        </div>

                        <!-- APELLIDO -->
                        <div class="form-group has-feedback{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <i class="fa fa-users"></i>
                            {!! Form::label('last_name', trans('user::users.form.last-name').' *') !!}
                            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control','required' => 'required']) !!}
                            {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        </div>

                        <!-- TELEFONO -->
                        <div class="form-group has-feedback{{ $errors->has('tel') ? ' has-error' : '' }}">
                            <i class="fa fa-phone"></i>
                            {!! Form::label('tel', trans('iprofile::profiles.form.tel').' *') !!}
                            {!! Form::text('tel', old('tel'), ['class' => 'form-control','required' => 'required']) !!}
                            {!! $errors->first('tel', '<span class="help-block">:message</span>') !!}
                        </div>


                        <!-- EMPRESA -->
                        @if(config('asgard.iprofile.config.fields_register.business'))
                            <div class="form-group has-feedback">
                                {!! Form::checkbox('business_check', 0 , false,array('id'=>'business_check')) !!}
                                {!! Form::label('business_check','Registrar la cuenta a nombre de persona juridica') !!}
                            </div>

                            <div id="block_business"
                                 style="display: none;"
                                 class="form-group has-feedback{{ $errors->has('business') ? ' has-error' : '' }}">
                                <i class="fa fa-building"></i>
                                    {!! Form::label('business', 'Empresa') !!}
                                    {!! Form::text('business', old('business'), ['class' => 'form-control']) !!}
                                    {!! $errors->first('business', '<span class="help-block">:message</span>') !!}
                            </div>
                        @endif

                        <!-- EMAIL -->
                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
                            <i class="fa fa-envelope"></i>
                            <label for="">
                                {{ trans('user::auth.email') }}
                            </label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email') }}"
                                   required>
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>

                        <!-- PASS -->
                        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
                            <i class="fa fa-lock"></i>
                            <label for="">
                                {{ trans('user::auth.password') }}
                            </label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        </div>

                        <!-- CONFIR pass -->
                        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error has-feedback' : '' }}">
                            <i class="fa fa-lock"></i>
                            <label for="">
                                {{ trans('user::auth.password confirmation') }}
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control" required>
                            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                        </div>

                        <!-- BOTON REGISTRAR -->
                        <div class="p-0">
                            <button type="submit"
                                    class="btn btn-primary btn-flat">
                                {{ trans('user::auth.register me') }}
                            </button>
                        </div>
                        {!! Form::close() !!}

                    <!-- INICIAR SESION -->
                        <div>
                            <hr>
                            <div class="featured-contests-block-right
                                        float-right text-primary">
                                <b>
                                    <i class="fa fa-user"></i>
                                    <a href="{{ route('account.login') }}"
                                       class="text-center">{{ trans('user::auth.I already have a membership') }}</a>
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
@parent
<script type="text/javascript">
    
    jQuery(document).ready(function($) {

        $('#business_check').on('change', function() {
            if ($(this).is(':checked') ) {
               $('#block_business').show();
            } else {
                $('#business').val("");
               $('#block_business').hide();
            }
        });

    });

</script>    

@stop