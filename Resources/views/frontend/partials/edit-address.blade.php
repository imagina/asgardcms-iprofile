<h4 class="mx-auto mb-3">{{trans('iprofile::profiles.title.addresses')}}</h4>

<div class="col-12">

    <div class="row">
        <div class="col-12 col-md-6 d-flex" v-for="(address,index) in addresses">
            <div class="card mb-3 w-100 text-left flex-fill">
                <div class="card-header bg-white">
                    <span v-if="addresses[index].type=='shipping'"
                          class="badge bg-primary text-white">default @{{addresses[index].type}}</span>
                    <span v-else-if="addresses[index].type=='billing'" class="badge bg-primary text-white">default @{{addresses[index].type}}</span>
                    <span v-else="addresses[index].type!=''" class="badge bg-white text-white">&nbsp;</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">@{{ address.firstname }} @{{ address.lastname }}</h5>
                    <p class="card-text">
                        @{{ address.address_1 }}<br>
                        @{{ address.city  }}, @{{ address.country }} <br>
                        Postal Code:@{{ address.postcode  }}, @{{ address.zone  }}
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
                        Add addreess
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
                <h5 class="modal-title text-center font-weight-bold" id="editAddressTitle">Edit Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>First name</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.firstname">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Last name</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" class="form-control form-control-sm" v-model="editedAddress.company">
                    </div>
                    <div class="form-group">
                        <label>Address 1</label>
                        <input type="text" class="form-control form-control-sm" v-model="editedAddress.address_1">
                    </div>
                    <div class="form-group">
                        <label>Address 2</label>
                        <input type="text" class="form-control form-control-sm" v-model="editedAddress.address_2">
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.city">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Postal Code</label>
                            <input type="text" class="form-control form-control-sm" v-model="editedAddress.postcode">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 ">
                            <label>Type</label>
                            <select v-model="editedAddress.type" class="form-control form-control-sm">
                                <option value="">Optional</option>
                                <option value="shipping">Default shipping</option>
                                <option value="billing">Default billing</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <label>Country</label>
                            <select v-model="editedAddress.country" v-on:change="getCountriesJson(editedAddress.country, 2)" class="form-control form-control-sm">
                                <option value="null" selected='selected'>Choose option</option>
                                <option v-for="country in countries" v-bind:value="country.iso_2">@{{ country.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 ">
                            <label for="payment_zone">State/Province</label>
                            <select v-model="editedAddress.zone" class="form-control form-control-sm">
                                <option v-for="state in statesPayment" v-bind:value="state.name">@{{ state.name }}</option>
                                <option value="null">Select country</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right py-3">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary text-white" @click="saveChangesEdited(editedAddress.id)" data-dismiss="modal">Accept</button>
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
                <h5 class="modal-title text-center font-weight-bold" id="deleteAddressTitle">Edit Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row text-center">
                        <div class="form-group col-12 col-md-12">
                            <h3>Are you sure you delete this address?</h3>
                        </div>
                    </div>
                    <div class="text-right py-3">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary text-white" @click="deleteEvent()" data-dismiss="modal">Confirm</button>
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
                <h5 class="modal-title text-center font-weight-bold" id="addAddressTitle">Add Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>First name</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.firstname">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Last name</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" class="form-control form-control-sm" v-model="newAddress.company">
                    </div>
                    <div class="form-group">
                        <label>Address 1</label>
                        <input type="text" class="form-control form-control-sm" v-model="newAddress.address_1">
                    </div>
                    <div class="form-group">
                        <label>Address 2</label>
                        <input type="text" class="form-control form-control-sm" v-model="newAddress.address_2">
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.city">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label>Postal Code</label>
                            <input type="text" class="form-control form-control-sm" v-model="newAddress.postcode">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6 ">
                            <label>Type</label>
                            <select v-model="newAddress.type" class="form-control form-control-sm">
                                <option value="" selected='selected'>Optional</option>
                                <option value="shipping">Default shipping</option>
                                <option value="billing">Default billing</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <label>Country</label>
                            <select v-model="newAddress.country" v-on:change="getCountriesJson(newAddress.country, 2)" class="form-control form-control-sm">
                                <option value="null" selected='selected'>Choose option</option>
                                <option v-for="country in countries" v-bind:value="country.iso_2">@{{ country.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 ">
                            <label for="payment_zone">State/Province</label>
                            <select v-model="newAddress.zone" class="form-control form-control-sm">
                                <option v-for="state in statesPayment" v-bind:value="state.name">@{{ state.name }}</option>
                                <option value="null">Select country</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-right py-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary text-white" @click="saveNewAddress()" data-dismiss="modal">Add new address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
