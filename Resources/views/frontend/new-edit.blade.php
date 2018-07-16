@extends('layouts.master')

@section('content-header')
  <h1>{{trans('iprofile::profiles.title.create profile') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard.index') }}"><i
          class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ route('account.profile.edit') }}">{{ trans('iprofile::profiles.title.profiles') }}</a>
    </li>
    <li class="active">{{ trans('iprofile::profiles.title.create profile') }}</li>
  </ol>
@stop

@section('content')
  <div class="bg-breadcrumb"></div>

  {!! Form::open(['route' => ['iprofile.profile.update', $profile->id], 'method' => 'put']) !!}
  <div id="editProfile" class="bg-content">

    <div class="container">
      <div class="row profile-default py-5">
        <div class="col-12">
          <div class="row">
          @include('iprofile::frontend.partials.edit-user-details')

          @include('iprofile::frontend.partials.edit-user-courses')
          <!-- /.col -->
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}

@stop

@section('scripts')
  @parent
  {{--<script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous">
  </script>--}}
  <link media="all" type="text/css" rel="stylesheet"
        href="{{url('/themes/adminlte/vendor/admin-lte/plugins/daterangepicker/daterangepicker.css')}}">
  <script src="{{url('/themes/adminlte/vendor/admin-lte/plugins/daterangepicker/moment.min.js')}}"
          type="text/javascript"></script>
  <script src="{{url('/themes/adminlte/vendor/admin-lte/plugins/daterangepicker/daterangepicker.js')}}"
          type="text/javascript"></script>
  <script src="{{url('/themes/adminlte/js/vendor/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

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
            "weekLabel": "M"
          }
        },
        function (start, end, label) {
          var years = moment().diff(start, 'years');
        });
    });
  </script>

  <script type="text/javascript">
    var editProfile = new Vue({
      el: '#editProfile',
      mounted: function () {
        axios.get('https://ecommerce.imagina.com.co/api/ilocations/allmincountries')
          .then(function (response) {
            if (response.status == 200){
                editProfile.countries = response.data;
                //console.log('Countries:');
                //console.log(editProfile.countries);
            }
          });
        // if (this.address != "") {
        //   //this.shippingData.country = this.address.shipping_country;
        //   //this.paymentData.country = this.address.payment_country;
        //
        //   this.getCountriesJson(this.shippingData.country, 1);
        //   this.getCountriesJson(this.paymentData.country, 2);
        //
        //   this.shippingData.state = this.address.shipping_zone;
        //   this.paymentData.state = this.address.payment_zone;
        //
        //   this.paymentData.first_name = this.address.payment_firstname;
        //   this.paymentData.last_name = this.address.payment_lastname;
        //   this.paymentData.company = this.address.payment_company;
        //   this.paymentData.address1 = this.address.payment_address_1;
        //   this.paymentData.address2 = this.address.payment_address_2;
        //   this.paymentData.city = this.address.payment_city;
        //   this.paymentData.postcode = this.address.payment_postcode;
        //
        //   this.shippingData.first_name = this.address.shipping_firstname;
        //   this.shippingData.last_name = this.address.shipping_lastname;
        //   this.shippingData.company = this.address.shipping_company;
        //   this.shippingData.address1 = this.address.shipping_address_1;
        //   this.shippingData.address2 = this.address.shipping_address_2;
        //   this.shippingData.city = this.address.shipping_city;
        //   this.shippingData.postcode = this.address.shipping_postcode;
        //
        // }
      },
      data: {
        profile:{!! $profile ? $profile : "''"  !!},
        addresses: {!! $addresses ? $addresses : "''"!!},
        addressesEncoded: {!! $addressesEncoded ? $addressesEncoded : "''"!!},
        social:{!!$profile->social ? json_encode($profile->social) : "''" !!},
        user: {!! $user !!},
        countries: [],
        statesPayment: [],
        statesShipping: [],
        statesPaymentAlternative: false,
        statesShippingAlternative: false,
        indexToDelete:'',
        editedAddress: {
          id: '',
          firstname: '',
          lastname: '',
          company: '',
          address_1: '',
          address_2: '',
          city: '',
          postcode: '',
          country: '',
          zone: '',
        },
        newAddress: {
          id: '',
          firstname: '',
          lastname: '',
          company: '',
          address_1: '',
          address_2: '',
          city: '',
          postcode: '',
          country: '',
          zone: '',
          profile_id:''
        },
        shippingData: {
          first_name: '',
          last_name: '',
          company: '',
          address1: '',
          address2: '',
          city: '',
          postcode: '',
          country: '',
          state: '',
        }
      },
      created: function () {
        //console.log(this.addresses);
        //console.log(this.addressesEncoded);
      },
      methods: {
        addSocial: function () {
          console.log(this.social.length);
          if (!this.social) {
            this.social = [];
          }
          this.social.push({
            label: '',
            desc: '',
          });
        },
        removeSocial: function (index) {
          this.social.splice(index, 1);
        },
        addLabel: function (index, label) {
          this.social[index].label = label;
        },
        getCountriesJson: function (iso, component) {
          if (iso != null && iso != "") {
            axios.get('https://ecommerce.imagina.com.co/api/ilocations/allprovincesbycountry/iso2/' + iso)
              .then(response => {
                //data is the JSON string
                if (component == 1) {
                  editProfile.statesShipping = response.data;
                  editProfile.statesShippingAlternative = !editProfile.statesShipping.length;
                }
                else if (component == 2) {
                  editProfile.statesPayment = response.data;
                  editProfile.statesPaymentAlternative = !editProfile.statesPayment.length;
                }
              }).catch(error => {
              console.log(error)
            });
          }
        },
        loadModelConfirm:function(index){
          this.indexToDelete=index;
        },
        deleteEvent: function (index) {
          //console.log('Index de address a borrar: '+index);
          //console.log(index);
          //console.log(this.addresses);
          //console.log('Index to delete: '+this.indexToDelete);
          this.addresses.splice(this.indexToDelete, 1);
          //this.addressesEncoded.splice(this.indexToDelete, 1);
          this.saveChangesAddress();
        },
        editAddress: function(index){
            //console.log('Index to edit: '+index);
            //console.log(this.addresses);
            for (var i = 0; i < this.addresses.length; i++) {
                if (this.addresses[i]['id'] == index) {
                    //console.log('Address finded'+this.addresses[i]['country']);
                this.editedAddress.id=index;
                this.editedAddress.firstname=this.addresses[i]['firstname'];
                this.editedAddress.lastname=this.addresses[i]['lastname'];
                this.editedAddress.address_1=this.addresses[i]['address_1'];
                this.editedAddress.address_2=this.addresses[i]['address_2'];
                this.editedAddress.city=this.addresses[i]['city'];
                this.editedAddress.company=this.addresses[i]['company'];
                this.editedAddress.country=this.addresses[i]['country'];
                this.editedAddress.zone=this.addresses[i]['zone'];
                this.editedAddress.postcode=this.addresses[i]['postcode'];
                this.editedAddress.type=this.addresses[i]['type'];
                this.getCountriesJson(this.editedAddress.country, 2);
                break;
                }
            }//for
        },
        saveChangesEdited: function(index){
            //console.log('Index of address: '+index);
            var countShipping = 0;
            var countBilling = 0;
            for (var i = 0; i < this.addresses.length; i++) {
                if (this.addresses[i]['type'] == 'billing' && this.editedAddress.id!=this.addresses[i]['id']) {
                    countBilling++;
                    if(countBilling>1)
                        this.addresses[i]['type']='';
                    //console.log('one billing');
                } else if (this.addresses[i]['type'] == 'shipping' && this.editedAddress.id!=this.addresses[i]['id']) {
                    countShipping++;
                    if(countShipping>1)
                        this.addresses[i]['type']='';
                    //console.log('one shipping');
                }
            }//for
            if(this.editedAddress.firstname==""){
                this.alerta("The first name field can not be empty", "error");
            }
            else if(this.editedAddress.lastname=="")
                this.alerta("The last name field can not be empty", "error");
            else if(this.editedAddress.address_1=="")
                this.alerta("You must enter an address", "error");
            else if(this.editedAddress.city=="")
                this.alerta("You must enter an city", "error");
            else if(this.editedAddress.postcode=="")
                this.alerta("You must enter an postal code", "error");
            else if(this.editedAddress.type=='billing' && countBilling>0)
                this.alerta("There can only be one address like default billing ", "error");
            else if(this.editedAddress.type=='shipping' && countShipping>0)
                this.alerta("There can only be one address like default shipping", "error");
            else if(this.editedAddress.country=="" || this.editedAddress.country=="null")
                this.alerta("You must select a country", "error");
            else if(this.editedAddress.zone=="" || this.editedAddress.country=="null")
                this.alerta("You must select a state/province", "error");
            else{
                for (var i = 0; i < this.addresses.length; i++) {
                    if (this.addresses[i]['id'] == index) {
                        //console.log('Address finded'+this.addresses[i]['country']);
                        this.addresses[i]['firstname']=this.editedAddress.firstname;
                        this.addresses[i]['lastname']=this.editedAddress.lastname;
                        this.addresses[i]['address_1']=this.editedAddress.address_1;
                        this.addresses[i]['address_2']=this.editedAddress.address_2;
                        this.addresses[i]['city']=this.editedAddress.city;
                        this.addresses[i]['company']=this.editedAddress.company;
                        this.addresses[i]['postcode']=this.editedAddress.postcode;
                        this.addresses[i]['type']=this.editedAddress.type;
                        this.addresses[i]['country']=this.editedAddress.country;
                        this.addresses[i]['zone']=this.editedAddress.zone;
                        break;
                    }
                }//for
                this.saveChangesAddress();
            }
        },
        saveChangesAddress: function () {
          //console.log('Address to update: ');
          //console.log(this.addresses);
          var countShipping = 0;
          var countBilling = 0;
          for (var i = 0; i < this.addresses.length; i++) {
            if (this.addresses[i]['type'] == 'billing') {
              countBilling++;
              if(countBilling>1)
                  this.addresses[i]['type']='';
              //console.log('one billing');
            } else if (this.addresses[i]['type'] == 'shipping') {
              countShipping++;
                if(countShipping>1)
                    this.addresses[i]['type']='';
              //console.log('one shipping');
            }
          }//for
          if (countShipping < 2 && countBilling < 2) {
            axios.post('{{ url("account/update_address") }}', [this.addresses]).then(response => {
              if (response.data.status) {
                this.alerta("The addresses have been updated correctly.", "success");
                //this.addressesEncoded = [];
                this.addresses = [];
                this.addresses = response.data.addresses;
                //this.addressesEncoded = response.data.addressesEncoded;
              } else {
                this.alerta("There was a problem updating the data.", "error");
              }
            }).catch(error => {
              console.log(error);
            });
          } else
            this.alerta("There can only be one address like default billing and an address like default shipping", "error");
        },
        saveNewAddress: function(){
          //console.log('New address to save: ');
          //console.log(this.newAddress);
            var countShipping = 0;
            var countBilling = 0;
            for (var i = 0; i < this.addresses.length; i++) {
                if (this.addresses[i]['type'] == 'billing') {
                    countBilling++;
                    if(countBilling>1)
                        this.addresses[i]['type']='';
                    //console.log('one billing');
                } else if (this.addresses[i]['type'] == 'shipping') {
                    countShipping++;
                    if(countShipping>1)
                        this.addresses[i]['type']='';
                    //console.log('one shipping');
                }
            }//for
            if(this.newAddress.firstname=="")
                this.alerta("The first name field can not be empty", "error");
            else if(this.newAddress.lastname=="")
                this.alerta("The last name field can not be empty", "error");
            else if(this.newAddress.address_1=="")
                this.alerta("You must enter an address", "error");
            else if(this.newAddress.city=="")
                this.alerta("You must enter an city", "error");
            else if(this.newAddress.postcode=="")
                this.alerta("You must enter an postal code", "error");
            else if(this.newAddress.type=='billing' && countBilling>0){
                this.alerta("There can only be one address like default billing ", "error");
                this.newAddress.type=='';
            }
            else if(this.newAddress.type=='shipping' && countShipping>0){
                this.alerta("There can only be one address like default shipping", "error");
                this.newAddress.type=='';
            }
            else if(this.newAddress.country=="" || this.newAddress.country=="null")
                this.alerta("You must select a country", "error");
            else if(this.newAddress.zone=="" || this.newAddress.country=="null")
                this.alerta("You must select a state/province", "error");
            else{
                axios.post('{{ url("account/save_new_address") }}', [this.newAddress]).then(response => {
                    if (response.data.status) {
                        this.alerta("The address has been stored correctly in the database..", "success");
                        //console.log(response.data.addresses);
                        this.newAddress.firstname='';
                        this.newAddress.lastname='';
                        this.newAddress.zone='';
                        this.newAddress.country='';
                        this.newAddress.type='';
                        this.newAddress.address_1='';
                        this.newAddress.address_2='';
                        this.newAddress.postcode='';
                        this.newAddress.city='';
                        this.newAddress.company='';
                        this.statesPayment=[];
                        this.addresses = response.data.addresses;
                    } else {
                        this.alerta("There was a problem trying to save the new address", "error");
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        alerta: function (menssage, type) {
          toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 400,
            "hideDuration": 400,
            "timeOut": 4000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };
          toastr[type](menssage);
        },
      }
    });
  </script>
@stop