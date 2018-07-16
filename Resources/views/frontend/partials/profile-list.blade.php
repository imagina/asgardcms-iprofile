<ul class="list-group w-100">
  	<li class="list-group-item {{$menu==1 ? 'active' : ''}}">
		<a href="{{URL::route('account.profile.edit')}}"
		   class="btn-custom w-100 {{$menu==1 ? 'text-white' : ''}}">
		    <i class="fa fa-pencil-square-o"
		       aria-hidden="true">
		    </i>
		    <strong>
		        {{trans('iprofile::profiles.title.edit profile')}}
		    </strong>
		</a>
	</li>
  	<li class="list-group-item {{$menu==2 ? 'active' : ''}}">
		<a  class="btn-custom w-100 {{$menu==2 ? 'text-white' : ''}}"
		    href="{{url('/wishlist')}}" >
		    <i class="fa fa-heart"></i>
		    <strong>
		        My Wishlist
		    </strong>
		</a>
  	</li>
  	<li class="list-group-item {{$menu==3 ? 'active' : ''}}">
		<a  class="btn-custom w-100 {{$menu==3 ? 'text-white' : ''}}"
		    href="{{url('/orders')}}">
		    <i class="fa fa-shopping-bag"></i>
		    <strong>
		        Order List
		    </strong>
		</a>
  	</li>
  	<li class="list-group-item {{$menu==3 ? 'active' : ''}}">
		<a  class="btn-custom w-100 {{$menu==3 ? 'text-white' : ''}}"   
		    href="{{url('/account/logout')}}" 
		    data-placement="bottom" 
		    title="Sign Out">
		    <i class="fa fa-sign-out"></i> 
		    <strong>
		        Sign Out
		    </strong>
		</a>
  	</li>
</ul>

        