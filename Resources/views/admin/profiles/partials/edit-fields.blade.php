<div>
    <div class="col-md-4">
        {{ Form::normalInput('first_name', trans('user::users.form.first-name'), $errors, $user) }}
    </div>
    <div class="col-md-4">
        {{ Form::normalInput('last_name', trans('user::users.form.last-name'), $errors, $user) }}
    </div>
    <div class="col-md-4">
        {{ Form::normalInputOfType('email', 'email', trans('user::users.form.email'), $errors, $user) }}
    </div>
    <div class="col-xs-12">
        <div class='form-group{{ $errors->has("$lang.bio") ? ' has-error' : '' }}'>
            @php $oldBio = isset($profile->translate($lang)->bio) ? $profile->translate($lang)->bio : ''@endphp
            {!! Form::label("{$lang}[bio]", trans('iprofile::profiles.form.bio')) !!}
            <textarea class="ckeditor" name="{{$lang}}[bio]" rows="3" cols="80">
                {!!old("{$lang}.bio",$oldBio) !!}
             </textarea>
            {!! $errors->first("{$lang}.bio", '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="col-xs-12">
        <div class='form-group{{ $errors->has("address") ? ' has-error' : '' }}'>
            {!! Form::label("address", trans('iprofile::profiles.form.address')) !!}
            {!! Form::text("address", old("address",$profile->address), ['class' => 'form-control address', 'data-address' => 'target', 'placeholder' => trans('iprofile::profiles.form.address')]) !!}
            {!! $errors->first("address", '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class='form-group{{ $errors->has("tel") ? ' has-error' : '' }}'>
            {!! Form::label("tel", trans('iprofile::profiles.form.tel')) !!}
            {!! Form::text("tel", old("tel",$profile->tel), ['class' => 'form-control tel', 'data-tel' => 'target', 'placeholder' => trans('iprofile::profiles.form.tel')]) !!}
            {!! $errors->first("tel", '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class='form-group{{ $errors->has("birthday") ? ' has-error' : '' }}'>
            {!! Form::label("birthday", trans('iprofile::profiles.form.birthday')) !!}
            {!! Form::text("birthday", old("birthday",$profile->birthday), ['class' => 'form-control birthday', 'data-birthday' => 'target', 'placeholder' => trans('iprofile::profiles.form.birthday')]) !!}
            {!! $errors->first("birthday", '<span class="help-block">:message</span>') !!}
        </div>
    </div>

    @if (config('asgard.iprofile.config.profile.partials.translatable.create') !== [])
        @foreach (config('asgard.iprofile.config.profile.partials.translatable.create') as $partial)
            @include($partial)
        @endforeach
    @endif
</div>
