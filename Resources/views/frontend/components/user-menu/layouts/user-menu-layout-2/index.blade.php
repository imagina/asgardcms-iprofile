<div id="{{ $id }}" class="d-block py-2">
    <!--- LOGIN -->
    @if($user)
        @php
          $userData = $user['data'];
        @endphp
        <div  class="account-menu d-block" id="accMenuDrop">
            
                <a class="dropdown-item"  href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.iprofile.account.index')}}">
                    <i class="fa fa-user mr-2"></i> {{trans('iprofile::frontend.title.profile')}}
                </a>
                @foreach($moduleLinks as $link)
                    <a class="dropdown-item"  href="{{ route($link['routeName']) }}">
                        @if($link['icon'])<i class="{{ $link['icon'] }}"></i>@endif {{ trans($link['title']) }}
                    </a>
                @endforeach
                <a class="dropdown-item" href="{{url('/account/logout')}}" data-placement="bottom"
                   title="Sign Out">
                    <i class="fa fa-sign-out mr-1"></i>
                    <span class="d-none d-lg-inline-block">{{trans('iprofile::frontend.button.sign_out')}}</span>
                </a>
       
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
