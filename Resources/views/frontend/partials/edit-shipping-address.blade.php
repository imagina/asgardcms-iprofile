
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                 <div class="form-group row">
                <div class="col pr-1">
                 <label for="shipping_firstname">{{ trans('icommerce::delivery_details.form.first_name') }}</label>
                 <input type="text" class="form-control" id="shipping_firstname" name="shipping_firstname" v-model="shippingData.first_name">

                </div>
                <div class="col pl-1">
                 <label for="shipping_lastname">{{ trans('icommerce::delivery_details.form.last_name') }}</label>
                 <input type="text" class="form-control" id="shipping_lastname" name="shipping_lastname" v-model="shippingData.last_name">
                </div>

            </div>
            </div>
            <div class="col-12">
                <div class="form-group ">
                    <label for="shipping_company">{{trans('iprofile::addresses.form.company')}}</label>
                    <input placeholder="Name Company" name="shipping_company" type="text" v-model="shippingData.company" id="shipping_company" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group ">
                    <label for="shipping_address_1">{{trans('iprofile::addresses.form.address1')}}</label>
                    <input placeholder="Address 1" name="shipping_address_1" type="text" v-model="shippingData.address1" id="shipping_address_1" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group ">
                    <label for="shipping_address_2">{{trans('iprofile::addresses.form.address2')}}</label>
                    <input placeholder="Address 2" name="shipping_address_2" type="text" v-model="shippingData.address2" id="shipping_address_2" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-flag"></i>
                    <label for="shipping_country">{{trans('iprofile::addresses.form.country')}}</label>
                    <select
                        class="form-control"
                        id="shipping_country"
                        name="shipping_country"
                        v-model="shippingData.country"
                        v-on:change="getCountriesJson(shippingData.country, 1)">
                        <option value="null">{{trans('iprofile::addresses.select.select_option')}}</option>
                        <option v-for="country in countries" v-bind:value="country.iso_2">@{{ country.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-building"></i>
                    <label for="shipping_zone">{{trans('iprofile::addresses.form.state')}}</label>
                    <select class="form-control"
                        id="shipping_zone"
                        name="shipping_zone"
                        v-model="shippingData.state"
                        v-show="!statesShippingAlternative">
                        <option v-for="state in statesShipping" v-bind:value="state.name">@{{ state.name }}</option>
                        <option value="null">{{trans('iprofile::addresses.select.select_country')}}</option>
                    </select>
                    <input  type="text"
                            class="form-control"
                            name="shipping_zone"
                            id="shipping_zone_alternative"
                            v-show="statesShippingAlternative"
                            v-model="shippingData.state">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-flag"></i>
                    <label for="shipping_city">{{trans('iprofile::addresses.form.city')}}</label>
                    <input data-shipping_city="target" placeholder="City" name="shipping_city" type="text" v-model="shippingData.city" id="shipping_city" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-building"></i>
                    <label for="shipping_postcode">{{trans('iprofile::addresses.form.zip_post')}}</label>
                    <input data-shipping_postcode="target" placeholder="Zip/Postal Code" name="shipping_postcode" type="text" v-model="shippingData.postcode" id="shipping_postcode" class="form-control">
                </div>
            </div>
            
        </div>
    </div>
</div>
