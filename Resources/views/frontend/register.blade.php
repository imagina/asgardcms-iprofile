@extends('layouts.master')

@section('title')
    {{ trans('user::auth.register') }} | @parent
@stop

@section('content')

{{-- Need Publish --}}
<link href="{!! Module::asset('iprofile:css/base.css') !!}" rel="stylesheet" type="text/css" />

    <div class="page page-profile">

        @if(View::exists('partials.widgets.menu-categories'))
            @include('partials.widgets.menu-categories')
        @endif

        @if(View::exists('iprofile::frontend.widgets.breadcrumb'))
            <div class="banner mb-5" style="background-image: url(/modules/iprofile/img/banner-register.jpg)">
                @component('iprofile::frontend.widgets.breadcrumb')
                    <li class="breadcrumb-item active"
                        aria-current="page">{{trans('iprofile::frontend.form.register to account')}}</li>
                @endcomponent
            </div>
        @endif

        <div class="container">
            <div class="row ">
                <div class="col-12 mb-5">

                    <div class="title">
                        <h1 class="text-primary">{{ trans('user::auth.register') }} </h1>
                    </div>
                    <div class="border-top title border-bottom border-top-dotted border-bottom-dotted py-4 mt-4 mb-4">
                        <p>{{trans('iprofile::frontend.title.social msj register')}}</p>
                        <div class="d-inline-block mr-3 mb-3">
                            <a href="{{route('account.social.auth',['facebook'])}}"><img class="img-fluid" src="{{url('modules/iprofile/img/facebook.png')}}" alt="Facebook"></a>
                            {{--
                            <a href="{{route('account.social.auth',['facebook'])}}"><img class="img-fluid" src="{{ Theme::url('img/facebook.png') }}" alt="Facebook"></a>
                            --}}
                        </div>
                        <div class="d-inline-block">
                            <a href="{{route('account.social.auth',['google'])}}"><img class="img-fluid" src="{{url('modules/iprofile/img/google.png')}}" alt="Google"></a>
                            {{--
                            <a href="{{route('account.social.auth',['google'])}}"><img class="img-fluid" src="{{ Theme::url('img/google.png') }}" alt="Google"></a>
                            --}}
                        </div>
                    </div>

                    <div class="">
                        <p class="mb-4">{{trans('iprofile::frontend.title.social msj register 2')}}</p>
                    </div>

                    @include('partials.notifications')

                    <hr class="border-top-dotted">

                    {!! Form::open(['route' => 'account.register.post', 'class' => 'form-content','autocomplete' => 'off']) !!}

                    <div class="px-2 px-sm-0">
                        <div class="row">

                            <div class="col-sm-12 col-md-6 py-2 has-feedback {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label>{{trans('user::users.form.first-name')}}</label>
                                {{ Form::text('first_name', old('first_name'),['required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                                {!! $errors->first('first_name', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="col-sm-12 col-md-6 py-2 has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label>{{trans('user::users.form.last-name')}}</label>
                                {{ Form::text('last_name', old('last_name'),['required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                                {!! $errors->first('last_name', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="col-sm-12 col-md-6 py-2 has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>Email</label>
                                {{ Form::email('email', old('email'),['required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            {{-- Example for diferent roles--}}
                            {{--
                            <div class="col-sm-12 col-md-6 py-2">
                                <label>{{trans('iprofile::frontend.form.reason')}}</label>
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                   id="customvender" name="roles[]" value="client" required>
                                            <label class="custom-control-label" for="customvender">Quiero Vender</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                   id="customcomprar" name="roles[]" value="user" required>
                                            <label class="custom-control-label" for="customcomprar">Quiero
                                                Comprar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            --}}

                            <div class="col-sm-12 col-md-6 py-2 has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>{{trans('user::users.form.password')}}</label>
                                {{ Form::password('password',['required'=>true,'class'=>'form-control','placeholder' => '...']) }}
                                {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="col-sm-12 col-md-6 py-2 has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label>{{trans('iprofile::frontend.title.password confirmation')}}</label>
                                {{ Form::password('password_confirmation',['required'=>true,'class'=>'form-control','placeholder' => '...']) }}
                                {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                        </div>

                        <hr class="border-top-dotted my-4">

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                {{--
                                <div class="custom-control custom-radio red mb-3">
                                    <input type="radio" class="custom-control-input"
                                           id="customradio-select1" name="policies" value="1" required>
                                    <label class="custom-control-label" for="customradio-select1">Declaro
                                        conocer las políticas de Términos y Condiciones y autorizo el
                                        tratamiento de mis datos personales en la <span class="text-primary">Revista Tu Barrio</span></label>
                                </div>
                                --}}
                                <div class="custom-control custom-radio red mb-3">
                                    <input type="radio" class="custom-control-input"
                                           id="customradio-select2" name="remember_me">
                                    <label class="custom-control-label" for="customradio-select2">
                                        {{trans('iprofile::frontend.title.stay connect')}}
                                    </label>
                                </div>


                            </div>
                            <div class="col-sm-12 col-md-6 pt-4 pt-lg-0">
                                <input class="btn btn-primary text-white text-uppercase font-weight-bold rounded-pill px-3 py-2"
                                       type="submit" value="{{ trans('core::core.button.create') }}">
                            </div>
                        </div>

                    </div>

                    {!! Form::close() !!}


                </div>

            </div>
        </div>

        {{--
        <div class="container mx-auto text-center my-5">
            {!!ibanner(5,'ibanners.widgets.carousel.banners')!!}
        </div>
        --}}


    </div>


@stop