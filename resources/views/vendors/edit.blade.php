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
                <li class="breadcrumb-item active">{{trans('lang.vendor_edit')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
            {{trans('lang.processing')}}
        </div>
        <div class="row">
            <div class="col-12">

                <div class="resttab-sec">


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
                                    <input type="file" onChange="handleFileSelectowner(event,'vendor')" class="col-7">
                                    <div id="uploding_image_owner"></div>

                                    <div class="uploaded_image_owner" style="display:none;">
                                    </div>
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
                                            {{trans('lang.rental_parcel_cab_service_are_not')}} </p>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend>{{trans('lang.vendor_details')}}</legend>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.vendor_name')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control vendor_name">
                                        <div class="form-text text-muted">
                                            {{ trans("lang.vendor_name_help") }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.vendor_cuisine')}}</label>
                                    <div class="col-7">
                                        <select id='vendor_cuisines' class="form-control">
                                            <option value="">{{trans('lang.select_category')}}</option>
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
                                            onkeypress="return chkAlphabets2(event,'error2')">
                                        <div id="error2" class="err"></div>
                                        <div class="form-text text-muted">
                                            {{ trans("lang.vendor_phone_help") }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.vendor_address')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control vendor_address">
                                        <div class="form-text text-muted">
                                            {{ trans("lang.vendor_address_help") }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <div class="col-12">
                                        <h6>* Don't Know your cordinates ? use <a target="_blank"
                                                href="https://www.latlong.net/">Latitude
                                                and Longitude Finder</a></h6>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.vendor_latitude')}}</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control vendor_latitude"
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
                                        <input type="text" class="form-control vendor_longitude"
                                            onkeypress="return chkAlphabets3(event,'error4')">
                                        <div id="error4" class="err"></div>
                                        <div class="form-text text-muted">
                                            {{ trans("lang.vendor_longitude_help") }}
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

                                <div class="form-group row width-100">
                                    <label class="col-3 control-label">{{trans('lang.vendor_image')}}</label>
                                    <div class="col79">
                                        <input type="file" onChange="handleFileSelect(event,'photo')">
                                        <div id="uploding_image"></div>
                                        <div class="uploaded_image" style="display:none;">
                                        </div>
                                        <div class="form-text text-muted">
                                            {{ trans("lang.vendor_image_help") }}
                                        </div>
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
                                    <label class="col-12 control-label"
                                        style="color:red;font-size:15px;">{{trans('lang.working_hour_note')}}</label>
                                    <div class="form-group row width-100">
                                        <div class="col-7">
                                            <button type="button"
                                                class="btn btn-primary  add_working_hours_restaurant_btn">
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


                                        <div class="restaurant_discount_options_Sunday_div restaurant_discount"
                                            style="display:none">


                                            <table class="booking-table" id="working_hour_table_Sunday">
                                                <tr>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.from')}}</label>
                                                    </th>
                                                    <th>
                                                        <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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

                                        <div class="restaurant_discount_options_Monday_div restaurant_discount"
                                            style="display:none">

                                            <table class="booking-table" id="working_hour_table_Monday">
                                                <tr>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.from')}}</label>
                                                    </th>
                                                    <th>
                                                        <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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

                                        <div class="restaurant_discount_options_Tuesday_div restaurant_discount"
                                            style="display:none">

                                            <table class="booking-table" id="working_hour_table_Tuesday">
                                                <tr>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.from')}}</label>
                                                    </th>
                                                    <th>
                                                        <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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


                                        <div class="restaurant_discount_options_Wednesday_div restaurant_discount"
                                            style="display:none">
                                            <table class="booking-table" id="working_hour_table_Wednesday">
                                                <tr>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.from')}}</label>
                                                    </th>
                                                    <th>
                                                        <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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

                                        <div class="restaurant_discount_options_Thursday_div restaurant_discount"
                                            style="display:none">
                                            <table class="booking-table" id="working_hour_table_Thursday">
                                                <tr>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.from')}}</label>
                                                    </th>
                                                    <th>
                                                        <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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

                                        <div class="restaurant_discount_options_Friday_div restaurant_discount"
                                            style="display:none">
                                            <table class="booking-table" id="working_hour_table_Friday">
                                                <tr>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.from')}}</label>
                                                    </th>
                                                    <th>
                                                        <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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
                                        <div class="restaurant_discount_options_Saturday_div restaurant_discount"
                                            style="display:none">
                                            <table class="booking-table" id="working_hour_table_Saturday">
                                                <tr>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.from')}}</label>
                                                    </th>
                                                    <th>
                                                        <label class="col-3 control-label">{{trans('lang.to')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>


                            <fieldset>
                                <legend>{{trans('lang.vendor')}} {{trans('lang.active_deactive')}}</legend>

                                <div class="form-group row width-100">
                                    <div class="form-check">
                                        <input type="checkbox" id="is_active">
                                        <label class="col-3 control-label"
                                            for="is_active">{{trans('lang.active')}}</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" id="reset_password">
                                        <label
                                            class="col-3 control-label">{{trans('lang.reset_store_password')}}</label>

                                    </div>
                                    <div class="form-group row width-100">
                                        <div class="form-text text-muted w-100 col-12">
                                            {{ trans("lang.note_reset_store_password_email") }}
                                        </div>
                                    </div>
                                    <div class="form-button" style="margin-top: 16px;margin-left: 20px;">
                                        <button type="button" class="btn btn-primary"
                                            id="send_mail">{{trans('lang.send_mail')}}
                                        </button>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset style="display: none;" id="services_feature">
                                <legend>{{trans('lang.services')}}</legend>
                                <div class="form-group row">

                                    <div class="form-check width-100">
                                        <input type="checkbox" id="Free_Wi_Fi">
                                        <label class="col-3 control-label"
                                            for="Free_Wi_Fi">{{trans('lang.wifi')}}</label>
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

                            <fieldset style="display: none;" id="is_dine_in_feature">
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

                            <fieldset class="delivery_charges_div">
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

                                <div class="form-group row">

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.bank_name')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="bank_name" class="form-control" id="bankName">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.branch_name')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="branch_name" class="form-control" id="branchName">
                                        </div>
                                    </div>


                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.holer_name')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="holer_name" class="form-control" id="holderName">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.account_number')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="account_number" class="form-control"
                                                id="accountNumber">
                                        </div>
                                    </div>

                                    <div class="form-group row width-100">
                                        <label class="col-4 control-label">{{
                                            trans('lang.other_information')}}</label>
                                        <div class="col-7">
                                            <input type="text" name="other_information" class="form-control"
                                                id="otherDetails">
                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>{{trans('lang.special_offer')}}</legend>

                                <div class="form-group row">
                                    <label class="col-12 control-label"
                                        style="color:red;font-size:15px;">{{trans('lang.special_discount_note')}}</label>
                                    <div class="form-group row width-100">
                                        <div class="form-check width-100">
                                            <input type="checkbox" id="enable_special_offer">
                                            <label class="col-3 control-label"
                                                for="enable_special_offer">{{trans('lang.enable_special_offer')}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row width-100">
                                        <div class="col-7">
                                            <button type="button"
                                                class="btn btn-primary  add_special_offer_restaurant_btn">
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
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                            {{trans('lang.type')}}</label>
                                                    </th>

                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                            {{trans('lang.type')}}</label>
                                                    </th>
                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                            {{trans('lang.type')}}</label>
                                                    </th>

                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                            {{trans('lang.type')}}</label>
                                                    </th>

                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                            {{trans('lang.type')}}</label>
                                                    </th>

                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                            {{trans('lang.type')}}</label>
                                                    </th>

                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
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
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.coupon_discount')}}
                                                            {{trans('lang.type')}}</label>
                                                    </th>

                                                    <th>
                                                        <label
                                                            class="col-3 control-label">{{trans('lang.actions')}}</label>
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </fieldset>
                            <fieldset id="story_upload_div" style="display: none;">
                                <legend>Story</legend>

                                <div class="form-group row vendor_image">
                                    <label class="col-12 control-label">Choose humbling GIF/Image</label>
                                    <div class="col-12">
                                        <div id="story_thumbnail" class="row"></div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-12">
                                        <input type="file" id="file" onChange="handleStoryThumbnailFileSelect(event)">
                                        <div id="uploding_story_thumbnail"></div>
                                    </div>
                                </div>

                                <div class="restaurant_uploadStory_div">
                                    <div class="form-group row vendor_image">
                                        <label class="col-12 control-label">Select Story Video</label>
                                        <div class="col-12">
                                            <div id="story_vedios" class="row"></div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <input type="file" id="video_file" onChange="handleStoryFileSelect(event)">
                                            <div id="uploding_story_video"></div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group col-12 text-center btm-btn">
            <button type="button" class="btn btn-primary  save_vendor_btn"><i class="fa fa-save"></i>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>

<script type="text/javascript">

    var id = "<?php echo $id; ?>";
    var database = firebase.firestore();
    var ref = database.collection('vendors').where("id", "==", id);
    var ref_sections = database.collection('sections');
    var photo = "";

    var vendorOwnerId = "";
    var vendorOwnerOnline = false;
    var photocount = 0;

    var vendorPhoto = '';
    var vendorPhotoFileName = '';
    var vendorPhotoOldImageFile = '';

    var ownerPhoto = '';
    var ownerFileName = '';
    var ownerOldImageFile = '';

    var ownerId = '';

    var vendor_photos = [];
    var new_added_vendor_photos_filename = [];
    var new_added_vendor_photos = [];
    var galleryImageToDelete = [];

    var menuPhotoCount = 0;
    var vendorMenuPhotos = "";
    var vendor_menu_photos = [];
    var new_added_vendor_menu_filename = [];
    var new_added_vendor_menu = [];
    var menuImageToDelete = [];

    var sections_list = [];
    var categories_list = [];
    var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
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

    var story_upload_time = [];
    var story_vedios = [];
    var story_thumbnail = '';
    var story_thumbnail_filename = '';
    var story_thumbnail_oldfile = '';

    var storevideoDuration = 0;
    var story_isEnabled = false;
    var storyCount = 0;
    var storyRef = firebase.storage().ref('Story');
    var storyImagesRef = firebase.storage().ref('Story/images');
    var storageRef = firebase.storage().ref('images');
    var storage = firebase.storage();

    var specialDiscount = [];
    var timeslotSunday = [];
    var timeslotMonday = [];
    var timeslotTuesday = [];
    var timeslotWednesday = [];
    var timeslotFriday = [];
    var timeslotSaturday = [];
    var timeslotThursday = [];
    var currentCurrency = '';
    var currencyAtRight = false;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;
    });

    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })
    database.collection('settings').doc("story").get().then(async function (snapshots) {
        var story_data = snapshots.data();
        if (story_data.isEnabled) {
            story_isEnabled = true;
        }
        storevideoDuration = story_data.videoDuration;
    });
    var dine_in_active = false;

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

    $("#send_mail").click(function () {
        if ($("#reset_password").is(":checked")) {
            var email = $(".user_email").val();
            firebase.auth().sendPasswordResetEmail(email)
                .then((res) => {
                    alert('{{trans("lang.store_mail_sent")}}');
                })
                .catch((error) => {
                    console.log('Error password reset: ', error);
                });
        } else {
            alert('{{trans("lang.error_reset_store_password")}}');
        }
    });

    $(document).ready(function () {

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

        jQuery("#data-table_processing").show();
        ref.get().then(async function (snapshots) {
            var vendor = snapshots.docs[0].data();
            $(".vendor_name").val(vendor.title);
            try {
                $("#vendor_cuisines").val(vendor.filters.Cuisine);
            } catch (err) {

            }
            $(".vendor_address").val(vendor.location);
            $(".vendor_latitude").val(vendor.latitude);
            $(".vendor_longitude").val(vendor.longitude);
            $(".vendor_description").val(vendor.description);
            if (vendor.section_id != undefined) {
                $("#section_id").val(vendor.section_id);
                var selected_section = vendor.section_id;
                sections_list.forEach((section) => {
                    if (section.id == selected_section) {
                        if (section.dine_in_active == true) {
                            $("#is_dine_in_feature").show();
                            $("#services_feature").show();
                            dine_in_active = true;
                        }
                    }
                    if (section.id == selected_section && section.serviceTypeFlag == "ecommerce-service") {
                        $(".delivery_charges_div").hide();
                        $(".ecommerce_div").addClass('d-none');
                    }
                    if (section.id == selected_section && section.serviceTypeFlag == "delivery-service" && story_isEnabled == true) {
                        $("#story_upload_div").show();
                    }
                });

            }

            if (vendor.photo) {
                if (vendor.photo != '') {
                    vendorPhoto = vendor.photo;
                    vendorPhotoOldImageFile = vendor.photo;
                    if(vendor.photo){
                        photo=vendor.photo;
                    }else{
                        photo=placeholderImage;
                    }
                    $(".uploaded_image").html('<img id="uploaded_image" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="150px" height="150px;">');
                    $(".uploaded_image").show();
                } else {
                    $(".uploaded_image").html('<img id="uploaded_image" src="' + placeholderImage + '" width="150px" height="150px;">');
                    $(".uploaded_image").show();
                }
            } else {
                $("#uploaded_image").attr('src', placeholderImage);
                $(".uploaded_image").show();
            }

            if (vendor.opentime) {
                vendor.opentime = moment(vendor.opentime, 'hh:mm A').format('HH:mm');
            }

            if (vendor.closetime) {
                vendor.closetime = moment(vendor.closetime, 'hh:mm A').format('HH:mm');

            }
            $("#opentime").val(vendor.opentime);
            $("#closetime").val(vendor.closetime);


            if (vendor.openDineTime) {
                vendor.openDineTime = moment(vendor.openDineTime, 'hh:mm A').format('HH:mm');
            }

            if (vendor.closeDineTime) {
                vendor.closeDineTime = moment(vendor.closeDineTime, 'hh:mm A').format('HH:mm');

            }
            $("#openDineTime").val(vendor.openDineTime);
            $("#closeDineTime").val(vendor.closeDineTime);

            if (vendor.hasOwnProperty('enabledDiveInFuture')) {
                if (vendor.enabledDiveInFuture) {
                    $("#dine_in_feature").prop("checked", true);
                }
            }

            if (vendor.hasOwnProperty('vendorMenuPhotos')) {
                vendorMenuPhotos = vendor.vendorMenuPhotos;
            }

            if (vendor.hasOwnProperty('vendorCost')) {
                $(".vendor_cost").val(vendor.vendorCost);
            }

            for (var key in vendor.filters) {

                if (key == "Free Wi-Fi" && vendor.filters[key] == "Yes") {
                    $("#Free_Wi_Fi").prop("checked", true);
                }
                if (key == "Good for Breakfast" && vendor.filters[key] == "Yes") {
                    $("#Good_for_Breakfast").prop("checked", true);
                }
                if (key == "Good for Dinner" && vendor.filters[key] == "Yes") {
                    $("#Good_for_Dinner").prop("checked", true);
                }
                if (key == "Good for Lunch" && vendor.filters[key] == "Yes") {
                    $("#Good_for_Lunch").prop("checked", true);
                }
                if (key == "Live Music" && vendor.filters[key] == "Yes") {
                    $("#Live_Music").prop("checked", true);
                }
                if (key == "Outdoor Seating" && vendor.filters[key] == "Yes") {
                    $("#Outdoor_Seating").prop("checked", true);
                }
                if (key == "Takes Reservations" && vendor.filters[key] == "Yes") {
                    $("#Takes_Reservations").prop("checked", true);
                }
                if (key == "Vegetarian Friendly" && vendor.filters[key] == "Yes") {
                    $("#Vegetarian_Friendly").prop("checked", true);
                }


            }

            vendor_photos = vendor.photos;
            var photos = '';
            var menuCardPhotos = '';
            if (vendor_photos.length > 0) {
                vendor.photos.forEach((photo) => {
                    photocount++;
                    photos = photos + '<span class="image-item" id="photo_' + photocount + '"><span class="remove-btn" data-id="' + photocount + '" data-img="' + photo + '" data-status="old"><i class="fa fa-remove"></i></span><img width="100px" id="" height="auto" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>';
                })
            }
            if (photos) {
                $("#photos").html(photos);
            } else {
                $("#photos").html('<p>photos not available.</p>');
            }


            if (vendor.hasOwnProperty('vendorMenuPhotos')) {
                vendor_menu_photos = vendor.vendorMenuPhotos;
                vendor.vendorMenuPhotos.forEach((photo) => {
                    menuPhotoCount++;
                    menuCardPhotos = menuCardPhotos + '<span class="image-item" id="photo_menu_' + menuPhotoCount + '"><span class="remove-menu-btn" data-id="' + menuPhotoCount + '" data-img="' + photo + '" data-status="old"><i class="fa fa-remove"></i></span><img width="100px" id="" height="auto" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>';
                })
            }

            for (var key in vendor.filters) {

                if (key == "Free Wi-Fi" && vendor.filters[key] == "Yes") {
                    $("#Free_Wi_Fi").prop("checked", true);
                }
                if (key == "Good for Breakfast" && vendor.filters[key] == "Yes") {
                    $("#Good_for_Breakfast").prop("checked", true);
                }
                if (key == "Good for Dinner" && vendor.filters[key] == "Yes") {
                    $("#Good_for_Dinner").prop("checked", true);
                }
                if (key == "Good for Lunch" && vendor.filters[key] == "Yes") {
                    $("#Good_for_Lunch").prop("checked", true);
                }
                if (key == "Live Music" && vendor.filters[key] == "Yes") {
                    $("#Live_Music").prop("checked", true);
                }
                if (key == "Outdoor Seating" && vendor.filters[key] == "Yes") {
                    $("#Outdoor_Seating").prop("checked", true);
                }
                if (key == "Takes Reservations" && vendor.filters[key] == "Yes") {
                    $("#Takes_Reservations").prop("checked", true);
                }
                if (key == "Vegetarian Friendly" && vendor.filters[key] == "Yes") {
                    $("#Vegetarian_Friendly").prop("checked", true);
                }

            }

            if (vendor.hasOwnProperty('specialDiscountEnable')) {
                if (vendor.specialDiscountEnable) {
                    $("#enable_special_offer").prop("checked", true);
                }
            }

            if (vendor.hasOwnProperty('specialDiscount')) {
                for (i = 0; i < vendor.specialDiscount.length; i++) {
                    var day = vendor.specialDiscount[i]['day'];
                    if (vendor.specialDiscount[i]['timeslot'].length > 0) {
                        for (j = 0; j < vendor.specialDiscount[i]['timeslot'].length; j++) {
                            $(".restaurant_discount_options_" + day + "_div").show();

                            if (vendor.specialDiscount[i]) {
                                if (vendor.specialDiscount[i]['timeslot']) {

                                    if (vendor.specialDiscount[i]['timeslot'].length > 0) {
                                        if (vendor.specialDiscount[i]['timeslot'][j]) {
                                            var timeslot = vendor.specialDiscount[i]['timeslot'][j];

                                            if (timeslot['discount']) {
                                                var discount = timeslot['discount'];

                                                var TimeslotVar = {
                                                    'discount': timeslot[`discount`],
                                                    'from': timeslot[`from`],
                                                    'to': timeslot[`to`],
                                                    'type': timeslot[`type`],
                                                    'discount_type': timeslot[`discount_type`]
                                                };
                                                if (day == 'Sunday') {
                                                    timeslotSunday.push(TimeslotVar);
                                                } else if (day == 'Monday') {
                                                    timeslotMonday.push(TimeslotVar);
                                                } else if (day == 'Tuesday') {
                                                    timeslotTuesday.push(TimeslotVar);
                                                } else if (day == 'Wednesday') {
                                                    timeslotWednesday.push(TimeslotVar);
                                                } else if (day == 'Thursday') {
                                                    timeslotThursday.push(TimeslotVar);
                                                } else if (day == 'Friday') {
                                                    timeslotFriday.push(TimeslotVar);
                                                } else if (day == 'Saturday') {
                                                    timeslotSaturday.push(TimeslotVar);
                                                }


                                                $('#special_offer_table_' + day + ' tr:last').after('<tr>' +
                                                    '<td class="" style="width:10%;"><input type="time" class="form-control ' + i + '_' + j + '_row" value="' + timeslot[`from`] + '" id="openTime' + day + j + i + '" onchange="replaceText(`' + i + '`,`' + j + '`,`specialDiscount`)"></td>' +
                                                    '<td class="" style="width:10%;"><input type="time" class="form-control ' + i + '_' + j + '_row" value="' + timeslot[`to`] + '" id="closeTime' + day + j + i + '" onchange="replaceText(`' + i + '`,`' + j + '`,`specialDiscount`)"></td>' +
                                                    '<td class="" style="width:30%;">' +
                                                    '<input type="number" class="form-control ' + i + '_' + j + '_row" value="' + timeslot[`discount`] + '" style="width:60%;" id="discount' + day + j + i + '" onchange="replaceText(`' + i + '`,`' + j + '`,`specialDiscount`)">' +
                                                    '<select id="discount_type' + day + j + i + '" class="form-control ' + i + '_' + j + '_row"  style="width:40%;" onchange="replaceText(`' + i + '`,`' + j + '`,`specialDiscount`)"><option value="percentage"/>%</option><option value="amount"/>' + currentCurrency + '</option></select></td>' +
                                                    '<td style="width:30%;"><select id="type' + day + j + i + '" class="form-control ' + i + '_' + j + '_row" onchange="replaceText(`' + i + '`,`' + j + '`,`specialDiscount`)"><option value="delivery"/>Delivery Discount</option></select>' +
                                                    '</td>' +
                                                    '<td class="action-btn" style="width:20%;">' +
                                                    '<button type="button" class="btn btn-primary ' + i + '_' + j + '_row  specialDiscount_' + i + '_' + j + '"  onclick="updateMoreFunctionButton(`' + day + '`,`' + j + '`,`' + i + '`)" ><i class="fa fa-edit"></i></button>' +
                                                    '&nbsp;&nbsp;<button type="button" class="btn btn-primary ' + i + '_' + j + '_row" onclick="deleteOffer(`' + day + '`,`' + j + '`,`' + i + '`)" ><i class="fa fa-trash"></i></button>' +
                                                    '</td></tr>');

                                                if (timeslot[`type`] == 'amount') {
                                                    $('#discount_type' + day + j + i).val(timeslot[`type`]);
                                                }
                                                if (timeslot[`discount_type`] == 'dinein') {
                                                    $('#type' + day + j + i).val(timeslot[`discount_type`]);
                                                }
                                            }

                                        }
                                    }

                                }
                            }

                        }
                    }
                }
            }


            if (vendor.hasOwnProperty('workingHours')) {
                for (i = 0; i < vendor.workingHours.length; i++) {
                    var day = vendor.workingHours[i]['day'];
                    if (vendor.workingHours[i]['timeslot'].length != 0) {
                        for (j = 0; j < vendor.workingHours[i]['timeslot'].length; j++) {
                            $(".restaurant_discount_options_" + day + "_div").show();
                            var timeslot = vendor.workingHours[i]['timeslot'][j];

                            var discount = vendor.workingHours[i]['timeslot'][j]['discount'];
                            var TimeslotHourVar = { 'from': timeslot[`from`], 'to': timeslot[`to`] };
                            if (day == 'Sunday') {
                                timeslotworkSunday.push(TimeslotHourVar);
                            } else if (day == 'Monday') {
                                timeslotworkMonday.push(TimeslotHourVar);
                            } else if (day == 'Tuesday') {
                                timeslotworkTuesday.push(TimeslotHourVar);
                            } else if (day == 'Wednesday') {
                                timeslotworkWednesday.push(TimeslotHourVar);
                            } else if (day == 'Thursday') {
                                timeslotworkThursday.push(TimeslotHourVar);
                            } else if (day == 'Friday') {
                                timeslotworkFriday.push(TimeslotHourVar);
                            } else if (day == 'Saturday') {
                                timeslotworkSaturday.push(TimeslotHourVar);
                            }
 

                            $('#working_hour_table_' + day + ' tr:last').after('<tr>' +
                                '<td class="" style="width:50%;"><input type="time" class="form-control ' + i + '_' + j + '_row" value="' + timeslot[`from`] + '" id="from' + day + j + i + '" onchange="replaceText(`' + i + '`,`' + j + '`,`workingHours`)"></td>' +
                                '<td class="" style="width:50%;"><input type="time" class="form-control ' + i + '_' + j + '_row" value="' + timeslot[`to`] + '" id="to' + day + j + i + '" onchange="replaceText(`' + i + '`,`' + j + '`,`workingHours`)"></td>' +
                                '<td class="action-btn" style="width:20%;">' +
                                '<button type="button" class="btn btn-primary ' + i + '_' + j + '_row workingHours_' + i + '_' + j + '"  onclick="updatehoursFunctionButton(`' + day + '`,`' + j + '`,`' + i + '`)" ><i class="fa fa-edit"></i></button>' +
                                '&nbsp;&nbsp;<button type="button" class="btn btn-primary ' + i + '_' + j + '_row" onclick="deleteWorkingHour(`' + day + '`,`' + j + '`,`' + i + '`)" ><i class="fa fa-trash"></i></button>' +
                                '</td></tr>');


                        }
                    }
                }
            }
            if (menuCardPhotos) {
                $("#photos_menu_card").html(menuCardPhotos);
            } else {
                $("#photos_menu_card").html('<p>Menu card photos not available.</p>');
            }

            vendorOwnerOnline = vendor.isActive;
            if (vendor.hasOwnProperty('enabledDiveInFuture') && vendor.enabledDiveInFuture == true) {
                $(".divein_div").show();
            }

            vendorOwnerOnline = vendor.isActive;
            photo = vendor.photo;
            vendorOwnerId = vendor.author;
            await database.collection('users').where("id", "==", vendor.author).get().then(async function (snapshots) {
                snapshots.docs.forEach((listval) => {
                    var user = listval.data();

                    ownerId = user.id;
                    ownerPhoto = user.profilePictureURL
                    $(".user_first_name").val(user.firstName);
                    $(".user_last_name").val(user.lastName);
                    $(".user_email").val(user.email);
                    $(".user_phone").val(user.phoneNumber);
                    if (user.profilePictureURL != '') {
                        ownerPhoto = user.profilePictureURL
                        ownerOldImageFile = user.profilePictureURL;
                        if(user.profilePictureURL){
                            photo=user.profilePictureURL;
                        }else{
                            photo=placeholderImage;
                        }
                        $(".uploaded_image_owner").html('<img id="uploaded_image_owner" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="150px" height="150px;">');
                        $(".uploaded_image_owner").show();
                    } else {
                        $(".uploaded_image_owner").html('<img id="uploaded_image_owner" src="' + placeholderImage + '" width="150px" height="150px;">');
                        $(".uploaded_image_owner").show();
                    }


                    if (user.active) {
                        vendor_active = true;
                        $("#is_active").prop("checked", true);
                    }


                    if (user.userBankDetails) {
                        if (user.userBankDetails.bankName != undefined) {
                            $("#bankName").val(user.userBankDetails.bankName);
                        }
                        if (user.userBankDetails.branchName != undefined) {
                            $("#branchName").val(user.userBankDetails.branchName);
                        }
                        if (user.userBankDetails.holderName != undefined) {
                            $("#holderName").val(user.userBankDetails.holderName);
                        }
                        if (user.userBankDetails.accountNumber != undefined) {
                            $("#accountNumber").val(user.userBankDetails.accountNumber);
                        }
                        if (user.userBankDetails.otherDetails != undefined) {
                            $("#otherDetails").val(user.userBankDetails.otherDetails);
                        }
                    }

                })


            });


            await database.collection('vendor_categories').where('publish', '==', true).get().then(async function (snapshots) {
                snapshots.docs.forEach((listval) => {
                    var data = listval.data();
                    categories_list.push(data);
                    if (data.id == vendor.categoryID) {
                        $('#vendor_cuisines').append($("<option selected></option>")
                            .attr("value", data.id)
                            .text(data.title));
                    } else {
                        $('#vendor_cuisines').append($("<option></option>")
                            .attr("value", data.id)
                            .text(data.title));
                    }
                })

            });


            if (vendor.hasOwnProperty('phonenumber')) {
                $(".vendor_phone").val(vendor.phonenumber);
            }

            if (vendor.deliveryCharge && deliveryChargeFlag) {
                $("#delivery_charges_per_km").val(vendor.deliveryCharge.delivery_charges_per_km);
                $("#minimum_delivery_charges").val(vendor.deliveryCharge.minimum_delivery_charges);
                $("#minimum_delivery_charges_within_km").val(vendor.deliveryCharge.minimum_delivery_charges_within_km);
            }

            await getRestaurantStory(vendor.id);

            if (story_vedios.length > 0) {
                var html = '';
                for (var i = 0; i < story_vedios.length; i++) {
                    html += '<div class="col-md-3" id="story_div_' + i + '">\n' +
                        '<div class="video-inner"><video width="320px" height="240px"\n' +
                        '                                   controls="controls">\n' +
                        '                            <source src="' + story_vedios[i] + '"\n' +
                        '            type="video/mp4"></video><span class="remove-story-video" data-id="' + i + '" data-img="' + story_vedios[i] + '"><i class="fa fa-remove"></i></span></div></div>';

                }
                jQuery("#story_vedios").append(html);
            }

            if (story_thumbnail) {

                html = '<div class="col-md-3"><div class="thumbnail-inner"><span class="remove-story-thumbnail" data-img="' + story_thumbnail + '"><i class="fa fa-remove"></i></span><img id="story_thumbnail_image" src="' + story_thumbnail + '" width="150px" height="150px;" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></div></div>';
                jQuery("#story_thumbnail").html(html);

            }

            jQuery("#data-table_processing").hide();
        })

        async function getRestaurantStory(vendorId) {
            await database.collection('story').where('vendorID', '==', vendorId).get().then(async function (snapshots) {

                if (snapshots.docs.length > 0) {

                    var story_data = snapshots.docs[0].data();

                    story_vedios = story_data.videoUrl;
                    story_thumbnail = story_data.videoThumbnail;
                    story_thumbnail_oldfile = story_data.videoThumbnail;

                }
            });
        }

        $(".save_vendor_btn").click(async function () {

            var vendorname = $(".vendor_name").val();
            var cuisines = $("#vendor_cuisines option:selected").val();
            var address = $(".vendor_address").val();
            var latitude = parseFloat($(".vendor_latitude").val());
            var longitude = parseFloat($(".vendor_longitude").val());
            var description = $(".vendor_description").val();
            var phonenumber = $(".vendor_phone").val();
            var categoryTitle = $("#vendor_cuisines option:selected").text();

            var userFirstName = $(".user_first_name").val();
            var userLastName = $(".user_last_name").val();
            var email = $(".user_email").val();
            var userPhone = $(".user_phone").val();
            var section_id = $("#section_id").val();

            var enabledDiveInFuture = $("#dine_in_feature").is(':checked');

            var vendorCost = $(".vendor_cost").val();

            var vendor_active = false;
            if ($("#is_active").is(':checked')) {
                vendor_active = true;
            }

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
            if ($("#Free_Wi_Fi").is(':checked')) {
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

            }
             else {
                jQuery("#data-table_processing").show();

                coordinates = new firebase.firestore.GeoPoint(latitude, longitude);

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
                await storeImageData().then(async (IMG) => {
                    await storeGalleryImageData().then(async (GalleryIMG) => {
                        await storeMenuImageData().then(async (MenuIMG) => {
                            database.collection('users').doc(ownerId).update({
                                'firstName': userFirstName,
                                'lastName': userLastName,
                                'email': email,
                                'phoneNumber': userPhone,
                                'profilePictureURL': IMG.ownerImage,
                                'active': vendor_active,
                                'userBankDetails': userBankDetails,
                                'section_id': section_id
                            }).then(function (result) {


                                geoFirestore.collection('vendors').doc(id).update({
                                    'section_id': section_id,
                                    'title': vendorname,
                                    'description': description,
                                    'latitude': latitude,
                                    'longitude': longitude,
                                    'location': address,
                                    'photo': IMG.vendorImage,
                                    'photos': GalleryIMG,
                                    'categoryID': cuisines,
                                    'phonenumber': phonenumber,
                                    'categoryTitle': categoryTitle,
                                    'coordinates': coordinates,
                                    'filters': filters_new,
                                    'enabledDiveInFuture': enabledDiveInFuture,
                                    'specialDiscountEnable':enabledSpecialOffer,
                                    'vendorMenuPhotos': MenuIMG,
                                    'vendorCost': vendorCost,
                                    'openDineTime': openDineTime,
                                    'closeDineTime': closeDineTime,
                                    'specialDiscount': specialDiscount,
                                    'workingHours': workingHours,
                                }).then(function (result) {
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
                                            database.collection('story').doc(id).set({
                                                'createdAt': new Date(),
                                                'sectionID': section_id,
                                                'vendorID': id,
                                                'videoThumbnail': IMG.storyThumbnailImage,
                                                'videoUrl': story_vedios,
                                            })
                                                .then(function (result) {
                                                    jQuery("#data-table_processing").hide();
                                                    if (deliveryChargeFlag) {

                                                        geoFirestore.collection('vendors').doc(id).update({
                                                            'deliveryCharge': deliveryCharge
                                                        }).then(function (result) {

                                                            window.location.href = '{{ route("vendors")}}';
                                                        });
                                                    } else {

                                                        window.location.href = '{{ route("vendors")}}';
                                                    }

                                                });
                                        }

                                    } else {
                                        jQuery("#data-table_processing").hide();
                                        if (deliveryChargeFlag) {

                                            geoFirestore.collection('vendors').doc(id).update({
                                                'deliveryCharge': deliveryCharge
                                            }).then(function (result) {

                                                window.location.href = '{{ route("vendors")}}';
                                            });
                                        } else {

                                            window.location.href = '{{ route("vendors")}}';
                                        }
                                    }



                                });
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

        })

    })


    function replaceText(i, j, type) {

        $('.' + type + '_' + i + '_' + j).text("Save");
    }

    $(document).on("click", ".remove-btn", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        $("#photo_" + id).remove();
        var status = $(this).attr('data-status');
        if (status == "old") {
            galleryImageToDelete.push(firebase.storage().refFromURL(photo_remove));
        }
        index = vendor_photos.indexOf(photo_remove);
        if (index > -1) {
            vendor_photos.splice(index, 1);
        }
        index = new_added_vendor_photos.indexOf(photo_remove);
        if (index > -1) {
            new_added_vendor_photos.splice(index, 1); // 2nd parameter means remove one item only
            new_added_vendor_photos_filename.splice(index, 1);
        }

    });

    $(document).on("click", ".remove-menu-btn", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        var status = $(this).attr('data-status');
        if (status == "old") {
            menuImageToDelete.push(firebase.storage().refFromURL(photo_remove));
        }
        $("#photo_menu_" + id).remove();
        index = vendor_menu_photos.indexOf(photo_remove);
        if (index > -1) {
            vendor_menu_photos.splice(index, 1); // 2nd parameter means remove one item only
        }
        index = new_added_vendor_menu.indexOf(photo_remove);
        if (index > -1) {
            new_added_vendor_menu.splice(index, 1); // 2nd parameter means remove one item only
            new_added_vendor_menu_filename.splice(index, 1);
        }

    });


    function handleStoryFileSelect(evt) {

        var rests = ["0CwIcsoYhSxYba9DlwuE", "NjYpnm5IhQi0GeeVKXiX", "NjYpnm5IhQi0GeeVKXiX", "XrDAfl3rOWZS11lEIPkI", "a4rYm0HQHskPDGXAlWEt", "wkSUMpzIxl6KmDIKuDVQ"];
        if (jQuery.inArray(id, rests) != -1) {
            alert(doNotUpdateAlert);
            return false;
        }

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
            var videoDurationTime = Math.trunc(video.duration)

            if (videoDurationTime > storevideoDuration) {
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

        var rests = ["0CwIcsoYhSxYba9DlwuE", "NjYpnm5IhQi0GeeVKXiX", "NjYpnm5IhQi0GeeVKXiX", "XrDAfl3rOWZS11lEIPkI", "a4rYm0HQHskPDGXAlWEt", "wkSUMpzIxl6KmDIKuDVQ"];
        if (jQuery.inArray(id, rests) != -1) {
            alert(doNotUpdateAlert);
            return false;
        }

        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        firebase.storage().refFromURL(photo_remove).delete();
        $("#story_div_" + id).remove();
        index = story_vedios.indexOf(photo_remove);
        $("#video_file").val('');
        if (index > -1) {
            story_vedios.splice(index, 1); // 2nd parameter means remove one item only
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

        var rests = ["0CwIcsoYhSxYba9DlwuE", "NjYpnm5IhQi0GeeVKXiX", "NjYpnm5IhQi0GeeVKXiX", "XrDAfl3rOWZS11lEIPkI", "a4rYm0HQHskPDGXAlWEt", "wkSUMpzIxl6KmDIKuDVQ"];
        if (jQuery.inArray(id, rests) != -1) {
            alert(doNotUpdateAlert);
            return false;
        }

        var photo_remove = $(this).attr('data-img');
        $("#story_thumbnail").empty();
        story_thumbnail = '';
        deleteStoryfromCollection();
    });

    function deleteStoryfromCollection() {
        if (story_vedios.length == 0 && story_thumbnail == '') {
            database.collection('story').where('vendorID', '==', id).get().then(async function (snapshot) {
                if (snapshot.docs.length > 0) {
                    database.collection('story').doc(id).delete();
                }
            });
        }
    }

    function handleStoryThumbnailFileSelect(evt) {

        var rests = ["0CwIcsoYhSxYba9DlwuE", "NjYpnm5IhQi0GeeVKXiX", "NjYpnm5IhQi0GeeVKXiX", "XrDAfl3rOWZS11lEIPkI", "a4rYm0HQHskPDGXAlWEt", "wkSUMpzIxl6KmDIKuDVQ"];
        if (jQuery.inArray(id, rests) != -1) {
            alert(doNotUpdateAlert);
            return false;
        }

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
                if (story_thumbnail) {
                    photo = story_thumbnail;
                } else {
                    photo = placeholderImage;
                }
                var html = '<div class="col-md-3"><div class="thumbnail-inner"><span class="remove-story-thumbnail" data-img="' + story_thumbnail + '"><i class="fa fa-remove"></i></span><img id="story_thumbnail_image" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="150px" height="150px;"></div></div>';
                jQuery("#story_thumbnail").html(html);


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
                        if (photo) {
                            photo = photo;
                        } else {
                            photo = placeholderImage;
                        }
                        photos_html = '<span class="image-item" id="photo_' + photocount + '"><span class="remove-btn" data-id="' + photocount + '" data-img="' + photo + '" data-status="new"><i class="fa fa-remove"></i></span><img width="100px" id="" height="auto" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>';
                        $("#photos").append(photos_html);
                        new_added_vendor_photos.push(photo);
                        new_added_vendor_photos_filename.push(filename);
                    }
                }

            };
        })(f);
        reader.readAsDataURL(f);
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
                ownerPhoto = filePayload;
                ownerFileName = filename;
                if(ownerPhoto){
                    photo=ownerPhoto;
                }else{
                    photo=placeholderImage;
                }
                $(".uploaded_image_owner").html('<img id="uploaded_image_owner" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="150px" height="150px;">');
                $(".uploaded_image_owner").show();
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
                    if (photo) {
                        photo = photo;
                    } else {
                        photo = placeholderImage;
                    }
                    photos_html = '<span class="image-item" id="photo_menu_' + menuPhotoCount + '"><span class="remove-menu-btn" data-id="' + menuPhotoCount + '" data-img="' + photo + '" data-status="new"><i class="fa fa-remove"></i></span><img width="100px" id="" height="auto" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>';
                    $("#photos_menu_card").append(photos_html);
                    new_added_vendor_menu.push(photo);
                    new_added_vendor_menu_filename.push(filename);
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
            $(".delivery_charges_div").hide();
            $(".ecommerce_div").addClass('d-none');
        } else {
            $(".ecommerce_div").removeClass('d-none');
            $(".delivery_charges_div").show();
        }
        if (serice_type == "delivery-service" && story_isEnabled == true) {
            $('#story_upload_div').show();
        } else {
            $('#story_upload_div').hide();
        }

        $("#is_dine_in_feature").hide();
        $("#services_feature").hide();
        dine_in_active = false;
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

    function updateMoreFunctionButton(day, rowCount, dayCount) {
        var discount = $("#discount" + day + rowCount + dayCount + "").val();
        var discount_type = $('#discount_type' + day + rowCount + dayCount + "").val();
        var type = $('#type' + day + rowCount + dayCount + "").val();
        var closeTime = $("#closeTime" + day + rowCount + dayCount + "").val();
        var openTime = $("#openTime" + day + rowCount + dayCount + "").val();
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
            
            if (day == 'Sunday') {
                timeslotSunday[rowCount] = timeslotVar;
            } else if (day == 'Monday') {
                timeslotMonday[rowCount] = timeslotVar;
            } else if (day == 'Tuesday') {
                timeslotTuesday[rowCount] = timeslotVar;
            } else if (day == 'Wednesday') {
                timeslotWednesday[rowCount] = timeslotVar;
            } else if (day == 'Thursday') {
                timeslotThursday[rowCount] = timeslotVar;
            } else if (day == 'Friday') {
                timeslotFriday[rowCount] = timeslotVar;
            } else if (day == 'Saturday') {
                timeslotSaturday[rowCount] = timeslotVar;
            }
        }

    }


    $(".add_working_hours_restaurant_btn").click(function () {
        $(".working_hours_div").show();
    })
    var countAddhours = 1;

    function addMorehour(day, day2, count) {
        count = countAddhours;
        $(".restaurant_discount_options_" + day + "_div").show();

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

        } else {

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

    function deleteWorkingHour(day, count, i) {
        $('.' + i + '_' + count + '_row').hide();
        if (day == 'Sunday') {
            timeslotworkSunday.splice(count, 1);
        } else if (day == 'Monday') {
            timeslotworkMonday.splice(count, 1);
        } else if (day == 'Tuesday') {
            timeslotworkTuesday.splice(count, 1);
        } else if (day == 'Wednesday') {
            timeslotworkWednesday.splice(count, 1);
        } else if (day == 'Thursday') {
            timeslotworkThursday.splice(count, 1);
        } else if (day == 'Friday') {
            timeslotworkFriday.splice(count, 1);
        } else if (day == 'Saturday') {
            timeslotworkSaturday.splice(count, 1);
        }

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


        database.collection('vendors').doc(id).update({ 'workingHours': workingHours }).then(function (result) {

        });   
    }

    function updatehoursFunctionButton(day, rowCount, dayCount) {
        var to = $("#to" + day + rowCount + dayCount + "").val();
        var from = $("#from" + day + rowCount + dayCount + "").val();
        if (to == '' && from == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>Please Enter valid time </p>");
            window.scrollTo(0, 0);

        } 
        else if(from>to){
             $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>To time can not be less than From time</p>");
            window.scrollTo(0, 0);
            
        }else {

            var timeslotworkVar = { 'from': from, 'to': to };
            if (day == 'Sunday') {
                timeslotworkSunday[rowCount] = timeslotworkVar;
            } else if (day == 'Monday') {
                timeslotworkMonday[rowCount] = timeslotworkVar;
            } else if (day == 'Tuesday') {
                timeslotworkTuesday[rowCount] = timeslotworkVar;
            } else if (day == 'Wednesday') {
                timeslotworkWednesday[rowCount] = timeslotworkVar;
            } else if (day == 'Thursday') {
                timeslotworkThursday[rowCount] = timeslotworkVar;
            } else if (day == 'Friday') {
                timeslotworkFriday[rowCount] = timeslotworkVar;
            } else if (day == 'Saturday') {
                timeslotworkSaturday[rowCount] = timeslotworkVar;
            }
        }

    }

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
        newPhoto['ownerImage'] = ownerPhoto;
        newPhoto['vendorImage'] = vendorPhoto;
        newPhoto['storyThumbnailImage'] = story_thumbnail;
        try {
            if (ownerPhoto != '') {
                if (ownerOldImageFile != "" && ownerPhoto != ownerOldImageFile) {
                    var ownerOldImageUrlRef = await storage.refFromURL(ownerOldImageFile);
                    imageBucket = ownerOldImageUrlRef.bucket;
                    var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";

                    if (imageBucket == envBucket) {
                        await ownerOldImageUrlRef.delete().then(() => {
                            console.log("Old file deleted!")
                        }).catch((error) => {
                            console.log("ERR File delete ===", error);
                        });
                    } else {
                        console.log('Bucket not matched');
                    }
                }

                if (ownerPhoto != ownerOldImageFile) {

                    ownerPhoto = ownerPhoto.replace(/^data:image\/[a-z]+;base64,/, "")
                    var uploadTask = await storageRef.child(ownerFileName).putString(ownerPhoto, 'base64', { contentType: 'image/jpg' });
                    var downloadURL = await uploadTask.ref.getDownloadURL();
                    newPhoto['ownerImage'] = downloadURL;
                    ownerPhoto = downloadURL;
                }
            }
            if (vendorPhoto != '') {
                if (vendorPhotoOldImageFile != "" && vendorPhoto != vendorPhotoOldImageFile) {

                    var vendorOldImageUrlRef = await storage.refFromURL(vendorPhotoOldImageFile);
                    imageBucket = vendorOldImageUrlRef.bucket;
                    var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";

                    if (imageBucket == envBucket) {
                        await vendorOldImageUrlRef.delete().then(() => {
                            console.log("Old file deleted!")
                        }).catch((error) => {
                            console.log("ERR File delete ===", error);
                        });
                    } else {
                        console.log('Bucket not matched');
                    }

                }
                if (vendorPhoto != vendorPhotoOldImageFile) {

                    vendorPhoto = vendorPhoto.replace(/^data:image\/[a-z]+;base64,/, "")
                    var uploadTask = await storageRef.child(vendorPhotoFileName).putString(vendorPhoto, 'base64', { contentType: 'image/jpg' });
                    var downloadURL = await uploadTask.ref.getDownloadURL();
                    newPhoto['vendorImage'] = downloadURL;
                }
            }
            if (story_thumbnail != '') {
                if (story_thumbnail_oldfile != "" && story_thumbnail != story_thumbnail_oldfile) {

                    var thumbnailOldImageUrlRef = await storage.refFromURL(story_thumbnail_oldfile);
                    imageBucket = thumbnailOldImageUrlRef.bucket;
                    var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";

                    if (imageBucket == envBucket) {
                        await thumbnailOldImageUrlRef.delete().then(() => {
                            console.log("Old file deleted!")
                        }).catch((error) => {
                            console.log("ERR File delete ===", error);
                        });
                    } else {
                        console.log('Bucket not matched');
                    }

                }
                if (story_thumbnail != story_thumbnail_oldfile) {

                    story_thumbnail = story_thumbnail.replace(/^data:image\/[a-z]+;base64,/, "")
                    var uploadTask = await storageRef.child(story_thumbnail_filename).putString(story_thumbnail, 'base64', { contentType: 'image/jpg' });
                    var downloadURL = await uploadTask.ref.getDownloadURL();
                    newPhoto['storyThumbnailImage'] = downloadURL;
                }
            }
        } catch (error) {
            console.log("ERR ===", error);
        }

        return newPhoto;
    }
    async function storeGalleryImageData() {
        var newPhoto = [];
        if (vendor_photos.length > 0) {
            newPhoto = vendor_photos;
        }
        if (new_added_vendor_photos.length > 0) {
            await Promise.all(new_added_vendor_photos.map(async (resPhoto, index) => {

                resPhoto = resPhoto.replace(/^data:image\/[a-z]+;base64,/, "");
                var uploadTask = await storageRef.child(new_added_vendor_photos_filename[index]).putString(resPhoto, 'base64', { contentType: 'image/jpg' });
                var downloadURL = await uploadTask.ref.getDownloadURL();
                newPhoto.push(downloadURL);
            }));
        }
        if (galleryImageToDelete.length > 0) {
            await Promise.all(galleryImageToDelete.map(async (delImage) => {
               
                imageBucket = delImage.bucket;
                var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";
                if (imageBucket == envBucket) {
                    await delImage.delete().then(() => {
                        console.log("Old file deleted!")
                    }).catch((error) => {
                        console.log("ERR File delete ===", error);
                    });
                } else {
                    console.log('Bucket not matched');
                }

            }));

        }
        return newPhoto;
    }
    async function storeMenuImageData() {
        var newPhoto = [];
        if (vendor_menu_photos.length > 0) {
            newPhoto = vendor_menu_photos;
        }
        if (new_added_vendor_menu.length > 0) {
            await Promise.all(new_added_vendor_menu.map(async (menuPhoto, index) => {
                menuPhoto = menuPhoto.replace(/^data:image\/[a-z]+;base64,/, "");
                var uploadTask = await storageRef.child(new_added_vendor_menu_filename[index]).putString(menuPhoto, 'base64', { contentType: 'image/jpg' });
                var downloadURL = await uploadTask.ref.getDownloadURL();
                newPhoto.push(downloadURL);
            }));
        }
        if (menuImageToDelete.length > 0) {
            await Promise.all(menuImageToDelete.map(async (delImage) => {
                
                imageBucket = delImage.bucket;
                var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";

                if (imageBucket == envBucket) {
                    await delImage.delete().then(() => {
                        console.log("Old file deleted!")
                    }).catch((error) => {
                        console.log("ERR File delete ===", error);
                    });
                } else {
                    console.log('Bucket not matched');
                }

            }));

        }

        return newPhoto;
    }

</script>
@endsection