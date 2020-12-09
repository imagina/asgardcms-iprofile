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

    <!--TODO: crear un setting para administrar un banner en la cabecera del register-->
    @includeFirst(["iprofile.widgets.register","iprofile::frontend.widgets.register"])


    </div>


@stop