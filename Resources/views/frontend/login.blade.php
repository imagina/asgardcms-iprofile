@extends('layouts.master')

@section('title')
    {{ trans('user::auth.login') }} | @parent
@stop

@section('content')

{{-- Need Publish --}}
<link href="{!! Module::asset('iprofile:css/base.css') !!}" rel="stylesheet" type="text/css" />

    <div class="page page-profile py-5">

    @include("iprofile::frontend.widgets.login")


        {{--
        <div class="container mx-auto text-center my-5">
            {!!ibanner(5,'ibanners.widgets.carousel.banners')!!}
        </div>
        --}}

    </div>
@stop
