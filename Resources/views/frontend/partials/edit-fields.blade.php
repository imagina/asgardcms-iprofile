@php
    $op = array('required' => 'required');
@endphp

{{--
<div class="border-top title border-bottom border-top-dotted border-bottom-dotted py-4 my-5">
        <h1 class="my-0 text-primary">
        @if(isset($user) &&  !empty($user->first_name))
            Bienvenido {{$user->first_name}}
        @else
            Nombre del usuario
        @endif
        </h1>
</div>
--}}

{!! Form::open(['route' => ['iprofile.profile.update', $user->id], 'method' => 'put']) !!}
    <div class="row">

        <div class="col-sm-12 col-md-6 py-2">
            {{ Form::normalInput('first_name', trans('user::users.form.first-name'), $errors, $user,$op) }}
        </div>

        <div class="col-sm-12 col-md-6 py-2">
            {{ Form::normalInput('last_name', trans('user::users.form.last-name'), $errors, $user,$op) }}
        </div>

        <div class="col-sm-12 col-md-6 py-2">
            <div class="form-group ">
                <label for="user_type_id">{{trans('iprofile::frontend.form.identification type')}}</label>
 
                    @if(isset($fields['user_type_id']) &&  !empty($fields['user_type_id']))
                        @php $old = $fields['user_type_id']; @endphp
                    @else
                        @php $old = null; @endphp
                    @endif
                   
                    <select class="custom-select" name="fields[user_type_id]" required>
                        <option value="">Seleccionar</option>
                        <option value="cc" @if($old=="cc") selected @endif>CC</option>
                        <option value="ce" @if($old=="ce") selected @endif>CE</option>
                        <option value="pasaporte" @if($old=="pasaporte") selected @endif>{{trans('iprofile::frontend.form.passport')}}</option>
                        <option value="nit" @if($old=="nit") selected @endif>NIT</option>
                    </select>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 py-2">
            <div class="form-group ">
                <label for="user_id">{{trans('iprofile::frontend.form.user id')}}</label>
                <input name="fields[identification]" @if(isset($fields['identification']) && !empty($fields['identification'])) value="{{$fields['identification']}}" @endif class="form-control"  type="text" placeholder="..." required>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 py-2">
            <div class="form-group ">
                <label for="user_cellphone">{{trans('iprofile::frontend.form.cellphone')}}</label>
                <input name="fields[cellularPhone]" @if(isset($fields['cellularPhone']) && !empty($fields['cellularPhone'])) value="{{$fields['cellularPhone']}}" @endif class="form-control" type="number" placeholder="..." required>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 py-2">
            {{ Form::normalInputOfType('email', 'email', trans('user::users.form.email'), $errors, $user, array(
                    'disabled' => 'disabled')) }}
        </div>

    </div>

    <hr class="border-top-dotted">

    <div class="row">
        {{--
        <div class="col-auto">
            <i class="fa fa-long-arrow-right fa-2x text-primary"></i>
        </div>
        <div class="col">
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input"
                           id="customradio-select1" name="fields[user_policies]" @if(isset($fields['user_policies']) && !empty($fields['user_policies'])) checked @endif required>
                    <label class="custom-control-label" for="customradio-select1">Declaro
                        conocer las políticas de Términos y Condiciones y autorizo el
                        tratamiento de mis datos personales en la <span class="text-primary">Revista Tu Barrio</span></label>
                </div>
        </div>
        --}}
        <div class="col-md-12 col-lg-auto text-center pt-4 pt-lg-0">
            <button type="submit"
                class="btn btn-primary text-white font-weight-bold rounded-pill px-3 py-2 text-uppercase">
                {{ trans('core::core.button.update') }}
            </button>
        </div>

    </div>

{!! Form::close() !!}