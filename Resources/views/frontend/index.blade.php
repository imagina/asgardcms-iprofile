@extends('layouts.master')

@section('content-header')
<h1>{{trans('iprofile::frontend.title.create profile') }}</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('dashboard.index') }}"><i
    class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ route('account.profile.edit') }}">{{ trans('iprofile::frontend.title.profiles') }}</a>
    </li>
    <li class="active">{{ trans('iprofile::frontend.title.create profile') }}</li>
  </ol>
  @stop

  @section('content')

  {{-- Need Publish --}}
  <link href="{!! Module::asset('iprofile:css/base.css') !!}" rel="stylesheet" type="text/css" />

  <div id="index-profile" class="page page-profile">
    <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">


    @php

        // Images to Banner
        $imageBg = 'modules/iprofile/img/banner-default.jpg';
        
        if($user->roles->first()->slug=="client"){
          $title =  trans('iprofile::frontend.title.profile client');
          $imageBg = 'assets/media/paginas/perfil-cliente.jpg';
        }

        if($user->roles->first()->slug=="user"){
          $title = trans('iprofile::frontend.title.profile user');
          //$imageBg = 'assets/media/paginas/perfil-usuario.jpg';
        }

        if($user->roles->first()->slug!="user" && $user->roles->first()->slug!="client"){
          $title = trans('iprofile::frontend.title.profile general');
          //$imageBg = 'assets/media/paginas/perfil-usuario.jpg';
        }

        // Profile default
        $defaultImage = url('modules/iprofile/img/default.jpg');

    @endphp

    {{--################# BANNER #################--}}
    @include('iprofile::frontend.partials.banner-up',[
      'title' => $title,
      'imageBg' => $imageBg
    ])

    <div class="container">
      <div class="row">

        <div class="col-lg-4 col-xl-3 mb-5">


          {{--################# IMAGE #################--}}
          @if(Auth::user()->hasAccess(['icommerce.stores.index']))
            @php
              $defaultImage = Theme::url("img/cliente.jpg");
            @endphp
            @include('iprofile::frontend.partials.image-store',[
            'default' => $defaultImage
            ])
          @endif

          @include('iprofile::frontend.partials.image-account',[
          'default' => $defaultImage
          ])
          <hr class="border-top-dotted">

          {{--################# MENU #################--}}
          @include('iprofile::frontend.partials.menu')

        </div> {{-- End col --}}

        <div class="col-lg-8 col-xl-9 mb-5">

          {{--################# COUPON BTN #################--}}
          @if(Auth::user()->hasAccess(['imarketplace.coupons.edit']))
            @include('imarketplace.partials.btn-redeem-coupons')
          @endif

          <div class="border-top title border-bottom border-top-dotted border-bottom-dotted py-4 my-5">
            <h1 class="my-0 text-primary">
                @if(isset($user) &&  !empty($user->first_name))
                  {{trans('iprofile::frontend.title.welcome')}} {{$user->first_name}}
                @else
                  {{trans('iprofile::frontend.title.user name')}}
                @endif
            </h1>
          </div>

          <div class="tab-content" id="v-pills-tabContent">

            {{--################# Edit Fields Client - Iprofile  #################--}}
            <div class="tab-pane fade show @if($user->roles->first()->slug!='client') active @endif" id="v-pills-edit" role="tabpanel"
              aria-labelledby="v-pills-edit-tab">

              @if($user->roles->first()->slug=="client")
                @include('iprofile::frontend.partials.edit-fields-client')
              @else
                @include('iprofile::frontend.partials.edit-fields')
              @endif

            </div>

            {{--################# Edit Store - Icommerce  #################--}}
            @if(Auth::user()->hasAccess(['icommerce.stores.index']))
              <div class="tab-pane fade @if($user->roles->first()->slug=='client') active @endif" id="v-pills-tienda" role="tabpanel"
                aria-labelledby="v-pills-tienda-tab">
                
                @if(View::exists('icommerce.partials.edit-store'))
                  @include('icommerce.partials.edit-store')
                @else
                  <div class="alert alert-danger" role="alert">
                    "icommerce.partials.edit-store" not found
                  </div>
                @endif
                
              </div>
            @endif

            {{--################# Partial Products - Icommerce  #################--}}
            @if(Auth::user()->hasAccess(['icommerce.products.index']))
              <div class="tab-pane fade" id="v-pills-productos" role="tabpanel"
              aria-labelledby="v-pills-productos-tab">
                
              @if(View::exists('icommerce.partials.products-store'))
                @include('icommerce.partials.products-store')
              @else
                <div class="alert alert-danger" role="alert">
                  "icommerce.partials.products-store" not found
                </div>
              @endif
  
              </div>
            @endif

            {{--################# Partial Coupons - Imarketplace #################--}}
            @if(Auth::user()->hasAccess(['imarketplace.coupons.edit']))
              <div class="tab-pane fade" id="v-pills-cupones" role="tabpanel"
              aria-labelledby="v-pills-cupones-tab">
              
                @if(View::exists('imarketplace.partials.redeem-coupons'))
                  @include('imarketplace.partials.redeem-coupons')
                @else
                  <div class="alert alert-danger" role="alert">
                    "imarketplace.partials.redeem-coupons" not found
                  </div>
                @endif
              
              </div>
            @endif

            {{--################# Partial Coupons User - Imarketplace #################--}}
            @if(Auth::user()->hasAccess(['imarketplace.coupons.index']))
              <div class="tab-pane fade" id="v-pills-cupones-index" role="tabpanel"
              aria-labelledby="v-pills-cupones-index-tab">
              
              @if(View::exists('imarketplace.partials.user-coupons'))
                @include('imarketplace.partials.user-coupons')
              @else
                <div class="alert alert-danger" role="alert">
                  "imarketplace.partials.user-coupons" not found
                </div>
              @endif
               
              </div>
            @endif

            {{--################# Partial User Points - Iredeems #################--}}
            @if(Auth::user()->hasAccess(['iredeems.points.index']))
              <div class="tab-pane fade" id="v-pills-puntos" role="tabpanel"
              aria-labelledby="v-pills-puntos-tab">

              @if(View::exists('imarketplace.partials.user-points'))
                @include('imarketplace.partials.user-points')
              @else
                <div class="alert alert-danger" role="alert">
                  "imarketplace.partials.user-points" not found
                </div>
              @endif

              </div>
            @endif

          </div>

        </div> {{-- End col --}}

      </div>
    </div>


    {{--################# BANNER - IBanner #################--}}
    <div class="container mx-auto text-center my-5">
      {{--
        Add Banner Module
      {!!ibanner(5,'ibanners.widgets.carousel.banners')!!}
      --}}
    </div>

  </div>
  @stop

@section('scripts')
@parent

<script type="text/javascript">

$(document).ready(function () {
  $('#img-profile').each(function (index) {
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
        alert("{{trans('iprofile::frontend.messages.select_image')}}");
      }
    });

  });
});
</script>


@stop
