@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">

        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.vendor_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{!! route('vendors') !!}">{{trans('lang.vendor_plural')}}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('lang.create_vendor')}}</li>
            </ol>
        </div>
        <div>

            <div class="card-body">
                <div id="data-table_processing" class="dataTables_processing panel panel-default"
                    style="display: none;">{{trans('lang.processing')}}
                </div>
                <div class="error_top"></div>
                <div class="row vendor_payout_create">
                    <div class="vendor_payout_create-inner">
                        <fieldset>
                            <legend>{{trans('lang.admin_area')}}</legend>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.first_name')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control user_first_name" required>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_first_name_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.last_name')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control user_last_name">
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_last_name_help") }}
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.email')}}</label>
                                <div class="col-7">
                                    <input type="email" class="form-control user_email" required>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_email_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.password')}}</label>
                                <div class="col-7">
                                    <input type="password" class="form-control user_password" required>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_password_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.user_phone')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control user_phone"
                                        onkeypress="return chkAlphabets2(event,'error1')">
                                    <div id="error1" class="err"></div>
                                    <div class="form-text text-muted w-50">
                                        {{ trans("lang.user_phone_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-100">
                                <label class="col-3 control-label">{{trans('lang.user_profile_picture')}}</label>
                                <input type="file" onChange="handleFileSelectowner(event)" class="col-7">
                                <div id="uploding_image_owner"></div>
                                <div class="uploaded_image_owner" style="display:none;"><img id="uploaded_image_owner"
                                        src="" width="150px" height="150px;"></div>
                            </div>

                        </fieldset>

                        <fieldset>
                            <legend>{{trans('lang.select_section')}}</legend>

                            <div class="form-group row width-100">
                                <label class="col-3 control-label ">{{trans('lang.select_section')}}</label>
                                <div class="col-7">
                                    <select name="section_id" class="form-control" id="section_id">
                                        <option value="">{{trans('lang.select')}}</option>
                                    </select>
                                    <p style="color: red;font-size: 13px;">
                                        {{trans('lang.rental_parcel_cab_service_are_not')}}</p>
                                </div>
                            </div>

                        </fieldset>


                        <fieldset>
                            <legend>{{trans('lang.vendor_details')}}</legend>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.vendor_name')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control vendor_name" required>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.vendor_name_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.category')}}</label>
                                <div class="col-7">
                                    <select id='vendor_cuisines' class="form-control" required>
                                        <option value="">{{ trans("lang.select_category") }}</option>
                                    </select>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.vendor_cuisines_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.vendor_phone')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control vendor_phone"
                                        onkeypress="return chkAlphabets2(event,'error2')" required>
                                    <div id="error2" class="err"></div>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.vendor_phone_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.vendor_address')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control vendor_address" required>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.vendor_address_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-100">
                                <div class="col-12">
                                    <h6>{{ trans("lang.know_your_cordinates") }} <a target="_blank"
                                            href="https://www.latlong.net/">{{
    trans("lang.latitude_and_longitude_finder") }}</a></h6>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.vendor_latitude')}}</label>
                                <div class="col-7">
                                    <input class="form-control vendor_latitude" type="number" min="-90" max="90"
                                        onkeypress="return chkAlphabets3(event,'error3')">
                                    <div id="error3" class="err"></div>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.vendor_latitude_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.vendor_longitude')}}</label>
                                <div class="col-7">
                                    <input class="form-control vendor_longitude" type="number" min="-180" max="180"
                                        onkeypress="return chkAlphabets3(event,'error4')">
                                    <div id="error4" class="err"></div>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.vendor_longitude_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.vendor_image')}}</label>
                                <div class="col-7">
                                    <input type="file" onChange="handleFileSelect(event,'photo')">
                                    <div id="uploding_image_vendor"></div>
                                    <div class="uploaded_image" style="display:none;"><img id="uploaded_image" src=""
                                            width="150px" height="150px;"></div>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.vendor_image_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-100">
                                <label class="col-3 control-label ">{{trans('lang.vendor_description')}}</label>
                                <div class="col-7">
                                    <textarea rows="7" class="vendor_description form-control"
                                        id="vendor_description"></textarea>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>{{trans('lang.gallery')}}</legend>

                            <div class="form-group row width-50 vendor_image">
                                <div class="">
                                    <div id="photos"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div>
                                    <input type="file" onChange="handleFileSelect(event,'photos')">
                                    <div id="uploding_image_photos"></div>
                                </div>
                            </div>
                        </fieldset>


                        <fieldset class="ecommerce_div">
                            <legend>{{trans('lang.working_hours')}}</legend>

                            <div class="form-group row">

                                <div class="form-group row width-100">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-primary  add_working_hours_restaurant_btn">
                                            <i></i>{{trans('lang.add_working_hours')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="working_hours_div" style="display:none">


                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.sunday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary add_more_sunday"
                                                onclick="addMorehour('Sunday','sunday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>


                                    <div class="restaurant_working_options_Sunday_div restaurant_discount"
                                        style="display:none">


                                        <table class="booking-table" id="working_hour_table_Sunday">
                                            <tr>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.from')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.monday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary add_more_sunday"
                                                onclick="addMorehour('Monday','monday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_working_options_Monday_div restaurant_discount"
                                        style="display:none">

                                        <table class="booking-table" id="working_hour_table_Monday">
                                            <tr>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.from')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.tuesday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMorehour('Tuesday','tuesday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_working_options_Tuesday_div restaurant_discount"
                                        style="display:none">

                                        <table class="booking-table" id="working_hour_table_Tuesday">
                                            <tr>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.from')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.wednesday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMorehour('Wednesday','wednesday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>


                                    <div class="restaurant_working_options_Wednesday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="working_hour_table_Wednesday">
                                            <tr>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.from')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.thursday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMorehour('Thursday','thursday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_working_options_Thursday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="working_hour_table_Thursday">
                                            <tr>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.from')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.friday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMorehour('Friday','friday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_working_options_Friday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="working_hour_table_Friday">
                                            <tr>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.from')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.Saturday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMorehour('Saturday','Saturday','1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="restaurant_working_options_Saturday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="working_hour_table_Saturday">
                                            <tr>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.from')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </fieldset>


                        <fieldset>
                            <legend>{{trans('vendor')}} {{trans('lang.active_deactive')}}</legend>
                            <div class="form-group row">

                                <div class="form-group row width-50">
                                    <div class="form-check width-100">
                                        <input type="checkbox" id="is_active">
                                        <label class="col-3 control-label"
                                            for="is_active">{{trans('lang.active')}}</label>
                                    </div>
                                </div>

                            </div>
                        </fieldset>

                        <fieldset style="display: none;" id="services_feature">
                            <legend>{{trans('lang.services')}}</legend>
                            <div class="form-group row">

                                <div class="form-check width-100">
                                    <input type="checkbox" id="Free_Wi_Fi">
                                    <label class="col-3 control-label" for="Free_Wi_Fi">{{trans('lang.wifi')}}</label>
                                </div>
                                <div class="form-check width-100">
                                    <input type="checkbox" id="Good_for_Breakfast">
                                    <label class="col-3 control-label"
                                        for="Good_for_Breakfast">{{trans('lang.breakfast')}}</label>
                                </div>
                                <div class="form-check width-100">
                                    <input type="checkbox" id="Good_for_Dinner">
                                    <label class="col-3 control-label"
                                        for="Good_for_Dinner">{{trans('lang.dinner')}}</label>
                                </div>
                                <div class="form-check width-100">
                                    <input type="checkbox" id="Good_for_Lunch">
                                    <label class="col-3 control-label"
                                        for="Good_for_Lunch">{{trans('lang.lunch')}}</label>
                                </div>

                                <div class="form-check width-100">
                                    <input type="checkbox" id="Live_Music">
                                    <label class="col-3 control-label"
                                        for="Live_Music">{{trans('lang.live_music')}}</label>
                                </div>

                                <div class="form-check width-100">
                                    <input type="checkbox" id="Outdoor_Seating">
                                    <label class="col-3 control-label"
                                        for="Outdoor_Seating">{{trans('lang.outdoor_seating')}}</label>
                                </div>

                                <div class="form-check width-100">
                                    <input type="checkbox" id="Takes_Reservations">
                                    <label class="col-3 control-label"
                                        for="Takes_Reservations">{{trans('lang.reservations')}}</label>
                                </div>

                                <div class="form-check width-100">
                                    <input type="checkbox" id="Vegetarian_Friendly">
                                    <label class="col-3 control-label"
                                        for="Vegetarian_Friendly">{{trans('lang.vegetarian_friendly')}}</label>
                                </div>

                            </div>
                        </fieldset>

                        <fieldset style="display:none;" id="is_dine_in_feature">
                            <legend>{{trans('lang.dine_in_future_setting')}}</legend>

                            <div class="form-group row">

                                <div class="form-group row width-100">
                                    <div class="form-check width-100">
                                        <input type="checkbox" id="dine_in_feature" class="">
                                        <label class="col-3 control-label"
                                            for="dine_in_feature">{{trans('lang.enable_dine_in_feature')}}</label>
                                    </div>
                                </div>
                                <div class="divein_div" style="display:none">


                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                        <div class="col-7">
                                            <input type="time" class="form-control" id="openDineTime" required>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                        <div class="col-7">
                                            <input type="time" class="form-control" id="closeDineTime" required>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.cost')}}</label>
                                        <div class="col-7">
                                            <input type="number" class="form-control vendor_cost" required>
                                        </div>
                                    </div>
                                    <div class="form-group row width-100 vendor_image">
                                        <label class="col-3 control-label">{{trans('lang.menu_card')}}</label>
                                        <div class="">
                                            <div id="photos_menu_card"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div>
                                            <input type="file" onChange="handleFileSelectMenuCard(event)">
                                            <div id="uploaded_image_menu"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </fieldset>


                        <fieldset id="delivery_charges_div">
                            <legend>{{trans('lang.deliveryCharge')}}</legend>

                            <div class="form-group row">

                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{
    trans('lang.delivery_charges_per_km')}}</label>
                                    <div class="col-7">
                                        <input type="number" class="form-control" id="delivery_charges_per_km">
                                    </div>
                                </div>
                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{
    trans('lang.minimum_delivery_charges')}}</label>
                                    <div class="col-7">
                                        <input type="number" class="form-control" id="minimum_delivery_charges">
                                    </div>
                                </div>
                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{
    trans('lang.minimum_delivery_charges_within_km')}}</label>
                                    <div class="col-7">
                                        <input type="number" class="form-control"
                                            id="minimum_delivery_charges_within_km">
                                    </div>
                                </div>

                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>{{trans('lang.bankdetails')}}</legend>
                            <div class="form-group row width-100" style="display: none;" id="companyDriverShowDiv">
                                <div class="col-12">
                                    <h6><a href="#">{{ trans("lang.driver_add_by_company_info") }}</a>
                                    </h6>
                                </div>
                            </div>
                            <div class="form-group row" id="companyDriverHideDiv">

                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{trans('lang.bank_name')}}</label>
                                    <div class="col-7">
                                        <input type="text" name="bank_name" class="form-control" id="bankName">
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{trans('lang.branch_name')}}</label>
                                    <div class="col-7">
                                        <input type="text" name="branch_name" class="form-control" id="branchName">
                                    </div>
                                </div>


                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{trans('lang.holer_name')}}</label>
                                    <div class="col-7">
                                        <input type="text" name="holer_name" class="form-control" id="holderName">
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{trans('lang.account_number')}}</label>
                                    <div class="col-7">
                                        <input type="text" name="account_number" class="form-control"
                                            id="accountNumber">
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <label class="col-4 control-label">{{trans('lang.other_information')}}</label>
                                    <div class="col-7">
                                        <input type="text" name="other_information" class="form-control"
                                            id="otherDetails">
                                    </div>
                                </div>

                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>{{trans('lang.special_offer')}}</legend>
                      
                                <div class="form-group row width-100">
                                        <div class="form-check width-100">
                                            <input type="checkbox" id="enable_special_offer">
                                            <label class="col-3 control-label"
                                                for="enable_special_offer">{{trans('lang.enable_special_offer')}}</label>
                                        </div>
                                </div>
                                <div class="form-group row width-100">
                                    <div class="col-7">
                                        <button type="button" class="btn btn-primary  add_special_offer_restaurant_btn">
                                            <i></i>{{trans('lang.add_special_offer')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="special_offer_div" style="display:none">


                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.sunday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary add_more_sunday"
                                                onclick="addMoreButton('Sunday','sunday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>


                                    <div class="restaurant_discount_options_Sunday_div restaurant_discount"
                                        style="display:none">


                                        <table class="booking-table" id="special_offer_table_Sunday">
                                            <tr>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.coupon_discount')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                        {{trans('lang.type')}}</label>
                                                </th>

                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.monday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary add_more_sunday"
                                                onclick="addMoreButton('Monday','monday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_discount_options_Monday_div restaurant_discount"
                                        style="display:none">

                                        <table class="booking-table" id="special_offer_table_Monday">
                                            <tr>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.coupon_discount')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                        {{trans('lang.type')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.tuesday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMoreButton('Tuesday','tuesday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_discount_options_Tuesday_div restaurant_discount"
                                        style="display:none">

                                        <table class="booking-table" id="special_offer_table_Tuesday">
                                            <tr>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.coupon_discount')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                        {{trans('lang.type')}}</label>
                                                </th>

                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.wednesday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMoreButton('Wednesday','wednesday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>


                                    <div class="restaurant_discount_options_Wednesday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="special_offer_table_Wednesday">
                                            <tr>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.coupon_discount')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                        {{trans('lang.type')}}</label>
                                                </th>

                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.thursday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMoreButton('Thursday','thursday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_discount_options_Thursday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="special_offer_table_Thursday">
                                            <tr>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.coupon_discount')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                        {{trans('lang.type')}}</label>
                                                </th>

                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.friday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMoreButton('Friday','friday', '1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="restaurant_discount_options_Friday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="special_offer_table_Friday">
                                            <tr>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.coupon_discount')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                        {{trans('lang.type')}}</label>
                                                </th>

                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>

                                        </table>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-1 control-label">{{trans('lang.Saturday')}}</label>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary"
                                                onclick="addMoreButton('Saturday','Saturday','1')">
                                                {{trans('lang.add_more')}}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="restaurant_discount_options_Saturday_div restaurant_discount"
                                        style="display:none">
                                        <table class="booking-table" id="special_offer_table_Saturday">
                                            <tr>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Opening_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.Closing_Time')}}</label>
                                                </th>
                                                <th>
                                                    <label
                                                        class="col-3 control-label">{{trans('lang.coupon_discount')}}</label>
                                                </th>
                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                        {{trans('lang.type')}}</label>
                                                </th>

                                                <th>
                                                    <label class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            

                        </fieldset>

                        <fieldset id="story_upload_div" style="display: none;">
                            <legend>Story</legend>

                            <div class="form-group row width-50 vendor_image">
                                <label class="col-3 control-label">Choose humbling GIF/Image</label>
                                <div class="">
                                    <div id="story_thumbnail"></div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div>
                                    <input type="file" id="file" onChange="handleStoryThumbnailFileSelect(event)">
                                    <div id="uploding_story_thumbnail"></div>
                                </div>
                            </div>


                            <div class="form-group row vendor_image">
                                <label class="col-3 control-label">Select Story Video</label>
                                <div class="">
                                    <div id="story_vedios" class="row"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div>
                                    <input type="file" id="video_file" onChange="handleStoryFileSelect(event)">
                                    <div id="uploding_story_video"></div>
                                </div>
                            </div>


                        </fieldset>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-12 text-center btm-btn">
            <button type="button" class="btn btn-primary  create_vendor_btn"><i class="fa fa-save"></i>
                {{trans('lang.save')}}
            </button>
            <a href="{!! route('vendors') !!}" class="btn btn-default"><i
                    class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
        </div>

    </div>
</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript">
    var database = firebase.firestore();
    var photo = "";
    var menuPhotoCount = 0;
    var vendorMenuPhotos = "";


    var vendorOwnerId = "";
    var vendorOwnerOnline = false;
    var photocount = 0;
    var storageRef = firebase.storage().ref('images');
    var vendorPhoto = '';
    var vendorPhotoFileName = '';
    var restaurnt_photos = [];
    var restaurant_photos_filename = [];
    var ownerphoto = '';
    var ownerFileName = '';
    var vendor_menu_photos = [];
    var vendor_menu_filename = [];
    var story_thumbnail = '';
    var story_thumbnail_filename = '';

    var ref_sections = database.collection('sections');
    var createdAt = firebase.firestore.FieldValue.serverTimestamp();
    var sections_list = [];
    var categories_list = [];
    var ref_deliverycharge = database.collection('settings').doc("DeliveryCharge");
    var deliveryChargeFlag = false;
    var workingHours = [];
    var timeslotworkSunday = [];
    var timeslotworkMonday = [];
    var timeslotworkTuesday = [];
    var timeslotworkWednesday = [];
    var timeslotworkFriday = [];
    var timeslotworkSaturday = [];
    var timeslotworkThursday = [];

    var specialDiscount = [];
    var timeslotSunday = [];
    var timeslotMonday = [];
    var timeslotTuesday = [];
    var timeslotWednesday = [];
    var timeslotFriday = [];
    var timeslotSaturday = [];
    var timeslotThursday = [];
    var storevideoDuration = 0;

    var story_vedios = [];

    var story_isEnabled = false;
    var storyCount = 0;
    var storyRef = firebase.storage().ref('Story');
    var storyImagesRef = firebase.storage().ref('Story/images');
    var vendor_id = database.collection("tmp").doc().id;

    database.collection('settings').doc("story").get().then(async function (snapshots) {
        var story_data = snapshots.data();
        if (story_data.isEnabled) {
            story_isEnabled = true;

        }
        storevideoDuration = story_data.videoDuration;
    });


    var currentCurrency = '';
    var currencyAtRight = false;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;
    });

    var email_templates = database.collection('email_templates').where('type', '==', 'new_vendor_signup');

    var emailTemplatesData = null;

    var adminEmail = '';

    var emailSetting = database.collection('settings').doc('emailSetting');

    var dine_in_active = false;
    $(document).ready(async function () {
        jQuery("#data-table_processing").show();

        await email_templates.get().then(async function (snapshots) {
            emailTemplatesData = snapshots.docs[0].data();
        });

        await emailSetting.get().then(async function (snapshots) {
            var emailSettingData = snapshots.data();

            adminEmail = emailSettingData.userName;
        });

        ref_sections.get().then(async function (snapshots) {

            snapshots.docs.forEach((listval) => {
                var data = listval.data();
                if (data.serviceTypeFlag == "delivery-service" || data.serviceTypeFlag == "ecommerce-service") {

                    sections_list.push(data);

                    $('#section_id').append($("<option></option>")

                        .attr("value", data.id)
                        .attr("data-type", data.serviceTypeFlag)
                        .text(data.name + ' (' + data.serviceType + ')'));
                }
            })
        })

        database.collection('vendor_categories').where('publish', '==', true).get().then(async function (snapshots) {
            snapshots.docs.forEach((listval) => {
                var data = listval.data();
                categories_list.push(data);
                $('#vendor_cuisines').append($("<option></option>")
                    .attr("value", data.id)
                    .text(data.title));
            })
        });

        jQuery("#data-table_processing").hide();

        ref_deliverycharge.get().then(async function (snapshots_charge) {
            var deliveryChargeSettings = snapshots_charge.data();
            try {
                if (deliveryChargeSettings.vendor_can_modify) {
                    deliveryChargeFlag = true;
                    $("#delivery_charges_per_km").val(deliveryChargeSettings.delivery_charges_per_km);
                    $("#minimum_delivery_charges").val(deliveryChargeSettings.minimum_delivery_charges);
                    $("#minimum_delivery_charges_within_km").val(deliveryChargeSettings.minimum_delivery_charges_within_km);
                } else {
                    deliveryChargeFlag = false;
                    $("#delivery_charges_per_km").val(deliveryChargeSettings.delivery_charges_per_km);
                    $("#minimum_delivery_charges").val(deliveryChargeSettings.minimum_delivery_charges);
                    $("#minimum_delivery_charges_within_km").val(deliveryChargeSettings.minimum_delivery_charges_within_km);
                    $("#delivery_charges_per_km").prop('disabled', true);
                    $("#minimum_delivery_charges").prop('disabled', true);
                    $("#minimum_delivery_charges_within_km").prop('disabled', true);
                }
            } catch (error) {

            }
        });
    })

    $(".create_vendor_btn").click(async function () {
        $(".error_top").hide();
        var vendorname = $(".vendor_name").val();
        var cuisines = $("#vendor_cuisines option:selected").val();
        var vendorOwner = $("#vendor_owners option:selected").val();
        var address = $(".vendor_address").val();
        var latitude = parseFloat($(".vendor_latitude").val());
        var longitude = parseFloat($(".vendor_longitude").val());
        var description = $(".vendor_description").val();
        var phonenumber = $(".vendor_phone").val();
        var categoryTitle = $("#vendor_cuisines option:selected").text();

        var userFirstName = $(".user_first_name").val();
        var userLastName = $(".user_last_name").val();
        var email = $(".user_email").val();
        var password = $(".user_password").val();
        var userPhone = $(".user_phone").val();
        var section_id = $("#section_id").val();
       
        var enabledDiveInFuture = $("#dine_in_feature").is(':checked');
        var vendorCost = $(".vendor_cost").val();
        var vendor_active = false;
        if ($("#is_active").is(':checked')) {
            vendor_active = true;
        }

        var user_name = userFirstName + " " + userLastName;
        var user_id = "<?php echo uniqid(); ?>";
        var name = userFirstName + " " + userLastName;


        var openDineTime = $("#openDineTime").val();
        var openDineTime_val = $("#openDineTime").val();
        if (openDineTime) {
            openDineTime = new Date('1970-01-01T' + openDineTime + 'Z')
                .toLocaleTimeString('en-US',
                    { timeZone: 'UTC', hour12: true, hour: 'numeric', minute: 'numeric' }
                );
        }

        var closeDineTime = $("#closeDineTime").val();
        var closeDineTime_val = $("#closeDineTime").val();
        if (closeDineTime) {
            closeDineTime = new Date('1970-01-01T' + closeDineTime + 'Z')
                .toLocaleTimeString('en-US',
                    { timeZone: 'UTC', hour12: true, hour: 'numeric', minute: 'numeric' }
                );
        }

        if (dine_in_active == false) {
            enabledDiveInFuture = false;
            vendorCost = "";
            openDineTime = "";
            closeDineTime = "";
            vendor_menu_photos = [];
        }
        
        var enabledSpecialOffer = $("#enable_special_offer").is(':checked');

        var specialDiscount = [];

        var sunday = { 'day': 'Sunday', 'timeslot': timeslotSunday };
        var monday = { 'day': 'Monday', 'timeslot': timeslotMonday };
        var tuesday = { 'day': 'Tuesday', 'timeslot': timeslotTuesday };
        var wednesday = { 'day': 'Wednesday', 'timeslot': timeslotWednesday };
        var thursday = { 'day': 'Thursday', 'timeslot': timeslotThursday };
        var friday = { 'day': 'Friday', 'timeslot': timeslotFriday };
        var Saturday = { 'day': 'Saturday', 'timeslot': timeslotSaturday };

        specialDiscount.push(monday);
        specialDiscount.push(tuesday);
        specialDiscount.push(wednesday);
        specialDiscount.push(thursday);
        specialDiscount.push(friday);
        specialDiscount.push(Saturday);
        specialDiscount.push(sunday);


        var workingHours = [];

        var sunday = { 'day': 'Sunday', 'timeslot': timeslotworkSunday };
        var monday = { 'day': 'Monday', 'timeslot': timeslotworkMonday };
        var tuesday = { 'day': 'Tuesday', 'timeslot': timeslotworkTuesday };
        var wednesday = { 'day': 'Wednesday', 'timeslot': timeslotworkWednesday };
        var thursday = { 'day': 'Thursday', 'timeslot': timeslotworkThursday };
        var friday = { 'day': 'Friday', 'timeslot': timeslotworkFriday };
        var Saturday = { 'day': 'Saturday', 'timeslot': timeslotworkSaturday };

        workingHours.push(monday);
        workingHours.push(tuesday);
        workingHours.push(wednesday);
        workingHours.push(thursday);
        workingHours.push(friday);
        workingHours.push(Saturday);
        workingHours.push(sunday);

        var Free_Wi_Fi = "No";
        if ($("#Free_Wi_Fi").is(":checked")) {
            Free_Wi_Fi = "Yes";
        }
        var Good_for_Breakfast = "No";
        if ($("#Good_for_Breakfast").is(':checked')) {
            Good_for_Breakfast = "Yes";
        }
        var Good_for_Dinner = "No";
        if ($("#Good_for_Dinner").is(':checked')) {
            Good_for_Dinner = "Yes";
        }
        var Good_for_Lunch = "No";
        if ($("#Good_for_Lunch").is(':checked')) {
            Good_for_Lunch = "Yes";
        }
        var Live_Music = "No";
        if ($("#Live_Music").is(':checked')) {
            Live_Music = "Yes";
        }
        var Outdoor_Seating = "No";
        if ($("#Outdoor_Seating").is(':checked')) {
            Outdoor_Seating = "Yes";
        }
        var Takes_Reservations = "No";
        if ($("#Takes_Reservations").is(':checked')) {
            Takes_Reservations = "Yes";
        }
        var Vegetarian_Friendly = "No";
        if ($("#Vegetarian_Friendly").is(':checked')) {
            Vegetarian_Friendly = "Yes";
        }

        var filters_new = {
            "Free Wi-Fi": Free_Wi_Fi,
            "Good for Breakfast": Good_for_Breakfast,
            "Good for Dinner": Good_for_Dinner,
            "Good for Lunch": Good_for_Lunch,
            "Live Music": Live_Music,
            "Outdoor Seating": Outdoor_Seating,
            "Takes Reservations": Takes_Reservations,
            "Vegetarian Friendly": Vegetarian_Friendly
        };

        var delivery_charges_per_km = parseInt($("#delivery_charges_per_km").val());
        var minimum_delivery_charges = parseInt($("#minimum_delivery_charges").val());
        var minimum_delivery_charges_within_km = parseInt($("#minimum_delivery_charges_within_km").val());
        var deliveryCharge = {
            'delivery_charges_per_km': delivery_charges_per_km,
            'minimum_delivery_charges': minimum_delivery_charges,
            'minimum_delivery_charges_within_km': minimum_delivery_charges_within_km
        };

        if (userFirstName == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_name_error')}}</p>");
            window.scrollTo(0, 0);
        }else if (userLastName == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_lastname_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (email == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_email')}}</p>");
            window.scrollTo(0, 0);
        } else if (password == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_password_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (userPhone == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_phone')}}</p>");
            window.scrollTo(0, 0);
        } else if (vendorname == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_name_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (cuisines == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_cuisine_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (phonenumber == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_phone_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (address == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_address_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (isNaN(latitude)) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_lattitude_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (latitude < -90 || latitude > 90) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_lattitude_limit_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (isNaN(longitude)) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_longitude_error')}}</p>");
            window.scrollTo(0, 0);

        } else if (longitude < -180 || longitude > 180) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_longitude_limit_error')}}</p>");
            window.scrollTo(0, 0);

        } else if (description == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.vendor_description_error')}}</p>");
            window.scrollTo(0, 0);

        } else if (section_id == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.select_section_error')}}</p>");
            window.scrollTo(0, 0);
        } else {

            if (story_vedios.length > 0 || story_thumbnail != '') {
                if (story_vedios.length > 0 && story_thumbnail == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{trans('lang.story_error')}}</p>");
                    window.scrollTo(0, 0);
                    return false;
                } else if (story_thumbnail && story_vedios.length == 0) {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{trans('lang.story_error')}}</p>");
                    window.scrollTo(0, 0);
                    return false;
                } else {
                    await storeStoryImageData().then(async (IMG) => {
                        database.collection('story').doc(vendor_id).set({
                            'createdAt': new Date(),
                            'sectionID': section_id,
                            'vendorID': vendor_id,
                            'videoThumbnail': IMG.storyThumbnailImage,
                            'videoUrl': story_vedios,
                        });
                    }).catch(err => {
                        jQuery("#data-table_processing").hide();
                        $(".error_top").show();
                        $(".error_top").html("");
                        $(".error_top").append("<p>" + err + "</p>");
                        window.scrollTo(0, 0);
                    });
                }
            }
            jQuery("#data-table_processing").show();
            var bankName = $("#bankName").val();
            var branchName = $("#branchName").val();
            var holderName = $("#holderName").val();
            var accountNumber = $("#accountNumber").val();
            var otherDetails = $("#otherDetails").val();
            var userBankDetails = {
                'bankName': bankName,
                'branchName': branchName,
                'holderName': holderName,
                'accountNumber': accountNumber,
                'accountNumber': accountNumber,
                'otherDetails': otherDetails,
            };

            firebase.auth().createUserWithEmailAndPassword(email, password)
                .then(async function (firebaseUser) {
                    user_id = firebaseUser.user.uid;
                    await storeImageData().then(async (IMG) => {
                        await storeGalleryImageData().then(async (GalleryIMG) => {
                            await storeMenuImageData().then(async (MenuIMG) => {
                                database.collection('users').doc(user_id).set({
                                    'section_id': section_id,
                                    'firstName': userFirstName,
                                    'lastName': userLastName,
                                    'email': email,
                                    'phoneNumber': userPhone,
                                    'profilePictureURL': IMG.ownerImage,
                                    'role': 'vendor',
                                    'id': user_id,
                                    'active': vendor_active,
                                    'vendorID': vendor_id,
                                     createdAt: createdAt,
                                    'userBankDetails': userBankDetails,

                                }).then(function (result) {

                                    coordinates = new firebase.firestore.GeoPoint(latitude, longitude);

                                    geoFirestore.collection('vendors').doc(vendor_id).set({
                                        'section_id': section_id,
                                        'title': vendorname,
                                        'description': description,
                                        'latitude': latitude,
                                        'longitude': longitude,
                                        'location': address,
                                        'photo': IMG.vendorImage,
                                        'categoryID': cuisines,
                                        'phonenumber': phonenumber,
                                        'categoryTitle': categoryTitle,
                                        'coordinates': coordinates,
                                        'id': vendor_id,
                                        'filters': filters_new,
                                        'photos': GalleryIMG,
                                        'author': user_id,
                                        'authorName': name,
                                        'authorProfilePic': IMG.ownerImage,
                                        hidephotos: false,
                                        createdAt: createdAt,
                                        'enabledDiveInFuture': enabledDiveInFuture,
                                        'specialDiscountEnable':enabledSpecialOffer,
                                        'vendorMenuPhotos': MenuIMG,
                                        'vendorCost': vendorCost,
                                        'openDineTime': openDineTime,
                                        'closeDineTime': closeDineTime,
                                        'workingHours': workingHours,
                                        'specialDiscount': specialDiscount
                                    }).then(async function (result) {

                                        if (deliveryChargeFlag) {

                                            geoFirestore.collection('vendors').doc(vendor_id).update({
                                                'deliveryCharge': deliveryCharge
                                            }).then(async function (result) {

                                                var isSendMail = await sendRegistrationEmail(user_id, name, email, phonenumber);
                                                if (isSendMail) {
                                                    window.location.href = '{{ route("vendors")}}';

                                                }
                                            });
                                        } else {

                                            var isSendMail = await sendRegistrationEmail(user_id, name, email, phonenumber);
                                            if (isSendMail) {
                                                window.location.href = '{{ route("vendors")}}';

                                            }
                                        }


                                    });

                                })

                            }).catch(function (error) {
                                jQuery("#data-table_processing").hide();
                                $(".error_top").show();
                                $(".error_top").html("");
                                $(".error_top").append("<p>" + error + "</p>");
                            });
                        }).catch(err => {
                            jQuery("#data-table_processing").hide();
                            $(".error_top").show();
                            $(".error_top").html("");
                            $(".error_top").append("<p>" + err + "</p>");
                            window.scrollTo(0, 0);
                        })
                    }).catch(err => {
                        jQuery("#data-table_processing").hide();
                        $(".error_top").show();
                        $(".error_top").html("");
                        $(".error_top").append("<p>" + err + "</p>");
                        window.scrollTo(0, 0);
                    });
                }).catch(err => {
                    jQuery("#data-table_processing").hide();
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>" + err + "</p>");
                    window.scrollTo(0, 0);
                });
        }

    });

    async function sendRegistrationEmail(user_id, name, email, phonenumber) {

        var flag = true;
        var formattedDate = new Date();
        var month = formattedDate.getMonth() + 1;
        var day = formattedDate.getDate();
        var year = formattedDate.getFullYear();

        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;

        formattedDate = day + '-' + month + '-' + year;

        var message = emailTemplatesData.message;
        message = message.replace(/{userid}/g, user_id);
        message = message.replace(/{username}/g, name);
        message = message.replace(/{useremail}/g, email);
        message = message.replace(/{userphone}/g, phonenumber);

        message = message.replace(/{date}/g, formattedDate);

        emailTemplatesData.message = message;

        var url = "{{url('send-email')}}";

        var sendEmailStatus = await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [adminEmail]);

        if (sendEmailStatus) {
            flag = true;
        }

        return flag;
    }


    $(".add_special_offer_restaurant_btn").click(function () {
        $(".special_offer_div").show();
    })

    var countAddButton = 1;

    function addMoreButton(day, day2, count) {
        count = countAddButton;
        $(".restaurant_discount_options_" + day + "_div").show();

        $('#special_offer_table_' + day + ' tr:last').after('<tr>' +
            '<td class="" style="width:10%;"><input type="time" class="form-control" id="openTime' + day + count + '"></td>' +
            '<td class="" style="width:10%;"><input type="time" class="form-control" id="closeTime' + day + count + '"></td>' +
            '<td class="" style="width:30%;">' +
            '<input type="number" class="form-control" id="discount' + day + count + '" style="width:60%;">' +
            '<select id="discount_type' + day + count + '" class="form-control" style="width:40%;"><option value="percentage"/>%</option><option value="amount"/>' + currentCurrency + '</option></select>' +
            '</td>' +
            '<td style="width:30%;"><select id="type' + day + count + '" class="form-control"><option value="delivery"/>Delivery Discount</option></select></td>' +
            '<td class="action-btn" style="width:20%;">' +
            '<button type="button" class="btn btn-primary save_option_day_button' + day + count + '" onclick="addMoreFunctionButton(`' + day2 + '`,`' + day + '`,' + countAddButton + ')" style="width:62%;">Save</button>' +
            '</td></tr>');
        countAddButton++;

    }

    function deleteOffer(day, count, i) {
        $('.' + i + '_' + count + '_row').hide();
        if (day == 'Sunday') {
            timeslotSunday.splice(count, 1);
        } else if (day == 'Monday') {
            timeslotMonday.splice(count, 1);
        } else if (day == 'Tuesday') {
            timeslotTuesday.splice(count, 1);
        } else if (day == 'Wednesday') {
            timeslotWednesday.splice(count, 1);
        } else if (day == 'Thursday') {
            timeslotThursday.splice(count, 1);
        } else if (day == 'Friday') {
            timeslotFriday.splice(count, 1);
        } else if (day == 'Saturday') {
            timeslotSaturday.splice(count, 1);
        }

        var specialDiscount = [];
        var sunday = { 'day': 'Sunday', 'timeslot': timeslotSunday };
        var monday = { 'day': 'Monday', 'timeslot': timeslotMonday };
        var tuesday = { 'day': 'Tuesday', 'timeslot': timeslotTuesday };
        var wednesday = { 'day': 'Wednesday', 'timeslot': timeslotWednesday };
        var thursday = { 'day': 'Thursday', 'timeslot': timeslotThursday };
        var friday = { 'day': 'Friday', 'timeslot': timeslotFriday };
        var Saturday = { 'day': 'Saturday', 'timeslot': timeslotSaturday };

        specialDiscount.push(monday);
        specialDiscount.push(tuesday);
        specialDiscount.push(wednesday);
        specialDiscount.push(thursday);
        specialDiscount.push(friday);
        specialDiscount.push(Saturday);
        specialDiscount.push(sunday);


        database.collection('vendors').doc(id).update({ 'specialDiscount': specialDiscount }).then(function (result) {

        });
    }

    function addMoreFunctionButton(day1, day2, count) {
        var discount = $("#discount" + day2 + count).val();
        var discount_type = $('#discount_type' + day2 + count).val();
        var type = $('#type' + day2 + count).val();
        var closeTime = $("#closeTime" + day2 + count).val();
        var openTime = $("#openTime" + day2 + count).val();
        if (discount == "" && closeTime == '' && openTime == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>Please Enter valid time or discount</p>");
            window.scrollTo(0, 0);
        } else if (discount > 100 || discount == 0) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>Please Enter valid discount</p>");
            window.scrollTo(0, 0);
        } else {

            var timeslotVar = {
                'discount': discount,
                'from': openTime,
                'to': closeTime,
                'type': discount_type,
                'discount_type': type
            };

            if (day1 == 'sunday') {
                timeslotSunday.push(timeslotVar);
            } else if (day1 == 'monday') {
                timeslotMonday.push(timeslotVar);
            } else if (day1 == 'tuesday') {
                timeslotTuesday.push(timeslotVar);
            } else if (day1 == 'wednesday') {
                timeslotWednesday.push(timeslotVar);
            } else if (day1 == 'thursday') {
                timeslotThursday.push(timeslotVar);
            } else if (day1 == 'friday') {
                timeslotFriday.push(timeslotVar);
            } else if (day1 == 'Saturday') {
                timeslotSaturday.push(timeslotVar);
            }

            $(".save_option_day_button" + day2 + count).hide();
            $("#discount" + day2 + count).attr('disabled', "true");
            $("#discount_type" + day2 + count).attr('disabled', "true");
            $("#type" + day2 + count).attr('disabled', "true");
            $("#closeTime" + day2 + count).attr('disabled', "true");
            $("#openTime" + day2 + count).attr('disabled', "true");
        }

    }

    $(".add_working_hours_restaurant_btn").click(function () {
        $(".working_hours_div").show();
    })
    var countAddhours = 1;

    function addMorehour(day, day2, count) {
        count = countAddhours;
        $(".restaurant_working_options_" + day + "_div").show();
        $('#working_hour_table_' + day + ' tr:last').after('<tr>' +
            '<td class="" style="width:50%;"><input type="time" class="form-control" id="from' + day + count + '"></td>' +
            '<td class="" style="width:50%;"><input type="time" class="form-control" id="to' + day + count + '"></td>' +
            '<td><button type="button" class="btn btn-primary save_option_day_button' + day + count + '" onclick="addMoreFunctionhour(`' + day2 + '`,`' + day + '`,' + countAddhours + ')" style="width:62%;">Save</button>' +
            '</td></tr>'); 
        countAddhours++;

    } 

    function addMoreFunctionhour(day1, day2, count) {
        var to = $("#to" + day2 + count).val();
        var from = $("#from" + day2 + count).val();
        if (to == '' && from == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>Please Enter valid time</p>");
            window.scrollTo(0, 0);

        } 
         else if(from>to){
             $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>To time can not be less than From time</p>");
            window.scrollTo(0, 0);
       }
        else {

            var timeslotworkVar = { 'from': from, 'to': to, };
            
            if (day1 == 'sunday') {
                timeslotworkSunday.push(timeslotworkVar);
            } else if (day1 == 'monday') {
                timeslotworkMonday.push(timeslotworkVar);
            } else if (day1 == 'tuesday') {
                timeslotworkTuesday.push(timeslotworkVar);
            } else if (day1 == 'wednesday') {
                timeslotworkWednesday.push(timeslotworkVar);
            } else if (day1 == 'thursday') {
                timeslotworkThursday.push(timeslotworkVar);
            } else if (day1 == 'friday') {
                timeslotworkFriday.push(timeslotworkVar);
            } else if (day1 == 'Saturday') {
                timeslotworkSaturday.push(timeslotworkVar);
            }

            $(".save_option_day_button" + day2 + count).hide();
            $("#to" + day2 + count).attr('disabled', "true");
            $("#from" + day2 + count).attr('disabled', "true");
        }

    }



    function handleFileSelectowner(evt) {
        var f = evt.target.files[0];
        var reader = new FileReader();
        reader.onload = (function (theFile) {
            return function (e) {

                var filePayload = e.target.result;
                var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                var val = f.name;
                var ext = val.split('.')[1];
                var docName = val.split('fakepath')[1];
                var filename = (f.name).replace(/C:\\fakepath\\/i, '')
                var timestamp = Number(new Date());
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                ownerphoto = filePayload;
                ownerFileName = filename;
                $("#uploaded_image_owner").attr('src', ownerphoto);
                $(".uploaded_image_owner").show();
            };
        })(f);
        reader.readAsDataURL(f);
    }

    function handleFileSelect(evt, type) {
        var f = evt.target.files[0];
        var reader = new FileReader();
        reader.onload = (function (theFile) {
            return function (e) {

                var filePayload = e.target.result;
                var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                var val = f.name;
                var ext = val.split('.')[1];
                var docName = val.split('fakepath')[1];
                var filename = (f.name).replace(/C:\\fakepath\\/i, '')

                var timestamp = Number(new Date());
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                photo = filePayload;
                if (photo) {
                    if (type == 'photo') {
                        vendorPhoto = filePayload;
                        vendorPhotoFileName = filename;
                        $("#uploaded_image").attr('src', photo);
                        $(".uploaded_image").show();
                    } else if (type == 'photos') {
                        photocount++;
                        photos_html = '<span class="image-item" id="photo_' + photocount + '"><span class="remove-btn" data-id="' + photocount + '" data-img="' + photo + '"><i class="fa fa-remove"></i></span><img width="100px" id="" height="auto" src="' + photo + '"></span>';
                        $("#photos").append(photos_html);
                        restaurnt_photos.push(photo);
                        restaurant_photos_filename.push(filename);
                    }
                }
            };
        })(f);
        reader.readAsDataURL(f);
    }

    function handleStoryFileSelect(evt) {
        var f = evt.target.files[0];
        var reader = new FileReader();
        var story_video_duration = $("#story_video_duration").val();
        var isVideo = document.getElementById('video_file');
        var videoValue = isVideo.value;
        var allowedExtensions = /(\.mp4)$/i;
        ;

        if (!allowedExtensions.exec(videoValue)) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>Error: Invalid video type</p>");
            window.scrollTo(0, 0);
            isVideo.value = '';
            return false;
        }

        var video = document.createElement('video');


        video.preload = 'metadata';

        video.onloadedmetadata = function () {

            window.URL.revokeObjectURL(video.src);


            if (video.duration > storevideoDuration) {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>Error: Story video duration maximum allow to " + storevideoDuration + " seconds</p>");
                window.scrollTo(0, 0);
                evt.target.value = '';
                return false;
            }

            reader.onload = (function (theFile) {
                return function (e) {

                    var filePayload = e.target.result;
                    var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                    var val = f.name;
                    var ext = val.split('.')[1];
                    var docName = val.split('fakepath')[1];
                    var filename = (f.name).replace(/C:\\fakepath\\/i, '')

                    var timestamp = Number(new Date());
                    var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;

                    var uploadTask = storyRef.child(filename).put(theFile);
                    console.log(uploadTask);
                    uploadTask.on('state_changed', function (snapshot) {

                        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        console.log('Upload is ' + progress + '% done');
                        jQuery("#uploding_story_video").text("video is uploading...");
                    }, function (error) {
                    }, function () {
                        uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                            jQuery("#uploding_story_video").text("Upload is completed");
                            setTimeout(function () {
                                jQuery("#uploding_story_video").empty();
                            }, 3000);

                            var nextCount = $("#story_vedios").children().length;
                            html = '<div class="col-md-3" id="story_div_' + nextCount + '">\n' +
                                '<div class="video-inner"><video width="320px" height="240px"\n' +
                                '                                   controls="controls">\n' +
                                '                            <source src="' + downloadURL + '"\n' +
                                '            type="video/mp4"></video><span class="remove-story-video" data-id="' + nextCount + '" data-img="' + downloadURL + '"><i class="fa fa-remove"></i></span></div></div>';

                            jQuery("#story_vedios").append(html);
                            story_vedios.push(downloadURL);
                            $("#video_file").val('');
                        });
                    });

                };
            })(f);
            reader.readAsDataURL(f);
        }
        video.src = URL.createObjectURL(f);
    }


    $(document).on("click", ".remove-story-video", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        firebase.storage().refFromURL(photo_remove).delete();
        $("#story_div_" + id).remove();
        index = story_vedios.indexOf(photo_remove);
        $("#video_file").val('');
        if (index > -1) {
            story_vedios.splice(index, 1);
        }

        var newhtml = '';
        if (story_vedios.length > 0) {
            for (var i = 0; i < story_vedios.length; i++) {
                newhtml += '<div class="col-md-3" id="story_div_' + i + '">\n' +
                    '<div class="video-inner"><video width="320px" height="240px"\n' +
                    'controls="controls">\n' +
                    '<source src="' + story_vedios[i] + '"\n' +
                    'type="video/mp4"></video><span class="remove-story-video" data-id="' + i + '" data-img="' + story_vedios[i] + '"><i class="fa fa-remove"></i></span></div></div>';
            }
        }
        jQuery("#story_vedios").html(newhtml);
        deleteStoryfromCollection();
    });

    $(document).on("click", ".remove-story-thumbnail", function () {
        var photo_remove = $(this).attr('data-img');
        $("#story_thumbnail").empty();
        
        story_thumbnail = '';
        deleteStoryfromCollection();
    
    });

    function deleteStoryfromCollection() {
        if (story_vedios.length == 0 && story_thumbnail == '') {
            database.collection('story').where('vendorID', '==', vendor_id).get().then(async function (snapshot) {
                if (snapshot.docs.length > 0) {
                    database.collection('story').doc(vendor_id).delete();
                }
            });
        }
    }

    function handleStoryThumbnailFileSelect(evt) {

        var f = evt.target.files[0];
        var reader = new FileReader();

        var fileInput =
            document.getElementById('file');

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        ;

        if (!allowedExtensions.exec(filePath)) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>Error: Invalid File type</p>");
            window.scrollTo(0, 0);
            fileInput.value = '';
            return false;
        }
        reader.onload = (function (theFile) {
            return function (e) {

                var filePayload = e.target.result;
                var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                var val = f.name;
                var ext = val.split('.')[1];
                var docName = val.split('fakepath')[1];
                var filename = (f.name).replace(/C:\\fakepath\\/i, '')

                var timestamp = Number(new Date());
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                story_thumbnail = filePayload;
                story_thumbnail_filename = filename;
                var html = '<div class="col-md-3"><div class="thumbnail-inner"><span class="remove-story-thumbnail" data-img="' + story_thumbnail + '"><i class="fa fa-remove"></i></span><img id="story_thumbnail_image" src="' + story_thumbnail + '" width="150px" height="150px;"></div></div>';
                jQuery("#story_thumbnail").html(html);
            };
        })(f);
        reader.readAsDataURL(f);
    }

    function handleFileSelectMenuCard(evt) {
        var f = evt.target.files[0];
        var reader = new FileReader();
        reader.onload = (function (theFile) {
            return function (e) {

                var filePayload = e.target.result;
                var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                var val = f.name;
                var ext = val.split('.')[1];
                var docName = val.split('fakepath')[1];
                var filename = (f.name).replace(/C:\\fakepath\\/i, '')

                var timestamp = Number(new Date());
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                photo = filePayload;

                if (photo) {

                    menuPhotoCount++;
                    photos_html = '<span class="image-item" id="photo_menu' + menuPhotoCount + '"><span class="remove-menu-btn" data-id="' + menuPhotoCount + '" data-img="' + photo + '"><i class="fa fa-remove"></i></span><img width="100px" id="" height="auto" src="' + photo + '"></span>';
                    $("#photos_menu_card").append(photos_html);
                    vendor_menu_photos.push(photo);
                    vendor_menu_filename.push(filename);
                }

            };
        })(f);
        reader.readAsDataURL(f);
    }

    $("#dine_in_feature").change(function () {
        if (this.checked) {
            $(".divein_div").show();
        } else {
            $(".divein_div").hide();
        }
    });

    $("#section_id").change(function () {
        var selected_section = this.value;

        var serice_type = $("#section_id option:selected").data('type');
        if (serice_type == "ecommerce-service") {
            $("#delivery_charges_div").hide();
            $(".ecommerce_div").addClass('d-none');
        } else {
            $("#delivery_charges_div").show();
            $(".ecommerce_div").removeClass('d-none');

        }
        if (serice_type == "delivery-service" && story_isEnabled == true) {
            $('#story_upload_div').show();
        } else {
            $('#story_upload_div').hide();
        }

        $("#is_dine_in_feature").hide();
        dine_in_active = false;
        $("#services_feature").show();
        $('#vendor_cuisines').html('');
        $('#vendor_cuisines').val('');
        categories_list.forEach((data) => {
            if (selected_section == data.section_id) {
                $('#vendor_cuisines').append($("<option></option>")
                    .attr("value", data.id)
                    .text(data.title));
            }
        })
        sections_list.forEach((section) => {
            if (section.id == selected_section) {

                if (section.dine_in_active == true) {
                    $("#is_dine_in_feature").show();
                    $("#services_feature").show();
                    dine_in_active = true;
                }
            }
        });
    });

    function chkAlphabets(event, msg) {
        if (!(event.which >= 97 && event.which <= 122) && !(event.which >= 65 && event.which <= 90)) {
            document.getElementById(msg).innerHTML = "Accept only Alphabets";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }

    function chkAlphabets2(event, msg) {
        if (!(event.which >= 48 && event.which <= 57)
        ) {
            document.getElementById(msg).innerHTML = "Accept only Number";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }

    function chkAlphabets3(event, msg) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            document.getElementById(msg).innerHTML = "Accept only Number and Dot(.)";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }
    async function storeImageData() {
        var newPhoto = [];
        newPhoto['ownerImage'] = '';
        newPhoto['vendorImage'] = '';
        try {
            if (ownerphoto != '') {
                ownerphoto = ownerphoto.replace(/^data:image\/[a-z]+;base64,/, "")
                var uploadTask = await storageRef.child(ownerFileName).putString(ownerphoto, 'base64', { contentType: 'image/jpg' });
                var downloadURL = await uploadTask.ref.getDownloadURL();
                newPhoto['ownerImage'] = downloadURL;
                ownerphoto = downloadURL;
            }
            if (vendorPhoto != '') {
                vendorPhoto = vendorPhoto.replace(/^data:image\/[a-z]+;base64,/, "")
                var uploadTask = await storageRef.child(vendorPhotoFileName).putString(vendorPhoto, 'base64', { contentType: 'image/jpg' });
                var downloadURL = await uploadTask.ref.getDownloadURL();
                newPhoto['vendorImage'] = downloadURL;
            }
        } catch (error) {
            console.log("ERR ===", error);
        }
        return newPhoto;
    }
    async function storeStoryImageData() {
        var newPhoto = [];
        newPhoto['storyThumbnailImage'] = '';
        try {
            if (story_thumbnail != '') {
                story_thumbnail = story_thumbnail.replace(/^data:image\/[a-z]+;base64,/, "")
                var uploadTask = await storageRef.child(story_thumbnail_filename).putString(story_thumbnail, 'base64', { contentType: 'image/jpg' });
                var downloadURL = await uploadTask.ref.getDownloadURL();
                newPhoto['storyThumbnailImage'] = downloadURL;
            }
        } catch (error) {
            console.log("ERR ===", error);
        }
        return newPhoto;
    }
    async function storeGalleryImageData() {
        var newPhoto = [];
        if (restaurnt_photos.length > 0) {
            await Promise.all(restaurnt_photos.map(async (resPhoto, index) => {
                resPhoto = resPhoto.replace(/^data:image\/[a-z]+;base64,/, "");
                var uploadTask = await storageRef.child(restaurant_photos_filename[index]).putString(resPhoto, 'base64', { contentType: 'image/jpg' });
                var downloadURL = await uploadTask.ref.getDownloadURL();
                newPhoto.push(downloadURL);
            }));
        }
        return newPhoto;
    }
    async function storeMenuImageData() {
        var newPhoto = [];
        if (vendor_menu_photos.length > 0) {
            await Promise.all(vendor_menu_photos.map(async (menuPhoto, index) => {
                menuPhoto = menuPhoto.replace(/^data:image\/[a-z]+;base64,/, "");
                var uploadTask = await storageRef.child(vendor_menu_filename[index]).putString(menuPhoto, 'base64', { contentType: 'image/jpg' });
                var downloadURL = await uploadTask.ref.getDownloadURL();
                newPhoto.push(downloadURL);
            }));
        }
        return newPhoto;
    }
    $(document).on("click", ".remove-btn", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        $("#photo_" + id).remove();
        index = restaurnt_photos.indexOf(photo_remove);
        if (index > -1) {
            restaurnt_photos.splice(index, 1); // 2nd parameter means remove one item only
        }

    });
    $(document).on("click", ".remove-menu-btn", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        $("#photo_menu" + id).remove();
        index = vendor_menu_photos.indexOf(photo_remove);
        if (index > -1) {
            vendor_menu_photos.splice(index, 1); // 2nd parameter means remove one item only
        }

    });



</script>
@endsection