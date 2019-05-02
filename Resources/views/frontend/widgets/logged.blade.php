
@if(isset($user) && $user!=false)

<li>

    <div class="account-menu-wrapper">
        <div id="account-menu-trigger">
            @if(isset($user->profile->options->mainimage)&&!empty($user->profile->options->mainimage))
                <img class="img-circle"
                     width="28px"
                     src="{{url($user->profile->options->mainimage)}}"/>
            @else
                <img class="img-circle"
                     width="28px"
                     src="{{url('modules/iprofile/img/default.jpg')}}"/>
            @endif
            <span class="fa fa-angle-down"></span>
        </div>

        <ul id="account-menu">
            <li><a href="{{URL::to('/account')}}">Ver perfil</a></li>
            <li><a href="{{URL::route('account.profile.edit')}}">Configuración</a></li>
            <li><a href="{{URL::route('account.logout')}}">Salir</a></li>
        </ul>
    </div>

</li>

@else

<li class="entry">
    {{-- <a href="{{url('/acount')}}">Entrar</a> --}}
    <a href="{{route('login')}}"><i class="fa fa-user" aria-hidden="true"></i> Iniciar Sesión</a>
</li>

<li class="register">

    <a href="{{route('register')}}"><i class="fa fa-key" aria-hidden="true"></i> Regístrate</a>

    {{--<a href="{{url('/auth/register')}}" class="btn btn-primary" >Regístrate</a>--}}
</li>

@endif

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            /*$('#account-menu-trigger').click(function() {
                //event.stopPropagation();
                $('#account-menu').toggle();
            });*/

            /*$(document).click(function() {
                $('#account-menu').hide();
            });*/
        });
    </script>
@stop
