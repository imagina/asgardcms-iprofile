<div id="{{ $id }}" class="d-inline-block">
    <!--- LOGIN -->
    @if($user)
        @php
          $userData = $user['data'];
        @endphp
        <div  class="account-menu dropdown d-inline-block" id="accMenuDrop">
            <button class="btn  dropdown-toggle" type="button"
                    id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">


                @if($showLabel)
                    <span class="username text-truncate aling-middle">
                            <?php if ($userData->firstName != ' '): ?>
                                <?= $userData->firstName; ?>
                            <?php else: ?>
                                <em>{{trans('core::core.general.complete your profile')}}.</em>
                            <?php endif; ?>
                    </span>
                @else
                    <i class="fa fa-user" aria-hidden="true"></i>
                @endif
            </button>
            <div id="drop-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
                <div class="dropdown-item text-center ">
                    <!-- Nombre -->
                    @if($userData->mainImage)
                        <img class="i-circle rounded-circle border border-dark" style="width: 20px;"
                             src="{{$userData->mainImage}}"/>
                    @else
                        <img class="i-circle rounded-circle border border-dark" style="width: 20px;"
                             src="{{url('modules/iprofile/img/default.jpg')}}"/>
                    @endif

                    <span class="username text-truncate aling-middle">
                    <?php if ($userData->firstName != ' '): ?>
                        <?= $userData->firstName; ?>
                    <?php else: ?>
                        <em>{{trans('core::core.general.complete your profile')}}.</em>
                    <?php endif; ?>
                    </span>
                </div>
                <a class="dropdown-item"  href="{{url('/account')}}">
                    <i class="fa fa-user mr-2"></i> {{trans('iprofile::frontend.title.profiles')}}
                </a>
                @if(is_module_enabled('Icommerce'))
                    <a class="dropdown-item"  href="{{url('/orders')}}">
                        <i class="fa fa-bars mr-2"></i> {{ trans('iprofile::frontend.button.order_list') }}
                    </a>
                    <a class="dropdown-item"  href="{{url('/orders')}}">
                        <i class="fa fa-exclamation-circle mr-2"></i> {{ trans('iprofile::frontend.button.returns') }}
                    </a>
                    <a class="dropdown-item"  href="{{url('/wishlist')}}">
                        <i class="fa fa-heart mr-2"></i> {{ trans('iprofile::frontend.button.my_wishlist') }}
                    </a>
                @endif
                @foreach($moreOptions as $option)
                    <a class="dropdown-item"  href="{{ $option['url'] }}">
                        @if($option['icon'])<i class="{{ $option['icon'] }}"></i>@endif {{ $option['label'] }}
                    </a>
                @endforeach
                <a class="dropdown-item" href="{{url('/account/logout')}}" data-placement="bottom"
                   title="Sign Out">
                    <i class="fa fa-sign-out mr-1"></i>
                    <span class="d-none d-lg-inline-block">{{trans('iprofile::frontend.button.sign_out')}}</span>
                </a>
            </div>

        </div>
    @else
        <div class="account-menu dropdown d-inline-block" id="accMenuDrop">
            <button class="btn  dropdown-toggle" type="button"
                    id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <div class="cart d-inline-block">
                    @if($showLabel)
                        <span class="d-md-none d-lg-inline-block"> {{ trans('iprofile::frontend.button.my_account') }}</span>
                    @endif
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
            </button>

            <div id="drop-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
                <a class="dropdown-item" href="{{route('login')}}">
                    <i class="fa fa-user mr-2"></i>{{trans('iprofile::frontend.button.sign_in')}}
                </a>
                <a class="dropdown-item" href="{{route('account.register')}}">
                    <i class="fa fa-sign-out mr-2"></i>{{trans('iprofile::frontend.button.register')}}
                </a>
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
