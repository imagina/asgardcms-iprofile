
<div class="filter-categories mb-4">
   
   <div class="title">
      <a data-toggle="collapse" href="#collapseCategories" role="button" aria-expanded="true" aria-controls="collapseManufacturers" class="collapse">
         
         <h5 class="p-3 border-top border-bottom">
         Test
            <i class="fa fa angle float-right" aria-hidden="true"></i>
         </h5>
      
      </a>
   </div>
   
   <div class="collapse " id="collapseCategories">
      <div class="row">
         <div class="col-12">
            <div class="list-categories">
               <ul class="list-group list-group-flush">
               
               
               
               
               </ul>
            </div>
         </div>
      </div>
   </div>

</div>

<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

   <a class="nav-link @if($user->roles->first()->slug!='client') active @endif" id="v-pills-edit-tab" data-toggle="pill" href="#v-pills-edit"
   role="tab" aria-controls="v-pills-edit" aria-selected="true"><i class="fa fa-edit mr-2" onclick="$('#img-profile').show();$('#img-profile-store').hide();"></i>
      {{trans('iprofile::frontend.title.profile')}}
   </a>

   @if(Auth::user()->hasAccess(['imarketplace.coupons.edit']))
      <a class="nav-link" id="v-pills-cupones-tab" data-toggle="pill" href="#v-pills-cupones"
                        role="tab" aria-controls="v-pills-cupones" aria-selected="false"><i
      class="fa fa-tags mr-2" onclick="$('#img-profile').hide();$('#img-profile-store').show();"></i>Redimir Cupones</a>

   @endif

   @if(Auth::user()->hasAccess(['imarketplace.coupons.index']))
      <a class="nav-link" id="v-pills-cupones-index-tab" data-toggle="pill" href="#v-pills-cupones-index"
                       role="tab" aria-controls="v-pills-cupones-index" aria-selected="false"><i
                                class="fa fa-tags mr-2"></i>Mis Cupones</a>

   @endif

   @if(Auth::user()->hasAccess(['iredeems.points.index']))
      <a class="nav-link" id="v-pills-puntos-tab" data-toggle="pill" href="#v-pills-puntos"
                       role="tab" aria-controls="v-pills-puntos" aria-selected="false"><i
                                class="fa fa-star mr-2"></i>Mis Puntos</a>

   @endif

   <a class="nav-link" href="{{url('/account/logout')}}"><i class="fa fa-sign-out mr-2"></i>
      {{trans('iprofile::frontend.button.sign_out')}}
   </a>

</div>


