@extends('iprofile::admin.profiles.layouts.master')



@section('content')


    <div class="row">
        <div class="col-md-4 col-lg-3">

            <!-- Profile Image -->
            <div class="">

                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-primary">
                        <h3 class="widget-user-username">
                            <?php if ($user->present()->fullname() != ' '): ?>
                                <?= $user->present()->fullName(); ?>
                            <?php else: ?>
                            <em>{{trans('core::core.general.complete your profile')}}.</em>
                            <?php endif; ?>

                        </h3>
                        <h5 class="widget-user-desc">{{$user->roles->first()->name}}</h5>

                    </div>
                    <div class="widget-user-image">

                        <div class="profile-img-overlay">
                            @if(isset($profile->options->mainimage)&&!empty($profile->options->mainimage))
                                <img id="mainImage"
                                     class="image profile-user-img img-responsive img-circle"
                                     width="100%"
                                     src="{{url($profile->options->mainimage)}}?v={{$profile->updated_at}}"/>
                            @else
                                <img id="mainImage"
                                     class="image profile-user-img img-responsive img-circle"
                                     width="100%"
                                     src="{{url('modules/iprofile/img/default.jpg')}}"/>
                            @endif

                            <div class="overlay">
                                <div class="btn-group bt-upload bt-upload-right">
                                    <label class="btn  btn-file"
                                           title="{{trans('iprofile::profiles.form.select photo')}}">
                                        <i class="fa fa-camera fa-2x text-light-blue"></i>
                                        <input
                                                type="file" accept="image/*" id="mainimage"
                                                name="mainimage"
                                                value="mainimage"
                                                class="form-control" style="display:none;">

                                    </label>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="box-footer">

                        <div class="row">
                            <div class="col-sm-12 border-right">
                                <div class="description-block center-block">

                                    <br>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <div class="col-xs-12">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item" style="border-top: 0;">
                                        @if(isset($profile->social)&& !empty($profile->social))
                                            @foreach($profile->social as $i=>$item)
                                                <a class="btn btn-social-icon fa fa-{{$item->label}}"
                                                   href="{{$item->desc}}"><i
                                                            class="fa fa-{{$item->label}}"></i></a>
                                            @endforeach
                                        @else
                                            <p style="margin: 0;">{{trans('iprofile::profiles.form.Not fount')}}</p>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->


                    </div>
                </div>

            </div><!-- Profile Image -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('iprofile::profiles.form.About Me')}}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i>{{trans('iprofile::profiles.form.Education')}}
                    </strong>

                    <p class="text-muted p-l">
                        @if(isset($profile->options->education)&& !empty($profile->options->education))
                            {{$profile->options->education}}
                        @else
                            {{trans('iprofile::profiles.form.Not fount')}}
                        @endif
                    </p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> {{trans('iprofile::profiles.form.Location')}}
                    </strong>

                    <p class="text-muted p-l"> @if(isset($profile->city)&& !empty($profile->city))
                            {{$profile->city}}
                        @else
                            {{trans('iprofile::profiles.form.Not fount')}}
                        @endif
                        , @if(isset($profile->state)&& !empty($profile->state))
                            {{$profile->state}}
                        @else
                            {{trans('iprofile::profiles.form.Not fount')}}
                        @endif</p>

                    <hr>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> {{trans('iprofile::profiles.form.bio')}}
                    </strong>

                    <p class="text-muted p-l">@if(isset($profile->bio)&& !empty($profile->bio))
                            {!!$profile->bio!!}
                        @else
                            {{trans('iprofile::profiles.form.Not fount')}}
                        @endif</p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
        <div class="col-md-8 col-lg-9">

            <div class="box box-primary">

                <div class="box-header ">
                    <h3 class="box-title">{{trans('iprofile::profiles.form.Modify')}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <br>


                <div class="col-xs-12">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#settings"
                                                  data-toggle="tab">{{trans('iprofile::profiles.form.Settings')}}</a>
                            </li>
                            <li><a href="#addresses"
                                   data-toggle="tab">{{trans('iprofile::profiles.form.addresses')}}</a>

                            </li>
                            <li><a href="#acount"
                                   data-toggle="tab">{{trans('iprofile::profiles.form.account')}}</a>
                            </li>
                        </ul>
                        {!! Form::open(['route' => ['admin.iprofile.profile.update', $profile->id], 'method' => 'put']) !!}
                        <div class="tab-content">
                            <div class="active tab-pane" id="settings">

                                <input type="hidden" id="hiddenImage" name="mainimage"
                                       required>

                                @php $locale = LaravelLocalization::setLocale() ?: App::getLocale();@endphp

                                <div class="box-body">

                                    <div class="box ">
                                        <div class="box-header">
                                            <h3 class="box-title">{{trans('iprofile::profiles.form.Basic')}}</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="row">


                                            @include('iprofile::admin.profiles.partials.edit-fields', ['lang' => $locale])

                                            <!-- -->

                                                @php
                                                    if(isset($profile->options->education) && !empty($profile->options->education)){
                                                    $oldeducation = $profile->options->education;
                                                    }else{
                                                    $oldeducation=null;
                                                    }

                                                @endphp


                                                <div class="col-md-4">
                                                    <div class='form-group{{ $errors->has("education") ? ' has-error' : '' }}'>
                                                        {!! Form::label("education", trans('iprofile::profiles.form.Education')) !!}
                                                        {!! Form::text("education", old("education",$oldeducation), ['class' => 'form-control education', 'data-education' => 'target', 'placeholder' => trans('iprofile::profiles.form.Education')]) !!}
                                                        {!! $errors->first("education", '<span class="help-block">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class='form-group{{ $errors->has("city") ? ' has-error' : '' }}'>
                                                        {!! Form::label("city", trans('iprofile::profiles.form.city')) !!}
                                                        {!! Form::text("city", old("city",$profile->city), ['class' => 'form-control education', 'data-education' => 'target', 'placeholder' => trans('iprofile::profiles.form.city')]) !!}
                                                        {!! $errors->first("city", '<span class="help-block">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class='form-group{{ $errors->has("state") ? ' has-error' : '' }}'>
                                                        {!! Form::label("state", trans('iprofile::profiles.form.state')) !!}
                                                        {!! Form::text("state", old("state",$profile->state), ['class' => 'form-control state', 'data-state' => 'target', 'placeholder' => trans('iprofile::profiles.form.state')]) !!}
                                                        {!! $errors->first("state", '<span class="help-block">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class='form-group{{ $errors->has("country") ? ' has-error' : '' }}'>
                                                        {!! Form::label("country", trans('iprofile::profiles.form.country')) !!}
                                                        {!! Form::text("country", old("country", $profile->country), ['class' => 'form-control country', 'data-country' => 'target', 'placeholder' => trans('iprofile::profiles.form.country')]) !!}
                                                        {!! $errors->first("country", '<span class="help-block">:message</span>') !!}
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.box-body -->
                                    </div>

                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">{{trans('iprofile::profiles.form.social_networks')}}</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <div class='form-group'>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-sortable "
                                                           id="tab_logic">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">
                                                                {{trans('iprofile::profiles.form.Social.icono')}}
                                                            </th>
                                                            <th class="text-center">
                                                                {{trans('iprofile::profiles.form.Social.link')}}
                                                            </th>

                                                            <th class="text-center">
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(isset($profile->social)&& !empty($profile->social))
                                                            @foreach($profile->social as $i=>$item)
                                                                <tr id='social[{{$i}}]'
                                                                    data-id="{{$i}}">
                                                                    <td data-name="social[{{$i}}][icono]">
                                                                        <input type="text"
                                                                               name="social[{{$i}}][icono]"
                                                                               id='icono'
                                                                               placeholder='icono fa'
                                                                               class="form-control"
                                                                               value="{{$item->label}}"/>
                                                                    </td>
                                                                    <td data-name="link">
                                                                        <input type="url"
                                                                               name='social[{{$i}}][link]'
                                                                               id='link'
                                                                               placeholder='link'
                                                                               class="form-control"
                                                                               value="{{$item->desc}}">
                                                                    </td>
                                                                    <td data-name="del">
                                                                        <button name="del0"
                                                                                class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <a id="add_row"
                                                   class="btn btn-default btn-sm">
                                                    <i class="fa fa-plus"></i> {{trans('iprofile::profiles.form.Social.Add Row')}}
                                                </a>
                                            </div>

                                        </div>
                                        <!-- /.box-body -->
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit"
                                            class="btn btn-primary btn-flat">{{trans('iprofile::profiles.button.update profile')}}</button>
                                    <a class="btn btn-danger pull-right btn-flat"
                                       href="{{ route('admin.account.profile.edit')}}"><i
                                                class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}
                                    </a>
                                </div>
                                
                            </div>

                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="addresses">
                                <div class="tab-pane">
                                    <div class="box-body">

                                       
                                        <div class="box ">
                                            <div class="box-header ">
                                                <h3 class="box-title">{{trans('iprofile::profiles.form.billing_address')}}</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">

                                                <div class="row">

                                                    <div class="col-xs-12">
                                                        <div class='form-group{{ $errors->has("payment_company") ? ' has-error' : '' }}'>
                                                            {!! Form::label("payment_company", trans('iprofile::profiles.form.company')) !!}
                                                            {!! Form::text("payment_company", old("payment_company", $profile->payment_company), ['class' => 'form-control payment_company', 'data-payment_company' => 'target', 'placeholder' => trans('iprofile::profiles.form.company')]) !!}
                                                            {!! $errors->first("payment_company", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("payment_address_1") ? ' has-error' : '' }}'>
                                                            {!! Form::label("payment_address_1", trans('iprofile::profiles.form.address1')) !!}
                                                            {!! Form::text("payment_address_1", old("payment_address_1", $profile->payment_address_1), ['class' => 'form-control payment_address_1', 'data-payment_address_1' => 'target', 'placeholder' => trans('iprofile::profiles.form.address1')]) !!}
                                                            {!! $errors->first("payment_address_1", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("payment_address_2") ? ' has-error' : '' }}'>
                                                            {!! Form::label("payment_address_2", trans('iprofile::profiles.form.address2')) !!}
                                                            {!! Form::text("payment_address_2", old("payment_address_1", $profile->payment_address_2), ['class' => 'form-control payment_address_2', 'data-payment_address_2' => 'target', 'placeholder' => trans('iprofile::profiles.form.address2')]) !!}
                                                            {!! $errors->first("payment_address_2", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("payment_city") ? ' has-error' : '' }}'>
                                                            {!! Form::label("payment_city", trans('iprofile::profiles.form.city')) !!}
                                                            {!! Form::text("payment_city", old("payment_city", $profile->payment_city), ['class' => 'form-control payment_city', 'data-payment_city' => 'target', 'placeholder' => trans('iprofile::profiles.form.city')]) !!}
                                                            {!! $errors->first("payment_city", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("payment_postcode") ? ' has-error' : '' }}'>
                                                            {!! Form::label("payment_postcode", trans('iprofile::profiles.form.post_code')) !!}
                                                            {!! Form::text("payment_postcode", old("payment_postcode", $profile->payment_postcode), ['class' => 'form-control payment_postcode', 'data-payment_postcode' => 'target', 'placeholder' => trans('iprofile::profiles.form.post_code')]) !!}
                                                            {!! $errors->first("payment_postcode", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                                            <label for="payment_country">{{ trans('iprofile::profiles.form.country') }}</label>
                                                            <select
                                                                    class="form-control"
                                                                    id="payment_country"
                                                                    name="payment_country">
                                                                <option value="null" id="AF">Elegir opción</option>
                                                                <option value="AF">Afganistán</option>
                                                                <option value="AL">Albania</option>
                                                                <option value="DE">Alemania</option>
                                                                <option value="AD">Andorra</option>
                                                                <option value="AO">Angola</option>
                                                                <option value="AI">Anguila</option>
                                                                <option value="AQ">Antártida</option>
                                                                <option value="AG">Antigua y Barbuda</option>
                                                                <option value="AN">Antillas holandesas</option>
                                                                <option value="SA">Arabia Saudí</option>
                                                                <option value="DZ">Argelia</option>
                                                                <option value="AR">Argentina</option>
                                                                <option value="AM">Armenia</option>
                                                                <option value="AW">Aruba</option>
                                                                <option value="AU">Australia</option>
                                                                <option value="AT">Austria</option>
                                                                <option value="AZ">Azerbaiyán</option>
                                                                <option value="BS">Bahamas</option>
                                                                <option value="BH">Bahrein</option>
                                                                <option value="BD">Bangladesh</option>
                                                                <option value="BB">Barbados</option>
                                                                <option value="BE">Bélgica</option>
                                                                <option value="BZ">Belice</option>
                                                                <option value="BJ">Benín</option>
                                                                <option value="BM">Bermudas</option>
                                                                <option value="BT">Bhután</option>
                                                                <option value="BY">Bielorrusia</option>
                                                                <option value="MM">Birmania</option>
                                                                <option value="BO">Bolivia</option>
                                                                <option value="BA">Bosnia y Herzegovina</option>
                                                                <option value="BW">Botsuana</option>
                                                                <option value="BR">Brasil</option>
                                                                <option value="BN">Brunei</option>
                                                                <option value="BG">Bulgaria</option>
                                                                <option value="BF">Burkina Faso</option>
                                                                <option value="BI">Burundi</option>
                                                                <option value="CV">Cabo Verde</option>
                                                                <option value="KH">Camboya</option>
                                                                <option value="CM">Camerún</option>
                                                                <option value="CA">Canadá</option>
                                                                <option value="TD">Chad</option>
                                                                <option value="CL">Chile</option>
                                                                <option value="CN">China</option>
                                                                <option value="CY">Chipre</option>
                                                                <option value="VA">Ciudad estado del Vaticano</option>
                                                                <option value="CO">Colombia</option>
                                                                <option value="KM">Comores</option>
                                                                <option value="CG">Congo</option>
                                                                <option value="KR">Corea</option>
                                                                <option value="KP">Corea del Norte</option>
                                                                <option value="CI">Costa del Marfíl</option>
                                                                <option value="CR">Costa Rica</option>
                                                                <option value="HR">Croacia</option>
                                                                <option value="CU">Cuba</option>
                                                                <option value="DK">Dinamarca</option>
                                                                <option value="DJ">Djibouri</option>
                                                                <option value="DM">Dominica</option>
                                                                <option value="EC">Ecuador</option>
                                                                <option value="EG">Egipto</option>
                                                                <option value="SV">El Salvador</option>
                                                                <option value="AE">Emiratos Arabes Unidos</option>
                                                                <option value="ER">Eritrea</option>
                                                                <option value="SK">Eslovaquia</option>
                                                                <option value="SI">Eslovenia</option>
                                                                <option value="ES">España</option>
                                                                <option value="US">Estados Unidos</option>
                                                                <option value="EE">Estonia</option>
                                                                <option value="ET">Etiopía</option>
                                                                <option value="MK">Ex-República Yugoslava de Macedonia
                                                                </option>
                                                                <option value="PH">Filipinas</option>
                                                                <option value="FI">Finlandia</option>
                                                                <option value="FR">Francia</option>
                                                                <option value="GA">Gabón</option>
                                                                <option value="GM">Gambia</option>
                                                                <option value="GE">Georgia</option>
                                                                <option value="GS">Georgia del Sur y las islas Sandwich
                                                                    del
                                                                    Sur
                                                                </option>
                                                                <option value="GH">Ghana</option>
                                                                <option value="GI">Gibraltar</option>
                                                                <option value="GD">Granada</option>
                                                                <option value="GR">Grecia</option>
                                                                <option value="GL">Groenlandia</option>
                                                                <option value="GP">Guadalupe</option>
                                                                <option value="GU">Guam</option>
                                                                <option value="GT">Guatemala</option>
                                                                <option value="GY">Guayana</option>
                                                                <option value="GF">Guayana francesa</option>
                                                                <option value="GN">Guinea</option>
                                                                <option value="GQ">Guinea Ecuatorial</option>
                                                                <option value="GW">Guinea-Bissau</option>
                                                                <option value="HT">Haití</option>
                                                                <option value="NL">Holanda</option>
                                                                <option value="HN">Honduras</option>
                                                                <option value="HK">Hong Kong R. A. E</option>
                                                                <option value="HU">Hungría</option>
                                                                <option value="IN">India</option>
                                                                <option value="ID">Indonesia</option>
                                                                <option value="IQ">Irak</option>
                                                                <option value="IR">Irán</option>
                                                                <option value="IE">Irlanda</option>
                                                                <option value="BV">Isla Bouvet</option>
                                                                <option value="CX">Isla Christmas</option>
                                                                <option value="HM">Isla Heard e Islas McDonald</option>
                                                                <option value="IS">Islandia</option>
                                                                <option value="KY">Islas Caimán</option>
                                                                <option value="CK">Islas Cook</option>
                                                                <option value="CC">Islas de Cocos o Keeling</option>
                                                                <option value="FO">Islas Faroe</option>
                                                                <option value="FJ">Islas Fiyi</option>
                                                                <option value="FK">Islas Malvinas Islas Falkland
                                                                </option>
                                                                <option value="MP">Islas Marianas del norte</option>
                                                                <option value="MH">Islas Marshall</option>
                                                                <option value="UM">Islas menores de Estados Unidos
                                                                </option>
                                                                <option value="PW">Islas Palau</option>
                                                                <option value="SB">Islas Salomón</option>
                                                                <option value="TK">Islas Tokelau</option>
                                                                <option value="TC">Islas Turks y Caicos</option>
                                                                <option value="VI">Islas Vírgenes EE.UU.</option>
                                                                <option value="VG">Islas Vírgenes Reino Unido</option>
                                                                <option value="IL">Israel</option>
                                                                <option value="IT">Italia</option>
                                                                <option value="JM">Jamaica</option>
                                                                <option value="JP">Japón</option>
                                                                <option value="JO">Jordania</option>
                                                                <option value="KZ">Kazajistán</option>
                                                                <option value="KE">Kenia</option>
                                                                <option value="KG">Kirguizistán</option>
                                                                <option value="KI">Kiribati</option>
                                                                <option value="KW">Kuwait</option>
                                                                <option value="LA">Laos</option>
                                                                <option value="LS">Lesoto</option>
                                                                <option value="LV">Letonia</option>
                                                                <option value="LB">Líbano</option>
                                                                <option value="LR">Liberia</option>
                                                                <option value="LY">Libia</option>
                                                                <option value="LI">Liechtenstein</option>
                                                                <option value="LT">Lituania</option>
                                                                <option value="LU">Luxemburgo</option>
                                                                <option value="MO">Macao R. A. E</option>
                                                                <option value="MG">Madagascar</option>
                                                                <option value="MY">Malasia</option>
                                                                <option value="MW">Malawi</option>
                                                                <option value="MV">Maldivas</option>
                                                                <option value="ML">Malí</option>
                                                                <option value="MT">Malta</option>
                                                                <option value="MA">Marruecos</option>
                                                                <option value="MQ">Martinica</option>
                                                                <option value="MU">Mauricio</option>
                                                                <option value="MR">Mauritania</option>
                                                                <option value="YT">Mayotte</option>
                                                                <option value="MX">México</option>
                                                                <option value="FM">Micronesia</option>
                                                                <option value="MD">Moldavia</option>
                                                                <option value="MC">Mónaco</option>
                                                                <option value="MN">Mongolia</option>
                                                                <option value="MS">Montserrat</option>
                                                                <option value="MZ">Mozambique</option>
                                                                <option value="NA">Namibia</option>
                                                                <option value="NR">Nauru</option>
                                                                <option value="NP">Nepal</option>
                                                                <option value="NI">Nicaragua</option>
                                                                <option value="NE">Níger</option>
                                                                <option value="NG">Nigeria</option>
                                                                <option value="NU">Niue</option>
                                                                <option value="NF">Norfolk</option>
                                                                <option value="NO">Noruega</option>
                                                                <option value="NC">Nueva Caledonia</option>
                                                                <option value="NZ">Nueva Zelanda</option>
                                                                <option value="OM">Omán</option>
                                                                <option value="PA">Panamá</option>
                                                                <option value="PG">Papua Nueva Guinea</option>
                                                                <option value="PK">Paquistán</option>
                                                                <option value="PY">Paraguay</option>
                                                                <option value="PE">Perú</option>
                                                                <option value="PN">Pitcairn</option>
                                                                <option value="PF">Polinesia francesa</option>
                                                                <option value="PL">Polonia</option>
                                                                <option value="PT">Portugal</option>
                                                                <option value="PR">Puerto Rico</option>
                                                                <option value="QA">Qatar</option>
                                                                <option value="UK">Reino Unido</option>
                                                                <option value="CF">República Centroafricana</option>
                                                                <option value="CZ">República Checa</option>
                                                                <option value="ZA">República de Sudáfrica</option>
                                                                <option value="CD">República Democrática del Congo Zaire
                                                                </option>
                                                                <option value="DO">República Dominicana</option>
                                                                <option value="RE">Reunión</option>
                                                                <option value="RW">Ruanda</option>
                                                                <option value="RO">Rumania</option>
                                                                <option value="RU">Rusia</option>
                                                                <option value="WS">Samoa</option>
                                                                <option value="AS">Samoa occidental</option>
                                                                <option value="KN">San Kitts y Nevis</option>
                                                                <option value="SM">San Marino</option>
                                                                <option value="PM">San Pierre y Miquelon</option>
                                                                <option value="VC">San Vicente e Islas Granadinas
                                                                </option>
                                                                <option value="SH">Santa Helena</option>
                                                                <option value="LC">Santa Lucía</option>
                                                                <option value="ST">Santo Tomé y Príncipe</option>
                                                                <option value="SN">Senegal</option>
                                                                <option value="YU">Serbia y Montenegro</option>
                                                                <option value="SC">Seychelles</option>
                                                                <option value="SL">Sierra Leona</option>
                                                                <option value="SG">Singapur</option>
                                                                <option value="SY">Siria</option>
                                                                <option value="SO">Somalia</option>
                                                                <option value="LK">Sri Lanka</option>
                                                                <option value="SZ">Suazilandia</option>
                                                                <option value="SD">Sudán</option>
                                                                <option value="SE">Suecia</option>
                                                                <option value="CH">Suiza</option>
                                                                <option value="SR">Surinam</option>
                                                                <option value="SJ">Svalbard</option>
                                                                <option value="TH">Tailandia</option>
                                                                <option value="TW">Taiwán</option>
                                                                <option value="TZ">Tanzania</option>
                                                                <option value="TJ">Tayikistán</option>
                                                                <option value="IO">Territorios británicos del océano
                                                                    Indico
                                                                </option>
                                                                <option value="TF">Territorios franceses del sur
                                                                </option>
                                                                <option value="TP">Timor Oriental</option>
                                                                <option value="TG">Togo</option>
                                                                <option value="TO">Tonga</option>
                                                                <option value="TT">Trinidad y Tobago</option>
                                                                <option value="TN">Túnez</option>
                                                                <option value="TM">Turkmenistán</option>
                                                                <option value="TR">Turquía</option>
                                                                <option value="TV">Tuvalu</option>
                                                                <option value="UA">Ucrania</option>
                                                                <option value="UG">Uganda</option>
                                                                <option value="UY">Uruguay</option>
                                                                <option value="UZ">Uzbekistán</option>
                                                                <option value="VU">Vanuatu</option>
                                                                <option value="VE">Venezuela</option>
                                                                <option value="VN">Vietnam</option>
                                                                <option value="WF">Wallis y Futuna</option>
                                                                <option value="YE">Yemen</option>
                                                                <option value="ZM">Zambia</option>
                                                                <option value="ZW">Zimbabue</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="payment_zone">{{ trans('iprofile::profiles.form.state') }}</label>
                                                            <select class="form-control" id="payment_zone"
                                                                    name="payment_zone">
                                                                <option>Ibague</option>
                                                                <option>Cucuta</option>
                                                                <option>San Cristóbal</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>

                                        <div class="box ">
                                            <div class="box-header ">
                                                <h3 class="box-title">{{trans('iprofile::profiles.form.shipping_address')}}</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">

                                                <div class="row">

                                                    <div class="col-xs-12">
                                                        <div class='form-group{{ $errors->has("shipping_company") ? ' has-error' : '' }}'>
                                                            {!! Form::label("shipping_company", trans('iprofile::profiles.form.company')) !!}
                                                            {!! Form::text("shipping_company", old("shipping_company", $profile->shipping_company), ['class' => 'form-control shipping_company', 'data-shipping_company' => 'target', 'placeholder' => trans('iprofile::profiles.form.company')]) !!}
                                                            {!! $errors->first("shipping_company", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("shipping_address_1") ? ' has-error' : '' }}'>
                                                            {!! Form::label("shipping_address_1", trans('iprofile::profiles.form.address1')) !!}
                                                            {!! Form::text("shipping_address_1", old("shipping_address_1", $profile->shipping_address_1), ['class' => 'form-control shipping_address_1', 'data-shipping_address_1' => 'target', 'placeholder' => trans('iprofile::profiles.form.address1')]) !!}
                                                            {!! $errors->first("shipping_address_1", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("shipping_address_2") ? ' has-error' : '' }}'>
                                                            {!! Form::label("shipping_address_2", trans('iprofile::profiles.form.address2')) !!}
                                                            {!! Form::text("shipping_address_2", old("shipping_address_2", $profile->shipping_address_2), ['class' => 'form-control shipping_address_2', 'data-shipping_address_2' => 'target', 'placeholder' => trans('iprofile::profiles.form.address2')]) !!}
                                                            {!! $errors->first("shipping_address_2", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("shipping_city") ? ' has-error' : '' }}'>
                                                            {!! Form::label("shipping_city", trans('iprofile::profiles.form.city')) !!}
                                                            {!! Form::text("shipping_city", old("shipping_city", $profile->shipping_city), ['class' => 'form-control shipping_city', 'data-shipping_city' => 'target', 'placeholder' => trans('iprofile::profiles.form.city')]) !!}
                                                            {!! $errors->first("shipping_city", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class='form-group{{ $errors->has("shipping_postcode") ? ' has-error' : '' }}'>
                                                            {!! Form::label("shipping_postcode", trans('iprofile::profiles.form.post_code')) !!}
                                                            {!! Form::text("shipping_postcode", old("shipping_postcode", $profile->shipping_postcode), ['class' => 'form-control shipping_postcode', 'data-shipping_postcode' => 'target', 'placeholder' => trans('iprofile::profiles.form.post_code')]) !!}
                                                            {!! $errors->first("shipping_postcode", '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">

                                                            <label for="shipping_country">{{ trans('iprofile::profiles.form.country') }}</label>
                                                            <select
                                                                    class="form-control"
                                                                    id="shipping_country"
                                                                    name="shipping_country">
                                                                <option value="null" id="AF">Elegir opción</option>
                                                                <option value="AF">Afganistán</option>
                                                                <option value="AL">Albania</option>
                                                                <option value="DE">Alemania</option>
                                                                <option value="AD">Andorra</option>
                                                                <option value="AO">Angola</option>
                                                                <option value="AI">Anguila</option>
                                                                <option value="AQ">Antártida</option>
                                                                <option value="AG">Antigua y Barbuda</option>
                                                                <option value="AN">Antillas holandesas</option>
                                                                <option value="SA">Arabia Saudí</option>
                                                                <option value="DZ">Argelia</option>
                                                                <option value="AR">Argentina</option>
                                                                <option value="AM">Armenia</option>
                                                                <option value="AW">Aruba</option>
                                                                <option value="AU">Australia</option>
                                                                <option value="AT">Austria</option>
                                                                <option value="AZ">Azerbaiyán</option>
                                                                <option value="BS">Bahamas</option>
                                                                <option value="BH">Bahrein</option>
                                                                <option value="BD">Bangladesh</option>
                                                                <option value="BB">Barbados</option>
                                                                <option value="BE">Bélgica</option>
                                                                <option value="BZ">Belice</option>
                                                                <option value="BJ">Benín</option>
                                                                <option value="BM">Bermudas</option>
                                                                <option value="BT">Bhután</option>
                                                                <option value="BY">Bielorrusia</option>
                                                                <option value="MM">Birmania</option>
                                                                <option value="BO">Bolivia</option>
                                                                <option value="BA">Bosnia y Herzegovina</option>
                                                                <option value="BW">Botsuana</option>
                                                                <option value="BR">Brasil</option>
                                                                <option value="BN">Brunei</option>
                                                                <option value="BG">Bulgaria</option>
                                                                <option value="BF">Burkina Faso</option>
                                                                <option value="BI">Burundi</option>
                                                                <option value="CV">Cabo Verde</option>
                                                                <option value="KH">Camboya</option>
                                                                <option value="CM">Camerún</option>
                                                                <option value="CA">Canadá</option>
                                                                <option value="TD">Chad</option>
                                                                <option value="CL">Chile</option>
                                                                <option value="CN">China</option>
                                                                <option value="CY">Chipre</option>
                                                                <option value="VA">Ciudad estado del Vaticano</option>
                                                                <option value="CO">Colombia</option>
                                                                <option value="KM">Comores</option>
                                                                <option value="CG">Congo</option>
                                                                <option value="KR">Corea</option>
                                                                <option value="KP">Corea del Norte</option>
                                                                <option value="CI">Costa del Marfíl</option>
                                                                <option value="CR">Costa Rica</option>
                                                                <option value="HR">Croacia</option>
                                                                <option value="CU">Cuba</option>
                                                                <option value="DK">Dinamarca</option>
                                                                <option value="DJ">Djibouri</option>
                                                                <option value="DM">Dominica</option>
                                                                <option value="EC">Ecuador</option>
                                                                <option value="EG">Egipto</option>
                                                                <option value="SV">El Salvador</option>
                                                                <option value="AE">Emiratos Arabes Unidos</option>
                                                                <option value="ER">Eritrea</option>
                                                                <option value="SK">Eslovaquia</option>
                                                                <option value="SI">Eslovenia</option>
                                                                <option value="ES">España</option>
                                                                <option value="US">Estados Unidos</option>
                                                                <option value="EE">Estonia</option>
                                                                <option value="ET">Etiopía</option>
                                                                <option value="MK">Ex-República Yugoslava de Macedonia
                                                                </option>
                                                                <option value="PH">Filipinas</option>
                                                                <option value="FI">Finlandia</option>
                                                                <option value="FR">Francia</option>
                                                                <option value="GA">Gabón</option>
                                                                <option value="GM">Gambia</option>
                                                                <option value="GE">Georgia</option>
                                                                <option value="GS">Georgia del Sur y las islas Sandwich
                                                                    del
                                                                    Sur
                                                                </option>
                                                                <option value="GH">Ghana</option>
                                                                <option value="GI">Gibraltar</option>
                                                                <option value="GD">Granada</option>
                                                                <option value="GR">Grecia</option>
                                                                <option value="GL">Groenlandia</option>
                                                                <option value="GP">Guadalupe</option>
                                                                <option value="GU">Guam</option>
                                                                <option value="GT">Guatemala</option>
                                                                <option value="GY">Guayana</option>
                                                                <option value="GF">Guayana francesa</option>
                                                                <option value="GN">Guinea</option>
                                                                <option value="GQ">Guinea Ecuatorial</option>
                                                                <option value="GW">Guinea-Bissau</option>
                                                                <option value="HT">Haití</option>
                                                                <option value="NL">Holanda</option>
                                                                <option value="HN">Honduras</option>
                                                                <option value="HK">Hong Kong R. A. E</option>
                                                                <option value="HU">Hungría</option>
                                                                <option value="IN">India</option>
                                                                <option value="ID">Indonesia</option>
                                                                <option value="IQ">Irak</option>
                                                                <option value="IR">Irán</option>
                                                                <option value="IE">Irlanda</option>
                                                                <option value="BV">Isla Bouvet</option>
                                                                <option value="CX">Isla Christmas</option>
                                                                <option value="HM">Isla Heard e Islas McDonald</option>
                                                                <option value="IS">Islandia</option>
                                                                <option value="KY">Islas Caimán</option>
                                                                <option value="CK">Islas Cook</option>
                                                                <option value="CC">Islas de Cocos o Keeling</option>
                                                                <option value="FO">Islas Faroe</option>
                                                                <option value="FJ">Islas Fiyi</option>
                                                                <option value="FK">Islas Malvinas Islas Falkland
                                                                </option>
                                                                <option value="MP">Islas Marianas del norte</option>
                                                                <option value="MH">Islas Marshall</option>
                                                                <option value="UM">Islas menores de Estados Unidos
                                                                </option>
                                                                <option value="PW">Islas Palau</option>
                                                                <option value="SB">Islas Salomón</option>
                                                                <option value="TK">Islas Tokelau</option>
                                                                <option value="TC">Islas Turks y Caicos</option>
                                                                <option value="VI">Islas Vírgenes EE.UU.</option>
                                                                <option value="VG">Islas Vírgenes Reino Unido</option>
                                                                <option value="IL">Israel</option>
                                                                <option value="IT">Italia</option>
                                                                <option value="JM">Jamaica</option>
                                                                <option value="JP">Japón</option>
                                                                <option value="JO">Jordania</option>
                                                                <option value="KZ">Kazajistán</option>
                                                                <option value="KE">Kenia</option>
                                                                <option value="KG">Kirguizistán</option>
                                                                <option value="KI">Kiribati</option>
                                                                <option value="KW">Kuwait</option>
                                                                <option value="LA">Laos</option>
                                                                <option value="LS">Lesoto</option>
                                                                <option value="LV">Letonia</option>
                                                                <option value="LB">Líbano</option>
                                                                <option value="LR">Liberia</option>
                                                                <option value="LY">Libia</option>
                                                                <option value="LI">Liechtenstein</option>
                                                                <option value="LT">Lituania</option>
                                                                <option value="LU">Luxemburgo</option>
                                                                <option value="MO">Macao R. A. E</option>
                                                                <option value="MG">Madagascar</option>
                                                                <option value="MY">Malasia</option>
                                                                <option value="MW">Malawi</option>
                                                                <option value="MV">Maldivas</option>
                                                                <option value="ML">Malí</option>
                                                                <option value="MT">Malta</option>
                                                                <option value="MA">Marruecos</option>
                                                                <option value="MQ">Martinica</option>
                                                                <option value="MU">Mauricio</option>
                                                                <option value="MR">Mauritania</option>
                                                                <option value="YT">Mayotte</option>
                                                                <option value="MX">México</option>
                                                                <option value="FM">Micronesia</option>
                                                                <option value="MD">Moldavia</option>
                                                                <option value="MC">Mónaco</option>
                                                                <option value="MN">Mongolia</option>
                                                                <option value="MS">Montserrat</option>
                                                                <option value="MZ">Mozambique</option>
                                                                <option value="NA">Namibia</option>
                                                                <option value="NR">Nauru</option>
                                                                <option value="NP">Nepal</option>
                                                                <option value="NI">Nicaragua</option>
                                                                <option value="NE">Níger</option>
                                                                <option value="NG">Nigeria</option>
                                                                <option value="NU">Niue</option>
                                                                <option value="NF">Norfolk</option>
                                                                <option value="NO">Noruega</option>
                                                                <option value="NC">Nueva Caledonia</option>
                                                                <option value="NZ">Nueva Zelanda</option>
                                                                <option value="OM">Omán</option>
                                                                <option value="PA">Panamá</option>
                                                                <option value="PG">Papua Nueva Guinea</option>
                                                                <option value="PK">Paquistán</option>
                                                                <option value="PY">Paraguay</option>
                                                                <option value="PE">Perú</option>
                                                                <option value="PN">Pitcairn</option>
                                                                <option value="PF">Polinesia francesa</option>
                                                                <option value="PL">Polonia</option>
                                                                <option value="PT">Portugal</option>
                                                                <option value="PR">Puerto Rico</option>
                                                                <option value="QA">Qatar</option>
                                                                <option value="UK">Reino Unido</option>
                                                                <option value="CF">República Centroafricana</option>
                                                                <option value="CZ">República Checa</option>
                                                                <option value="ZA">República de Sudáfrica</option>
                                                                <option value="CD">República Democrática del Congo Zaire
                                                                </option>
                                                                <option value="DO">República Dominicana</option>
                                                                <option value="RE">Reunión</option>
                                                                <option value="RW">Ruanda</option>
                                                                <option value="RO">Rumania</option>
                                                                <option value="RU">Rusia</option>
                                                                <option value="WS">Samoa</option>
                                                                <option value="AS">Samoa occidental</option>
                                                                <option value="KN">San Kitts y Nevis</option>
                                                                <option value="SM">San Marino</option>
                                                                <option value="PM">San Pierre y Miquelon</option>
                                                                <option value="VC">San Vicente e Islas Granadinas
                                                                </option>
                                                                <option value="SH">Santa Helena</option>
                                                                <option value="LC">Santa Lucía</option>
                                                                <option value="ST">Santo Tomé y Príncipe</option>
                                                                <option value="SN">Senegal</option>
                                                                <option value="YU">Serbia y Montenegro</option>
                                                                <option value="SC">Seychelles</option>
                                                                <option value="SL">Sierra Leona</option>
                                                                <option value="SG">Singapur</option>
                                                                <option value="SY">Siria</option>
                                                                <option value="SO">Somalia</option>
                                                                <option value="LK">Sri Lanka</option>
                                                                <option value="SZ">Suazilandia</option>
                                                                <option value="SD">Sudán</option>
                                                                <option value="SE">Suecia</option>
                                                                <option value="CH">Suiza</option>
                                                                <option value="SR">Surinam</option>
                                                                <option value="SJ">Svalbard</option>
                                                                <option value="TH">Tailandia</option>
                                                                <option value="TW">Taiwán</option>
                                                                <option value="TZ">Tanzania</option>
                                                                <option value="TJ">Tayikistán</option>
                                                                <option value="IO">Territorios británicos del océano
                                                                    Indico
                                                                </option>
                                                                <option value="TF">Territorios franceses del sur
                                                                </option>
                                                                <option value="TP">Timor Oriental</option>
                                                                <option value="TG">Togo</option>
                                                                <option value="TO">Tonga</option>
                                                                <option value="TT">Trinidad y Tobago</option>
                                                                <option value="TN">Túnez</option>
                                                                <option value="TM">Turkmenistán</option>
                                                                <option value="TR">Turquía</option>
                                                                <option value="TV">Tuvalu</option>
                                                                <option value="UA">Ucrania</option>
                                                                <option value="UG">Uganda</option>
                                                                <option value="UY">Uruguay</option>
                                                                <option value="UZ">Uzbekistán</option>
                                                                <option value="VU">Vanuatu</option>
                                                                <option value="VE">Venezuela</option>
                                                                <option value="VN">Vietnam</option>
                                                                <option value="WF">Wallis y Futuna</option>
                                                                <option value="YE">Yemen</option>
                                                                <option value="ZM">Zambia</option>
                                                                <option value="ZW">Zimbabue</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping_zone">{{ trans('iprofile::profiles.form.state') }}</label>
                                                            <select class="form-control" id="payment_zone"
                                                                    name="shipping_zone">
                                                                <option>Ibague</option>
                                                                <option>Cucuta</option>
                                                                <option>San Cristóbal</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                            <!-- /.box-body -->
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box-footer">
                                                    <button type="submit"
                                                            class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                                                </div>

                                            </div>
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>

                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="acount">
                                <div class="tab-pane">
                                    <div class="box-body">

                                      


                                        <div class="box ">
                                            <div class="box-header ">
                                                <h3 class="box-title">{{ trans('user::users.new password setup') }}</h3>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        {{ Form::normalInputOfType('password', 'password', trans('user::users.form.new password'), $errors) }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ Form::normalInputOfType('password', 'password_confirmation', trans('user::users.form.new password confirmation'), $errors) }}
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.box-body -->
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box-footer">
                                                    <button type="submit"
                                                            class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                            {!!Form::close()!!}

                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <div class="clearfix"></div>


            </div>
        </div>
    </div>


@stop

<style>
    .profile-img-overlay {
        position: relative;
        width: 100%;
    }

    .profile-img-overlay .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        -webkit-transition: .5s ease;
        transition: .5s ease;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50% !important;
    }

    .profile-img-overlay:hover .overlay {
        opacity: 1;
    }

    .list-group-unbordered {
        margin-bottom: 0;
    }

    .list-group-unbordered li:first-of-type {
        border-top: 0;
    }

    .list-group-unbordered li:last-of-type {
        border-bottom: 0;
    }

    .p-l-r-15 {
        padding-right: 15px !important;
        padding-left: 15px !important;
    }

    .p-l {
        padding-left: 15px !important;
    }
</style>

@push('js-stack')
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).keypressAction({
            actions: [
                {key: 'b', route: "<?= route('admin.account.profile.edit') ?>"}
            ]
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#image').each(function (index) {
            // Find DOM elements under this form-group element
            var $mainImage = $(this).find('#mainImage');
            var $uploadImage = $(this).find("#mainimage");
            var $hiddenImage = $(this).find("#hiddenImage");
            //var $remove = $(this).find("#remove")
            // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
            var options = {
                viewMode: 2,
                checkOrientation: false,
                autoCropArea: 1,
                responsive: true,
                preview: $(this).attr('data-preview'),
                aspectRatio: $(this).attr('data-aspectRatio')
            };


            // Hide 'Remove' button if there is no image saved
            if (!$mainImage.attr('src')) {
                //$remove.hide();
            }
            // Initialise hidden form input in case we submit with no change
            //$.val($mainImage.attr('src'));

            // Only initialize cropper plugin if crop is set to true

            $uploadImage.change(function () {
                var fileReader = new FileReader(),
                    files = this.files,
                    file;

                if (!files.length) {
                    return;
                }
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        $uploadImage.val("");
                        $mainImage.attr('src', this.result);
                        $hiddenImage.val(this.result);
                        $('#hiddenImage').val(this.result);

                    };
                } else {
                    alert("Por favor seleccione una imagen.");
                }
            });

        });
    });
</script>
<script>
    $(document).ready(function () {
        newid = 0;
        $("#add_row").on("click", function () {
            // Dynamic Rows Code

            // Get max row id and set new id
            newid = 0;
            $.each($("#tab_logic tr"), function () {
                if (parseInt($(this).data("id")) > newid) {
                    newid = parseInt($(this).data("id"));
                }
            });
            newid++;

            var tr = $("<tr></tr>", {
                id: "social[" + newid + "]",
                "data-id": newid
            });

            // loop through each td and create new elements with name of newid
            $.each($("#tab_logic tbody tr:nth(0) td"), function () {
                var cur_td = $(this);
                var name = $(cur_td).data("name");
                var children = cur_td.children();

                // add new td and element if it has a nane
                if ($(this).data("name") != undefined) {
                    var td = $("<td></td>", {
                        "data-name": name.substr(0, 7) + newid + name.substr(8)
                    });

                    var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");

                    c.attr("name", name.substr(0, 7) + newid + name.substr(8));
                    c.appendTo($(td));
                    td.appendTo($(tr));
                } else {
                    var td = $("<td></td>", {
                        'text': $('#tab_logic tr').length
                    }).appendTo($(tr));
                }
            });
            // add the new row
            $(tr).appendTo($('#tab_logic'));

            $(tr).find("td button.row-remove").on("click", function () {
                $(this).closest("tr").remove();
            });
        });
        // Sortable Code
        var fixHelperModified = function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();

            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width())
            });

            return $helper;
        };

        $(".table-sortable tbody").sortable({
            helper: fixHelperModified
        }).disableSelection();

        $(".table-sortable thead").disableSelection();

        // $("#add_row").trigger("click");
    });
</script>
<script type="text/javascript">
    $(function () {
        $('input[name="birthday"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                "locale": {
                    "format": "DD-MM-YYYY",
                    "separator": " - ",
                    "applyLabel": "Apply",
                    "cancelLabel": "Cancel",
                    "customRangeLabel": "Custom",
                    "weekLabel": "M",
                    "daysOfWeek": [
                        "D",
                        "L",
                        "M",
                        "Mi",
                        "J",
                        "V",
                        "S"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Augosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                }
            },
            function (start, end, label) {
                var years = moment().diff(start, 'years');
            });
    });
</script>


@endpush

