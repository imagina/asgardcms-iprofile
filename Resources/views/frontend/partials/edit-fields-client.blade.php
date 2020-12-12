@php
    $op = array('required' => 'required');
@endphp

{!! Form::open(['route' => ['iprofile.profile.update', $user->id], 'method' => 'put']) !!}
    
        <div class="row">

            <div class="col-sm-12 col-md-6 py-2">
                {{ Form::normalInput('first_name', 'Nombre del Propietario', $errors, $user,$op) }}
                {{--
                <div class="form-group ">
                    <label for="owner_name">Nombre del Propietario</label>
                    <input name="fields[owner_name]" @if(isset($fields['owner_name']) &&  !empty($fields['owner_name'])) value="{{$fields['owner_name']}}" @endif class="form-control" placeholder="..." type="text" required>
                </div> 
                --}}
            </div>

            <div class="col-sm-12 col-md-6 py-2">
                {{ Form::normalInput('last_name', 'Apellidos', $errors, $user,$op) }}
                {{--
                <div class="form-group ">
                    <label for="owner_lastname">Apellidos</label>
                    <input name="fields[owner_lastname]" @if(isset($fields['owner_lastname']) &&  !empty($fields['owner_lastname'])) value="{{$fields['owner_lastname']}}" @endif class="form-control" placeholder="..." type="text" required>
                </div> 
                --}}
            </div>

            <div class="col-sm-12 col-md-6 py-2">
                <div class="form-group ">
                    <label for="owner_type_id">Tipo de Identificación</label>
 
                    @if(isset($fields['owner_type_id']) &&  !empty($fields['owner_type_id']))
                        @php $old = $fields['owner_type_id']; @endphp
                    @else
                        @php $old = null; @endphp
                    @endif
                   
                    <select class="custom-select" name="fields[owner_type_id]" required>
                        <option value="">Seleccionar</option>
                        <option value="cc" @if($old=="cc") selected @endif>CC</option>
                        <option value="ce" @if($old=="ce") selected @endif>CE</option>
                        <option value="pasaporte" @if($old=="pasaporte") selected @endif>Pasaporte</option>
                        <option value="nit" @if($old=="nit") selected @endif>NIT</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 py-2">
                <div class="form-group ">
                    <label for="owner_id">Número de Identificación</label>
                    <input name="fields[owner_id]" @if(isset($fields['owner_id']) && !empty($fields['owner_id'])) value="{{$fields['owner_id']}}" @endif class="form-control"  type="text" placeholder="..." required>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 py-2">
                <div class="form-group ">
                    <label for="owner_gender">Género</label>

                    @if(isset($fields['owner_gender']) &&  !empty($fields['owner_gender']))
                        @php $old = $fields['owner_gender']; @endphp
                    @else
                        @php $old = null; @endphp
                    @endif

                    <select class="custom-select" name="fields[owner_gender]" required>
                        <option value="">Seleccionar</option>
                        <option value="masculino" @if($old=="masculino") selected @endif >Masculino</option>
                        <option value="femenino" @if($old=="femenino") selected @endif>Femenino</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 py-2">
                <div class="form-group ">
                    <label for="owner_cellphone">Celular</label>
                    <input name="fields[owner_cellphone]" @if(isset($fields['owner_cellphone']) && !empty($fields['owner_cellphone'])) value="{{$fields['owner_cellphone']}}" @endif class="form-control" type="number" placeholder="..." required>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 py-2">
                <div class="form-group ">
                    <label for="owner_birthday">Fecha de nacimiento</label>
                    <input name="fields[owner_birthday]" @if(isset($fields['owner_birthday']) && !empty($fields['owner_birthday'])) value="{{$fields['owner_birthday']}}" @endif class="form-control" type="date" placeholder="..." required>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 py-2">
                {{ Form::normalInputOfType('email', 'email', trans('user::users.form.email'), $errors, $user, array(
                        'disabled' => 'disabled')) }}
                {{--
                <div class="form-group ">
                    <label for="owner_email">Email</label>
                    <input name="fields[owner_email]" @if(isset($fields['owner_email']) && !empty($fields['owner_email'])) value="{{$fields['owner_email']}}" @endif class="form-control" type="email" placeholder="..." required>
                </div>
                --}}
            </div>

        </div>

        <hr class="border-top-dotted">

        <div class="row">

            <div class="col-auto">
                <i class="fa fa-long-arrow-right fa-2x text-primary"></i>
            </div>

            <div class="col">
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input"
                           id="customradio-select1" name="fields[owner_policies]" @if(isset($fields['owner_policies']) && !empty($fields['owner_policies'])) checked @endif required>
                    <label class="custom-control-label" for="customradio-select1">Declaro
                        conocer las políticas de Términos y Condiciones y autorizo el
                        tratamiento de mis datos personales en la <span class="text-primary">Revista Tu Barrio</span></label>
                </div>
            </div>

            <div class="col-md-12 col-lg-auto text-center pt-4 pt-lg-0">
                <button type="submit"
                        class="btn btn-primary text-white font-weight-bold rounded-pill px-3 py-2 text-uppercase">
                    {{ trans('core::core.button.update') }}
                </button>
            </div>

        </div>
       
{!! Form::close() !!}