@extends('layouts.master')



  @section('content')
  
    <x-isite::breadcrumb>
      <li class="breadcrumb-item active" aria-current="page">{{trans('iprofile::frontend.title.profile')}}</li>
    </x-isite::breadcrumb>
  
  
  
    {{-- Need Publish --}}

  <div id="indexProfile" class="page page-profile">
    <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">

    <div class="container">
      <div class="row">

        <div class="col-lg-4 col-xl-3 mb-3">

          {{--################# MENU #################--}}
          @include('iprofile::frontend.partials.menu')

        </div> {{-- End col --}}

        <div class="col-lg-8 col-xl-9 mb-5">
          <div class="title border-bottom border-top-dotted border-bottom-dotted py-2 mt-3">
            <h1 class="h4 my-0 text-primary">
              @if(isset($user) &&  !empty($user->first_name))
                {{trans('iprofile::frontend.title.welcome')}}, {{$user->first_name}}
              @else
                {{trans('iprofile::frontend.title.user name')}}
              @endif
            </h1>
          </div>
          
            @include('iprofile::frontend.partials.edit-fields')
            
       
          

        </div> {{-- End col --}}

      </div>
    </div>
    
  </div>
  @stop

@section('scripts')
@parent

<script type="text/javascript">

$(document).ready(function () {
  $('#imgProfile').each(function (index) {
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
