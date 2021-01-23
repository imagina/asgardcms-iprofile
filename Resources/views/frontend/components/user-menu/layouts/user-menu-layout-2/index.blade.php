<div id="{{ $id }}" class="d-block py-2">
  
  <!--- LOGIN -->
    @if($user)
    
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-block">
    
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="d-inline  d-sm-none navbar-brand" href="#">{{trans("iprofile::frontend.button.my_account")}}</a>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto flex-column w-100">
          <li class="nav-item">
            <a class="dropdown-item"  href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.iprofile.account.index')}}">
              <i class="fa fa-user mr-2"></i> {{trans('iprofile::frontend.title.profile')}}
            </a>
          </li>
          @foreach($moduleLinks as $link)
            <li class="nav-item">
              <a class="dropdown-item"  href="{{ route($link['routeName']) }}">
                @if($link['icon'])<i class="{{ $link['icon'] }}"></i>@endif {{ trans($link['title']) }}
              </a>
            </li>
          @endforeach
          <li class="nav-item">
            <a class="dropdown-item" href="{{url('/account/logout')}}" data-placement="bottom"
               title="Sign Out">
              <i class="fa fa-sign-out mr-1"></i>
              <span>{{trans('iprofile::frontend.button.sign_out')}}</span>
            </a>
          </li>
        
        </ul>
      
      </div>
    </nav>
  @else
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-block">
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="d-inline  d-sm-none navbar-brand" href="#">{{trans("iprofile::frontend.button.my_account")}}</a>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto flex-column w-100">
          <li class="nav-item">
            <a class="dropdown-item"
              {{$openLoginInModal ? "data-toggle=modal data-target=#userLoginModal href=".route('account.login.get')."" : ''}}
            >
              <i class="fa fa-user mr-2"></i>{{trans('iprofile::frontend.button.sign_in')}}
            </a>
          </li>
        
            <li class="nav-item">
  
              <a class="dropdown-item" href="{{route('account.register')}}"
                {{$openRegisterInModal ? "data-toggle=modal data-target=#userRegisterModal  href=".route('account.register')."" : ''}}
              >
                <i class="fa fa-sign-out mr-2"></i>{{trans('iprofile::frontend.button.register')}}
              </a>
            </li>
       
        
        </ul>
      
      </div>
    </nav>
 
  @endif
  
  @if($openLoginInModal)
  <!-- User login modal -->
    <div class="modal fade" id="userLoginModal" tabindex="-1" aria-labelledby="userLoginModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userLoginModalLabel">{{ trans('user::auth.login') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @include('iprofile::frontend.widgets.login',["embedded" => true, "register" => false])
          </div>
        </div>
      </div>
    </div>
  @endif
  
  @if($openRegisterInModal)
  <!-- User register modal -->
    <div class="modal fade" id="userRegisterModal" tabindex="-1" aria-labelledby="userRegisterModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userRegisterModalLabel">{{ trans('user::auth.register') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @include('iprofile::frontend.widgets.register',["embedded" => true])
          </div>
        </div>
      </div>
    </div>
  @endif
  
    @section('scripts')
        <script type="text/javascript">
          $("#accMenuDrop").hover(function(){
            $(this).addClass("show");
            $('#drop-menu').addClass("show");
          }, function(){
            $(this).removeClass("show");
            $('#drop-menu').removeClass("show");
          });
        </script>
        @parent
    @endsection

</div>
