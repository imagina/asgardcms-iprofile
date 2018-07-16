<div class="box-body">
        <div class='form-group{{ $errors->has("{$lang}bio") ? ' has-error' : '' }}'>
            {!! Form::label("{$lang}[bio]", trans('iprofile::profiles.form.bio')) !!}
            <textarea class="ckeditor" name="{{$lang}}[bio]" rows="10" cols="80">
        {!!old("{$lang}.bio") !!}
        </textarea>
            {!! $errors->first("{$lang}.bio", '<span class="help-block">:message</span>') !!}
        </div>
        <div class='form-group{{ $errors->has("tel") ? ' has-error' : '' }}'>
            {!! Form::label("tel", trans('iprofile::profiles.form.tel')) !!}
            {!! Form::text("tel", old("tel"), ['class' => 'form-control tel', 'data-tel' => 'target', 'placeholder' => trans('iprofile::profiles.form.tel')]) !!}
            {!! $errors->first("tel", '<span class="help-block">:message</span>') !!}
        </div>
        <div class='form-group{{ $errors->has("address") ? ' has-error' : '' }}'>
            {!! Form::label("address", trans('iprofile::profiles.form.address')) !!}
            {!! Form::text("address", old("address"), ['class' => 'form-control address', 'data-address' => 'target', 'placeholder' => trans('iprofile::profiles.form.address')]) !!}
            {!! $errors->first("address", '<span class="help-block">:message</span>') !!}
        </div>
        <div class='form-group{{ $errors->has("birthday") ? ' has-error' : '' }}'>
            {!! Form::label("birthday", trans('iprofile::profiles.form.birthday')) !!}
            {!! Form::text("birthdate", old("birthday"), ['class' => 'form-control birthdate', 'data-birthday' => 'target', 'placeholder' => trans('iprofile::profiles.form.birthday')]) !!}
            {!! $errors->first("birthdate", '<span class="help-block">:message</span>') !!}
        </div>
        @if (config('asgard.iprofile.config.profile.partials.translatable.create') !== [])
            @foreach (config('asgard.iprofile.config.profile.partials.translatable.create') as $partial)
                @include($partial)
            @endforeach
        @endif
</div>
