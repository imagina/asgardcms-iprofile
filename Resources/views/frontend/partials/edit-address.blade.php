<h4 class="mx-auto mb-3">{{trans('iprofile::profiles.title.addresses')}}</h4>

<div class="col-12">

    <div class="row">
        <div class="col-12 col-md-6 d-flex" v-for="(address,index) in addresses">
            <div class="card mb-3 w-100 text-left flex-fill">
                <div class="card-header bg-white">
                    <span v-if="addresses[index].type=='shipping'"
                          class="badge bg-primary text-white">{{trans('iprofile::addresses.default')}} @{{addresses[index].type}}</span>
                    <span v-else-if="addresses[index].type=='billing'" class="badge bg-primary text-white">{{trans('iprofile::addresses.default')}} @{{addresses[index].type}}</span>
                    <span v-else="addresses[index].type!=''" class="badge bg-white text-white">&nbsp;</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">@{{ address.firstname }} @{{ address.lastname }}</h5>
                    <p class="card-text">
                        @{{ address.address_1 }}<br>
                        @{{ address.city  }}, @{{ address.country }} <br>
                        {{trans('iprofile::addresses.form.post_code')}}:@{{ address.postcode  }}, @{{ address.zone  }}
                    </p>
                    <a @click="loadModelConfirm(index)" data-toggle="modal" data-target="#deleteAddress" class="card-link pull-right mx-2"><i class="fa fa-trash"
                                                                    aria-hidden="true"></i></a>
                    <a href="#" data-toggle="modal" @click="editAddress(address.id)" data-target="#editAddress"
                       class="card-link pull-right mx-2"><span class="edit_mode" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex">
            <div class="card mb-3 w-100 flex-fill">
                <div class="card-body text-center font-weight-bold d-flex align-items-center justify-content-center font-weight-bold">
                    <a href="" data-toggle="modal" data-target="#addAddress">
                        <i class="fa fa-plus"></i> <br>
                        {{trans('iprofile::addresses.messages.add_address')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAddress" tabindex="-1" role="dialog" aria-labelledby="editAddressTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialoeditedAddressg-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center font-weight-bold" id="editAddressTitle">{{trans('iprofile::addresses.messages.edit_address')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.first_name')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.firstname">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.last_name')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{trans('iprofile::addresses.form.company')}}</label>
                        <input type="text" class="form-control form-control-sm" v-model="editedAddress.company">
                    </div>
                    <div class="form-group">
                        <label>{{trans('iprofile::addresses.form.address1')}}</label>
                        <input type="text" class="form-control form-control-sm" v-model="editedAddress.address_1">
                    </div>
                    <div class="form-group">
                        <label>{{trans('iprofile::addresses.form.address2')}}</label>
                        <input type="text" class="form-control form-control-sm" v-model="editedAddress.address_2">
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.city')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.city">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.post_code')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.postcode">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 ">
                            <label>{{trans('iprofile::addresses.form.type.title')}}</label>
                            <select v-model="editedAddress.type" class="form-control form-control-sm">
                                <option value="">{{trans('iprofile::addresses.form.type.optional')}}</option>
                                <option value="shipping">{{trans('iprofile::addresses.form.type.default_ship')}}</option>
                                <option value="billing">{{trans('iprofile::addresses.form.type.default_bill')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <label>{{trans('iprofile::addresses.form.country')}}</label>
                            <select v-model="editedAddress.country" v-on:change="getCountriesJson(editedAddress.country, 2)" class="form-control form-control-sm">
                                <option value="null" selected='selected'>{{trans('iprofile::addresses.select.select_option')}}</option>
                                <option v-for="country in countries" v-bind:value="country.iso_2">@{{ country.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 ">
                            <label for="payment_zone">{{trans('iprofile::addresses.form.state')}}</label>
                            <select v-model="editedAddress.zone" class="form-control form-control-sm">
                                <option v-for="state in statesPayment" v-bind:value="state.name">@{{ state.name }}</option>
                                <option value="null">{{trans('iprofile::addresses.select.select_country')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right py-3">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">{{trans('iprofile::addresses.button.cancel')}}</button>
                        <button type="button" class="btn btn-primary text-white" @click="saveChangesEdited(editedAddress.id)" data-dismiss="modal">{{trans('iprofile::addresses.button.accept')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><div class="modal fade" id="deleteAddress" tabindex="-1" role="dialog" aria-labelledby="deleteAddressTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialoeditedAddressg-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center font-weight-bold" id="deleteAddressTitle">{{trans('iprofile::addresses.messages.edit_address')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row text-center">
                        <div class="form-group col-12 col-md-12">
                            <h3>{{trans('iprofile::addresses.messages.delete_address')}}</h3>
                        </div>
                    </div>
                    <div class="text-right py-3">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">{{trans('iprofile::addresses.button.cancel')}}</button>
                        <button type="button" class="btn btn-primary text-white" @click="deleteEvent()" data-dismiss="modal">{{trans('iprofile::addresses.button.confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAddress" tabindex="-1" role="dialog" aria-labelledby="addAddressTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center font-weight-bold" id="addAddressTitle">{{trans('iprofile::addresses.messages.add_address')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.first_name')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.firstname">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.last_name')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{trans('iprofile::addresses.form.company')}}</label>
                        <input type="text" class="form-control form-control-sm" v-model="newAddress.company">
                    </div>
                    <div class="form-group">
                        <label>{{trans('iprofile::addresses.form.address1')}}</label>
                        <input type="text" class="form-control form-control-sm" v-model="newAddress.address_1">
                    </div>
                    <div class="form-group">
                        <label>{{trans('iprofile::addresses.form.address2')}}</label>
                        <input type="text" class="form-control form-control-sm" v-model="newAddress.address_2">
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.city')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.city">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>{{trans('iprofile::addresses.form.post_code')}}</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.postcode">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 ">
                            <label>{{trans('iprofile::addresses.form.type.title')}}</label>
                            <select v-model="newAddress.type" class="form-control form-control-sm">
                                <option value="" selected='selected'>{{trans('iprofile::addresses.form.type.optional')}}</option>
                                <option value="shipping">{{trans('iprofile::addresses.form.type.default_ship')}}</option>
                                <option value="billing">{{trans('iprofile::addresses.form.type.default_bill')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <label>{{trans('iprofile::addresses.form.country')}}</label>
                            <select v-model="newAddress.country" v-on:change="getCountriesJson(newAddress.country, 2)" class="form-control form-control-sm">
                                <option value="null" selected='selected'>{{trans('iprofile::addresses.select.select_option')}}</option>
                                <option v-for="country in countries" v-bind:value="country.iso_2">@{{ country.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 ">
                            <label for="payment_zone">{{trans('iprofile::addresses.form.state')}}</label>
                            <select v-model="newAddress.zone" class="form-control form-control-sm">
                                <option v-for="state in statesPayment" v-bind:value="state.name">@{{ state.name }}</option>
                                <option value="null">{{trans('iprofile::addresses.select.select_country')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right py-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('iprofile::addresses.button.cancel')}}</button>
                        <button type="button" class="btn btn-primary text-white" @click="saveNewAddress()" data-dismiss="modal">{{trans('iprofile::addresses.messages.add_new_address')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
