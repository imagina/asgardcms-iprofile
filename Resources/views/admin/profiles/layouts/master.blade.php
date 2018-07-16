@extends('layouts.master')

@section('content-header')
    <h1>{{trans('iprofile::profiles.title.create profile') }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.account.profile.edit') }}">{{ trans('iprofile::profiles.title.profiles') }}</a>
        </li>
        <li class="active">{{ trans('iprofile::profiles.title.create profile') }}</li>
    </ol>
@stop



@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop
