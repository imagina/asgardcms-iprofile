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
      
            </div>
        @endif

    @includeFirst(["iprofile.widgets.register","iprofile::frontend.widgets.register"])


        {{--
        <div class="container mx-auto text-center my-5">
            {!!ibanner(5,'ibanners.widgets.carousel.banners')!!}
        </div>
        --}}


    </div>


@stop