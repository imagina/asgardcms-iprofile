

<div class="container">
    <div class="row ">
        <div class="col-12 mb-5">
            
            @if(!isset($embedded))
                <div class="title">
                    <h1 class="text-primary">{{ trans('user::auth.register') }} </h1>
                </div>
            @endif
            
            @if(setting("iprofile::registerUsersWithSocialNetworks"))
                <div class="border-top title border-bottom border-top-dotted border-bottom-dotted py-4 {{isset($embedded) ? '' : 'mt-4'}} mb-4">
                    <p>{{trans('iprofile::frontend.title.social msj register')}}</p>
                    <div class="d-inline-block mr-3 mb-3">
                        <a href="{{route('account.social.auth',['facebook'])}}"><img class="img-fluid" src="{{url('modules/iprofile/img/facebook.png')}}" alt="Facebook"></a>
                    
                    </div>
                    <div class="d-inline-block">
                        <a href="{{route('account.social.auth',['google'])}}"><img class="img-fluid" src="{{url('modules/iprofile/img/google.png')}}" alt="Google"></a>
                    
                    </div>
                </div>
                
                <div class="">
                    <p class="mb-4">{{trans('iprofile::frontend.title.social msj register 2')}}</p>
                </div>
            @endif
            @include('partials.notifications')
            
            <hr class="border-top-dotted">
            
            {!! Form::open(['route' => 'account.register.post', 'class' => 'form-content','autocomplete' => 'off']) !!}
            
            @if(isset($embedded))
                <input name="embedded" type="hidden" value="{{isset($route) && $route ? $route : ''}}">
            @endif
            <div class="px-2 px-sm-0">
                <div class="row">
                    
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label>{{trans('user::users.form.first-name')}}</label>
                        {{ Form::text('first_name', old('first_name'),['required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                        {!! $errors->first('first_name', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label>{{trans('user::users.form.last-name')}}</label>
                        {{ Form::text('last_name', old('last_name'),['required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                        {!! $errors->first('last_name', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Email</label>
                        {{ Form::email('email', old('email'),['required'=>true,'class'=>"form-control",'placeholder' => '...']) }}
                        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    
                    
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>{{trans('user::users.form.password')}}</label>
                        {{ Form::password('password',['required'=>true,'class'=>'form-control','placeholder' => '...']) }}
                        {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label>{{trans('iprofile::frontend.title.password confirmation')}}</label>
                        {{ Form::password('password_confirmation',['required'=>true,'class'=>'form-control','placeholder' => '...']) }}
                        {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    
                    <!--17-09-2020::JCEC, primera version del register extra fields
                                toca irlo mejorando-->
                    @php
                        
                        $registerExtraFields = is_array(setting('iprofile::registerExtraFields')) ? setting('iprofile::registerExtraFields') : is_array(json_decode(setting('iprofile::registerExtraFields'))) ? json_decode(setting('iprofile::registerExtraFields')) : json_decode(json_encode(setting('iprofile::registerExtraFields')));
                    @endphp
                    @foreach($registerExtraFields as $extraField)
                        @if($extraField->active)
                            <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has($extraField->field) ? ' has-error' : '' }}">
                                <label>{{trans("iprofile::frontend.form.$extraField->field")}}</label>
                                {{ Form::text($extraField->field, old($extraField->field),['required'=>$extraField->required,'class'=>"form-control",'placeholder' => '']) }}
                                {!! $errors->first($extraField->field, '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <hr class="border-top-dotted my-4">
                
                <div class="row">
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }}">
                        
                        <div class="custom-control custom-radio red mb-3">
                            <input type="radio" class="custom-control-input"
                                   id="customradio-select1" name="confirmPolytics" value="1" required>
                            <label class="custom-control-label" for="customradio-select1">
                                {!!  trans('icommerce::customer.form.confirmPolytics',["url" => url("/politica-de-privacidad")])  !!}
                            </label>
                        </div>
                        
                        <div class="custom-control custom-radio red mb-3">
                            <input type="radio" class="custom-control-input"
                                   id="customradio-select2" name="remember_me">
                            <label class="custom-control-label" for="customradio-select2">
                                {{trans('iprofile::frontend.title.stay connect')}}
                            </label>
                        </div>
                    
                    
                    </div>
                    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} pt-4 pt-lg-0">
                        <input class="btn btn-primary text-white text-uppercase font-weight-bold rounded-pill px-3 py-2"
                               type="submit" value="{{ trans('core::core.button.create') }}">
                    </div>
                </div>
            
            </div>
            
            {!! Form::close() !!}
        
        
        </div>
    
    </div>
</div>

