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
            <div id="index_profile" class="row profile-default py-5">
                <div class="col-12">
                    @include('partials.notifications')
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3 user-details">
                            <!-- Profile Image -->
                            <div id="image">
                                <div class="bgimg-profile">
                                    @if(isset($profile->options->mainimage)&&!empty($profile->options->mainimage))
                                        <img class="profile-user-img"
                                             src="{{url($profile->options->mainimage)}}?v={{$profile->updated_at}}"/>
                                    @else
                                        <img class="profile-user-img"
                                             src="{{url('modules/iprofile/img/default.jpg')}}"/>
                                    @endif
                                </div>
                            </div>

                            {{--<strong><i class="fa fa-map-marker margin-r-5"></i> --}}{{--{{trans('iprofile::profiles.form.Location')}}--}}{{--
                            </strong>--}}

                            <p class="text-center py-2">
                                <strong>
                                    <i class="fa fa-map-marker margin-r-5">
                                    </i>
                                </strong>

                                @if(isset($profile->city)&& !empty($profile->city))
                                    {{$profile->city}}
                                @else
                                    {{trans('iprofile::profiles.form.Not fount')}}
                                @endif
                                @if(isset($profile->state)&& !empty($profile->state))
                                    {{$profile->state}}
                                @endif
                            </p>


                            <div class="row">
                                @include('iprofile::frontend.partials.profile-list',['menu'=> 0])
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-md-9 user-courses">


                            <div class="card text-center">
                                <div class="card-header border-0 bg-secondary">
                                    <div class="card-header border-0 bg-transparent">
                                        <h3 class="text-white">
                                            <?php if ($user->present()->fullname() != ' '): ?>
                                        <?= $user->present()->fullName(); ?>
                                        <?php else: ?>
                                            <em>{{trans('core::core.general.complete your profile')}}.</em>
                                            <?php endif; ?>
                                        </h3>

                                    </div>
                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a
                                                    class="nav-link active"
                                                    id="info-tab"
                                                    data-toggle="tab"
                                                    href="#info"
                                                    role="tab"
                                                    aria-controls="info"
                                                    aria-selected="true">
                                                {{trans('iprofile::profiles.title.info')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a
                                                    class="nav-link"
                                                    id="account-tab"
                                                    data-toggle="tab"
                                                    href="#account"
                                                    role="tab"
                                                    aria-controls="account"
                                                    aria-selected="false">
                                                {{trans('iprofile::profiles.title.Account')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a
                                                    class="nav-link"
                                                    id="address-tab"
                                                    data-toggle="tab"
                                                    href="#address"
                                                    role="tab"
                                                    aria-controls="address"
                                                    aria-selected="false">
                                                {{trans('iprofile::profiles.form.address')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a
                                                    class="nav-link"
                                                    id="social-tab"
                                                    data-toggle="tab"
                                                    href="#social"
                                                    role="tab"
                                                    aria-controls="social"
                                                    aria-selected="false">
                                                {{trans('iprofile::profiles.title.social')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                        <h4>{{trans('iprofile::profiles.title.information')}}</h4>
                                        <table class="table table-user-information">
                                            <tbody>
                                            <tr>
                                                <th>
                                                    {{trans('iprofile::profiles.form.profession')}}:
                                                </th>
                                                <td>
                                                    {{$user->roles->first()->name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {{trans('iprofile::profiles.form.Education')}}:
                                                </th>
                                                <td>
                                                    @if(isset($profile->options->education)&& !empty($profile->options->education))
                                                        {{$profile->options->education}}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {{trans('iprofile::profiles.form.bio')}}:
                                                </th>
                                                <td>
                                                    @if(isset($profile->bio)&& !empty($profile->bio))
                                                        {!!$profile->bio!!}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif

                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    {{trans('iprofile::profiles.form.birthday')}}:
                                                </th>
                                                <td>
                                                    @if(isset($profile->birthday)&& !empty($profile->birthday))
                                                        {{$profile->birthday}}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {{trans('iprofile::profiles.form.tel')}}:
                                                </th>
                                                <td>
                                                    @if(isset($profile->tel)&& !empty($profile->tel))
                                                        {{$profile->tel}}
                                                    @else
                                                        {{trans('iprofile::profiles.form.Not fount')}}
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                                        <h4 >{{trans('iprofile::profiles.title.Account')}}</h4>
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th>
                                                    {{trans('user::users.form.first-name')}}:
                                                </th>
                                                <td>
                                                    {{$user->first_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {{trans('user::users.form.last-name')}}:
                                                </th>
                                                <td>
                                                    {{$user->last_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {{ trans('user::users.form.email') }}:
                                                </th>
                                                <td>
                                                    {{$user->email}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <h4 >{{trans('iprofile::profiles.title.addresses')}}</h4>
                                        <table class="table">
                                            <tbody>
                                            <tr v-for="(address,index) in addresses">
                                                <th>@{{ address.firstname  }} @{{ address.lastname  }}, @{{ address.address_1  }},@{{ address.city  }},@{{ address.zone  }},@{{ address.country  }}
                                                    <span v-if="addresses[index].type!=''" class="badge bg-primary text-white">{{trans('iprofile::addresses.default')}} @{{addresses[index].type}}</span>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                        <h4 >{{trans('iprofile::profiles.form.social_networks')}}</h4>
                                        <table class="table">
                                            @if(isset($profile->social)&& !empty($profile->social))
                                                @foreach($profile->social as $item)
                                                    <tr>
                                                        <th><i class="fa {{$item->label}}"></i></th>
                                                        <td>{{$item->desc}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>{{trans('iprofile::profiles.form.Not fount')}}</tr>
                                            @endif
                                        </table>



                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>

    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script type="text/javascript">
        const profileIndex =  new Vue({
            el: '#index_profile',
            created: function () {
                console.log(this.addresses);
                console.log(this.addressesEncoded);
            },
            data: {
                addresses: {!! $addresses ? $addresses : "''"!!},
                addressesEncoded: {!! $addressesEncoded ? $addressesEncoded : "''"!!},
                hide: true
            }
        });
    </script>
@stop

