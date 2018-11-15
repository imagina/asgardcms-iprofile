<div class="row">
    <div class="col-12 col-lg-6">
        {{ Form::normalInput('first_name', trans('user::users.form.first-name'), $errors, $user) }}
    </div>
    <div class="col-12 col-lg-6">
        {{ Form::normalInput('last_name', trans('user::users.form.last-name'), $errors, $user) }}
    </div>
    <div class="col-12 col-lg-6">
        {{ Form::normalInputOfType('email', 'email', trans('user::users.form.email'), $errors, $user, array(
    'disabled' => 'disabled')) }}
    </div>
</div>
<!-- sobre mi -->
<div class='form-group {{ $errors->has("$lang.bio") ? ' has-error' : '' }}'>
    @php $oldBio = isset($profile->translate($lang)->bio) ? $profile->translate($lang)->bio : ''@endphp
    <i class="fa fa-user"></i>
    {!! Form::label("{$lang}[bio]", trans('iprofile::profiles.form.bio')) !!}
    <textarea class="form-control"
              name="{{$lang}}[bio]"
              rows="3"
              value="">
        {!!old("{$lang}.bio",$oldBio) !!}
    </textarea>
    {!! $errors->first("{$lang}.bio", '<span class="help-block">:message</span>') !!}
</div>


<div class="row">
    <!-- telefono -->
    <div class="col-12 col-lg-6">
        <div class='form-group{{ $errors->has("tel") ? ' has-error' : '' }}'>
            <i class="fa fa-phone"></i>
            {!! Form::label("tel", trans('iprofile::profiles.form.tel')) !!}
            {!! Form::number("tel", old("tel",$profile->tel), ['class' => 'form-control tel', 'data-tel' => 'target', 'placeholder' => trans('iprofile::profiles.form.tel')]) !!}
            {!! $errors->first("tel", '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <!-- Dirección-->
    <div class="col-12 col-lg-6">
        <div class='form-group{{ $errors->has("address") ? ' has-error' : '' }}'>
            <i class="fa fa-home"></i>
            {!! Form::label("address", trans('iprofile::profiles.form.address')) !!}
            {!! Form::text("address", old("address",$profile->address), ['class' => 'form-control address', 'data-address' => 'target', 'placeholder' => trans('iprofile::profiles.form.address')]) !!}
            {!! $errors->first("address", '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <!-- Fecha -->
    <div class="col-12 col-lg-6">
        <div class='form-group{{ $errors->has("birthday") ? ' has-error' : '' }}'>
            <i class="fa fa-calendar-check-o"></i>
            {!! Form::label("birthday", trans('iprofile::profiles.form.birthday')) !!}
            {!! Form::text("birthday", old("birthday",$profile->birthday), ['class' => 'form-control birthday', 'data-birthday' => 'target', 'placeholder' => trans('iprofile::profiles.form.birthday')]) !!}
            {!! $errors->first("birthday", '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <!-- PROFESION -->
    <div class="col-12 col-lg-6">
        <div class='form-group{{ $errors->has("education") ? ' has-error' : '' }}'>
            @php
                if(isset($profile->options->education) && !empty($profile->options->education)){
                $oldeducation = $profile->options->education;
                }else{
                $oldeducation=null;
                }
            @endphp
            <i class="fa fa-graduation-cap"></i>
            {!! Form::label("education", trans('iprofile::profiles.form.Education')) !!}
            {!! Form::text("education", old("education",$oldeducation), ['class' => 'form-control education', 'data-education' => 'target', 'placeholder' => trans('iprofile::profiles.form.Education')]) !!}
            {!! $errors->first("education", '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <!-- cedula -->
    @if(config('asgard.iprofile.config.fields_register.identification'))
        <div class="col-12 col-lg-6">
            <div class='form-group{{ $errors->has("identification") ? ' has-error' : '' }}'>
                <i class="fa fa-id-card-o"></i>
                {!! Form::label("identification", trans('iprofile::profiles.form.identification')) !!}
                {!! Form::text("identification", old("identification", $profile->identification), ['class' => 'form-control identification','required' => 'required', 'data-identification' => 'target', 'placeholder' => trans('iprofile::profiles.form.identification')]) !!}
                {!! $errors->first("identification", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    @endif

    <!-- EMPRESAS -->
    @if(isset($profile->business) && !empty($profile->business))
        <div class="col-12 col-lg-6">
            <div class='form-group{{ $errors->has("business") ? ' has-error' : '' }}'>
                <i class="fa fa-handshake-o"></i>
                {!! Form::label("business", trans('iprofile::profiles.form.business')) !!}
                {!! Form::text("business", old("business", $profile->business), ['class' => 'form-control identification', 'required' => 'required' ,'data-business' => 'target', 'placeholder' => trans('iprofile::profiles.form.business')]) !!}
                {!! $errors->first("business", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    @endif
    <!-- NIT DE EMPRESA -->
    @if(isset($profile->nit) && !empty($profile->nit))
        <div class="col-12 col-lg-6">
            <div class='form-group{{ $errors->has("nit") ? ' has-error' : '' }}'>
                <i class="fa fa-icon-legal"></i>
                {!! Form::label("nit", trans('iprofile::profiles.form.nit')) !!}
                {!! Form::text("nit", old("nit", $profile->nit), ['class' => 'form-control identification', 'required' => 'required' ,'data-nit' => 'target', 'placeholder' => trans('iprofile::profiles.form.nit')]) !!}
                {!! $errors->first("nit", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    @endif
</div>


@if (config('asgard.iprofile.config.profile.partials.translatable.create') !== [])
    @foreach (config('asgard.iprofile.config.profile.partials.translatable.create') as $partial)
        @include($partial)
    @endforeach
@endif
