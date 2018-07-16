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
                            id="shipBill-tab"
                            data-toggle="tab"
                            href="#shipBill"
                            role="tab"
                            aria-controls="shipBill"
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

                <div class="row">

                    <!-- Campos Formularios -->
                    <div class="col-12">

                        @php $locale = LaravelLocalization::setLocale() ?: App::getLocale();@endphp


                        @include('iprofile::frontend.partials.edit-fields', ['lang' => $locale])

                    </div>
                </div>

                <!-- BOTONES -->
                <div class="box-footer float-right">
                    <button type="submit"
                            class="btn btn-primary btn-flat">
                        {{trans('iprofile::profiles.button.update profile')}}
                    </button>
                </div>

            </div>
            <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                <h4 >{{trans('iprofile::profiles.title.Account')}}</h4>
                {!! Form::open(['route' => ['iprofile.user.update'], 'method' => 'put']) !!}
                <div class="row">
                    <div class="col-md-12">

                        <h5>
                            {{ trans('user::users.new password setup') }}
                        </h5>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                {{ Form::normalInputOfType('password', 'password', trans('user::users.form.new password'), $errors) }}
                            </div>
                            <div class="col-12 col-lg-6">
                                {{ Form::normalInputOfType('password', 'password_confirmation', trans('user::users.form.new password confirmation'), $errors) }}
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit"
                                    class="btn btn-primary btn-flat">
                                {{ trans('core::core.button.update') }}
                            </button>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}

            </div>
            <div class="tab-pane fade" id="shipBill" role="tabpanel" aria-labelledby="shipBill-tab">
                <div class="row">
                    @include('iprofile::frontend.partials.edit-address', ['lang' => $locale])
                </div>
            </div>
            <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                <h4>{{trans('iprofile::profiles.title.social')}}</h4>

                <div class="row">


                    <!-- Campos Formularios -->
                    <div class="col-12">

                        @php $locale = LaravelLocalization::setLocale() ?: App::getLocale();@endphp


                        @include('iprofile::frontend.partials.edit-social-networks', ['lang' => $locale])

                    </div>
                </div>

                <!-- BOTONES -->
                <div class="box-footer float-right">
                    <button type="submit"
                            class="btn btn-primary btn-flat">
                        {{trans('iprofile::profiles.button.update profile')}}
                    </button>
                </div>
            </div>

        </div>
    </div>


</div>