
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-12">
                <div class="form-group ">
                    <label for="payment_company">{{trans('iprofile::addresses.form.company')}}</label>
                    <input placeholder="Name Company" name="payment_company" type="text" v-model="paymentData.company" id="payment_company" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group ">
                    <label for="payment_address_1">{{trans('iprofile::addresses.form.address1')}}</label>
                    <input placeholder="Address 1" name="payment_address_1" type="text" v-model="paymentData.address1" id="payment_address_1" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group ">
                    <label for="payment_address_2">{{trans('iprofile::addresses.form.address2')}}</label>
                    <input placeholder="Address 2" name="payment_address_2" type="text" v-model="paymentData.address2" id="payment_address_2" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-flag"></i>
                    <label for="payment_country">{{trans('iprofile::addresses.form.country')}}</label>
                    <select
                            class="form-control"
                            id="payment_country"
                            name="payment_country"
                            v-model="paymentData.country"
                            v-on:change="getCountriesJson(paymentData.country, 2)">
                        <option value="null">{{trans('iprofile::addresses.select.select_option')}}</option>
                        <option v-for="country in countries" v-bind:value="country.iso_2">@{{ country.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-building"></i>
                    <label for="payment_zone">{{trans('iprofile::addresses.form.state')}}</label>
                    <select class="form-control"
                        id="payment_zone"
                        name="payment_zone"
                        v-model="paymentData.state"
                        v-show="!statesPaymentAlternative">
                        <option v-for="state in statesPayment" v-bind:value="state.name">@{{ state.name }}</option>
                        <option value="null">{{trans('iprofile::addresses.select.select_country')}}</option>
                    </select>
                    <input  type="text"
                            class="form-control"
                            name="payment_zone"
                            id="payment_zone_alternative"
                            v-show="statesPaymentAlternative"
                            v-model="paymentData.state">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-flag"></i>
                    <label for="payment_city">{{trans('iprofile::addresses.form.city')}}</label>
                    <input data-payment_city="target" placeholder="City" name="payment_city" type="text" v-model="paymentData.city" id="payment_city" class="form-control">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <i class="fa fa-building"></i>
                    <label for="payment_postcode">{{trans('iprofile::addresses.form.zip_post')}}</label>
                    <input data-payment_postcode="target" placeholder="Zip/Postal Code" name="payment_postcode" type="text" v-model="paymentData.postcode" id="payment_postcode" class="form-control">
                </div>
            </div>
            <input type="hidden" name="payment_firstname" v-model="user.first_name">
            <input type="hidden" name="payment_lastname" v-model="user.last_name">
        </div>
    </div>
</div>
