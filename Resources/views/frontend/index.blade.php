@extends('layouts.master')

@section('content-header')
    <h1>{{trans('iprofile::profiles.title.create profile') }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('account.profile.edit') }}">{{ trans('iprofile::profiles.title.profiles') }}</a>
        </li>
        <li class="active">{{ trans('iprofile::profiles.title.create profile') }}</li>
    </ol>
@stop

@section('content')
    <div class="bg-breadcrumb"></div>

    <div class="bg-content">
        <div class="container">
            <div class="row profile-default">
                <div class="col-md-12">
                    <div class="col-xs-12">
                        <div class="row">

                            <div class="col-md-3 user-details">

                                <!-- Profile Image -->
                                <div id="image">
                                    <div class="bgimg-profile">
                                        @if(isset($profile->options->mainimage)&&!empty($profile->options->mainimage))
                                            <img class="profile-user-img"
                                                 src="{{url($profile->options->mainimage)}}?v={{$profile->updated_at}}"/>
                                        @else
                                            <img class="profile-user-img" src="{{url('modules/iprofile/img/default.jpg')}}"/>
                                        @endif
                                    </div>
                                </div>

                                {{--<strong><i class="fa fa-map-marker margin-r-5"></i> --}}{{--{{trans('iprofile::profiles.form.Location')}}--}}{{--
                                </strong>--}}

                                <p class="text-center">
                                    <strong><i class="fa fa-map-marker margin-r-5"></i></strong>

                                    @if(isset($profile->city)&& !empty($profile->city))
                                        {{$profile->city}}
                                    @else
                                        {{trans('iprofile::profiles.form.Not fount')}}
                                    @if(isset($profile->state)&& !empty($profile->state))
                                        ,{{$profile->state}}
                                    @endif
                                </p>

                                <a href="{{URL::route('account.profile.edit')}}" class="btn-custom">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    <strong>Editar Perfil</strong>
                                </a>
                                {{--
                                <ul class="social-networks">
                                    @if(isset($profile->social)&& !empty($profile->social))
                                        @foreach($profile->social as $i=>$item)
                                            <li>
                                                <a class="btn btn-social-icon btn-{{$item->icono}}" href="{{$item->link}}">
                                                    <i class="fa fa-{{$item->icono}}"></i>
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <p>{{trans('iprofile::profiles.form.Not fount')}}</p>
                                    @endif
                                </ul>
                                --}}

                                <hr>

                                <!-- About Me Box -->
                                <div class="box box-primary user-info">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">{{trans('iprofile::profiles.form.About Me')}}</h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <h5 class="user-info-title">
                                            <strong><i class="fa fa-book margin-r-5"></i>{{trans('iprofile::profiles.form.Education')}}</strong>
                                        </h5>

                                        <p class="text-muted">
                                            @if(isset($profile->options->education)&& !empty($profile->options->education))
                                                {{$profile->options->education}}
                                            @else
                                                {{trans('iprofile::profiles.form.Not fount')}}
                                            @endif
                                        </p>

                                        <h5 class="user-info-title">
                                            <strong><i class="fa fa-file-text-o margin-r-5"></i>{{trans('iprofile::profiles.form.bio')}}</strong>
                                        </h5>

                                        @if(isset($profile->bio)&& !empty($profile->bio))
                                            {!!$profile->bio!!}
                                        @else
                                            <p>{{trans('iprofile::profiles.form.Not fount')}}</p>
                                        @endif
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-md-9 user-courses">

                                <h3 class="profile-username">
                                    <?php if ($user->present()->fullname() != ' '): ?>
                                    <?= $user->present()->fullName(); ?>
                                    <?php else: ?>
                                    <em>{{trans('core::core.general.complete your profile')}}.</em>
                                    <?php endif; ?>
                                </h3>

                                <p class="text-muted user-profession">{{$user->roles->first()->name}}</p>

                                @include("ivehicle.userVehicles")

                                @include("ibooking.userReservations")

                                <!-- /.nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
