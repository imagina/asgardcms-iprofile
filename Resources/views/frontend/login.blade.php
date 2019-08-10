@extends('layouts.master')

@section('title')
    {{ trans('user::auth.login') }} | @parent
@stop

@section('content')

{{-- Need Publish --}}
<link href="{!! Module::asset('iprofile:css/base.css') !!}" rel="stylesheet" type="text/css" />

    <div class="page page-profile py-5">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">

                    <div class="title">
                        <h1 class="text-primary">{{ trans('user::auth.login') }}</h1>
                    </div>
                    <div class="border-top title border-bottom border-top-dotted border-bottom-dotted py-4 mt-4 mb-4">
                        <p>{{trans('iprofile::frontend.title.social msj')}}</p>
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
                    <hr class="border-top-dotted">

                    <div class="form-body">
                        @include('partials.notifications')
                        {!! Form::open(['route' => 'login.post', 'class' => 'form-content']) !!}

                        <div class="row">
                            <div class="col-sm-12 py-2">
                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label>{{trans('user::auth.email')}}</label>
                                    {{ Form::email('email', old('email'),['required','class' => "form-control",'placeholder' => trans('user::auth.email')]) }}
                                    {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="col-sm-12 py-2">
                                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>{{trans('user::auth.password')}}</label>
                                    {{ Form::password('password',['required','class' => 'form-control','placeholder' => trans('user::auth.password')]) }}
                                    {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>

                        <div class=" form-button text-center  border-bottom  border-bottom-dotted py-4 mb-4">
                            {{ Form::submit(trans('user::auth.login'),['class'=>'btn btn-primary text-uppercase text-white font-weight-bold rounded-pill px-3 py-2 mr-2']) }}
                            {{ link_to(route('account.reset'),trans('user::auth.forgot password'),[]) }}
                        </div>

                        <div class="page-links mt-4 text-center">
                            {{ link_to(route('account.register'),trans('user::auth.register'),[]) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
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
