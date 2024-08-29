@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.driver_plural')}} <span class="itemTitle"></span></h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('drivers') !!}">{{trans('lang.driver_plural')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{trans('lang.driver_details')}}</li>
                </ol>
            </div>

        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="resttab-sec">
                        <div id="data-table_processing" class="dataTables_processing panel panel-default"
                             style="display: none;">{{trans('lang.processing')}}
                        </div>
                        <div class="menu-tab">
                            <ul>
                                <li class="active">
                                    <a href="{{route('drivers.view',$id)}}" class="basic">{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('drivers.vehicle',$id)}}" class="vehicle">{{trans('lang.vehicle')}}</a>
                                </li>
                                <li class="service_type_orders">

                                </li>
                                <li>
                                    <a href="{{route('driver.payouts',$id)}}" class="payout">{{trans('lang.tab_payouts')}}</a>
                                </li>

                                <li>
                                        <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                </li>

                                
                            </ul>

                        </div>

                    </div>

                    <div class="row vendor_payout_create">
                        <div class="vendor_payout_create-inner driver_detail_div">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#addWalletModal"
                               class="add-wallate btn btn-success"><i class="fa fa-plus"></i>
                                {{trans('lang.add_wallet_amount')}}</a>
                            <fieldset>
                                <legend>{{trans('lang.driver_details')}}</legend>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.first_name')}}</label>
                                    <div class="col-7" class="driver_name">
                                        <span class="driver_name" id="driver_name"></span>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.email')}}</label>
                                    <div class="col-7">
                                        <span class="email"></span>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.user_phone')}}</label>
                                    <div class="col-7">
                                        <span class="phone"></span>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.service_type')}}</label>
                                    <div class="col-7">
                                        <span class="service_type">-</span>
                                    </div>
                                </div>
                                <div class="form-group row width-100">
                                    <label class="col-3 control-label">{{trans('lang.wallet_Balance')}}</label>
                                    <div class="col-7">
                                        <span class="wallet_balance"></span>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.profile_image')}}</label>
                                    <div class="col-7 profile_image">
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.vehicle_profile_image')}}</label>
                                    <div class="col-7 vehicle_profile_image">
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.driver_proof_image')}}</label>
                                    <div class="col-7 driver_proof_image">
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.vehicle_proof_image')}}</label>
                                    <div class="col-7 vehicle_proof_image">
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend>{{trans('lang.bankdetails')}}</legend>
                                <div class="bank-details">
                                    <div class="form-group row width-50">
                                        <label class="col-4 control-label">{{trans('lang.bank_name')}}</label>
                                        <div class="col-7">
                                            <span class="bank_name"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-4 control-label">{{trans('lang.branch_name')}}</label>
                                        <div class="col-7">
                                            <span class="branch_name"></span>
                                        </div>
                                    </div>


                                    <div class="form-group row width-50">
                                        <label class="col-4 control-label">{{trans('lang.holer_name')}}</label>
                                        <div class="col-7">
                                            <span class="holer_name"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-4 control-label">{{trans('lang.account_number')}}</label>
                                        <div class="col-7">
                                            <span class="account_number"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-4 control-label">{{trans('lang.other_information')}}</label>
                                        <div class="col-7">
                                            <span class="other_information"></span>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group col-12 text-center btm-btn">
                        <a href="{!! route('drivers') !!}" class="btn btn-default"><i
                                    class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addWalletModal" tabindex="-1" role="dialog"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered location_modal">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title locationModalTitle">{{trans('lang.add_wallet_amount')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <form class="">

                        <div class="form-row">

                            <div class="form-group row">

                                <div class="form-group row width-100">
                                    <label class="col-12 control-label">{{
                                    trans('lang.amount')}}</label>
                                    <div class="col-12">
                                        <input type="number" name="amount" class="form-control" id="amount">
                                        <div id="wallet_error" style="color:red"></div>
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <label class="col-12 control-label">{{
                                    trans('lang.note')}}</label>
                                    <div class="col-12">
                                        <input type="text" name="note" class="form-control" id="note">
                                    </div>
                                </div>

                                <div class="form-group row width-100">

                                    <div id="user_account_not_found_error" class="align-items-center"
                                         style="color:red"></div>
                                </div>

                            </div>

                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add-wallet-btn">{{trans('submit')}}
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                            {{trans('close')}}
                        </button>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        var id = "{{$id}}";
        var database = firebase.firestore();
        var ref = database.collection('users').where("id", "==", id);
        var photo = "";
        var vendorOwnerId = "";
        var vendorOwnerOnline = false;

        var placeholderImage = '';
        var placeholder = database.collection('settings').doc('placeHolderImage');

        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        });

        var currency = database.collection('settings');

        var currentCurrency = '';
        var currencyAtRight = false;
        var decimal_degits = 0;

        var refCurrency = database.collection('currencies').where('isActive', '==', true);
        refCurrency.get().then(async function (snapshots) {
            var currencyData = snapshots.docs[0].data();
            currentCurrency = currencyData.symbol;
            currencyAtRight = currencyData.symbolAtRight;

            if (currencyData.decimal_degits) {
                decimal_degits = currencyData.decimal_degits;
            }
            $(".currentCurrency").text(currencyData.symbol);
        });

        var email_templates = database.collection('email_templates').where('type', '==', 'wallet_topup');

        var emailTemplatesData = null;

        $(document).ready(async function () {

            jQuery("#data-table_processing").show();

            await email_templates.get().then(async function (snapshots) {
                emailTemplatesData = snapshots.docs[0].data();
            });

            ref.get().then(async function (snapshots) {
                if(snapshots.docs.length>0){
                var dirver = snapshots.docs[0].data();

                $(".driver_name").text(dirver.firstName);
                $(".email").text(dirver.email);
                $(".phone").text(dirver.phoneNumber);


                    var wallet_route = "{{route('users.walletstransaction','id')}}";

                    $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+dirver.id));


                    if (dirver.serviceType) {
                    $(".service_type").text(dirver.serviceType);

                    if (dirver.serviceType == "cab-service") {

                        var url = "{{route('drivers.rides','driverId')}}";
                        url = url.replace('driverId', dirver.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (dirver.serviceType == "rental-service") {
                        var url = "{{route('rental_orders.driver','id')}}";
                        url = url.replace("id", dirver.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (dirver.serviceType == "delivery-service" || dirver.serviceType == "ecommerce-service") {
                        var url = "{{route('orders','id')}}";
                        url = url.replace("id", 'driverId=' + dirver.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (dirver.serviceType == "parcel_delivery") {
                        var url = "{{route('parcel_orders.driver','id')}}";
                        url = url.replace("id", dirver.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    }
                }


                var wallet_balance = 0;

                if (dirver.hasOwnProperty('wallet_amount') && dirver.wallet_amount != null && !isNaN(dirver.wallet_amount)) {
                    wallet_balance = dirver.wallet_amount;
                }
                if (currencyAtRight) {
                    wallet_balance = parseFloat(wallet_balance).toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    wallet_balance = currentCurrency + "" + parseFloat(wallet_balance).toFixed(decimal_degits);
                }

                $('.wallet_balance').html(wallet_balance);
            
                var image = "";
                if (dirver.profilePictureURL) {
                    if(dirver.profilePictureURL){
                        photo=dirver.profilePictureURL;
                    }else{
                        photo=placeholderImage;
                    }
                    image = '<img width="200px" id="" height="auto" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
                } else {
                    image = '<img width="200px" id="" height="auto" src="' + placeholderImage + '">';
                }
                $(".profile_image").html(image);

                var vehicle_profile_image = "";
                if (dirver.carPictureURL)
                        vehicle_profile_image = '<img width="200px" id="" height="auto" src="' + dirver.carPictureURL + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
                else
                    vehicle_profile_image = '<img width="200px" id="" height="auto" src="' + placeholderImage + '">';

                $(".vehicle_profile_image").html(vehicle_profile_image);

                var driver_proof_image = "";
                if (dirver.driverProofPictureURL)
                    driver_proof_image = '<img width="200px" id="" height="auto" src="' + dirver.driverProofPictureURL + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
                else
                    driver_proof_image = '<img width="200px" id="" height="auto" src="' + placeholderImage + '">';

                $(".driver_proof_image").html(driver_proof_image);

                var vehicle_proof_image = "";
                if (dirver.carProofPictureURL)
                    vehicle_proof_image = '<img width="200px" id="" height="auto" src="' + dirver.carProofPictureURL + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
                else
                    vehicle_proof_image = '<img width="200px" id="" height="auto" src="' + placeholderImage + '">';

                $(".vehicle_proof_image").html(vehicle_proof_image);

                if (dirver.hasOwnProperty('userBankDetails')) {
                    if (dirver.userBankDetails.hasOwnProperty('bankName')) {
                        $(".bank_name").text(dirver.userBankDetails.bankName);

                    }

                    if (dirver.userBankDetails.hasOwnProperty('branchName')) {
                        $(".branch_name").text(dirver.userBankDetails.branchName);

                    }

                    if (dirver.userBankDetails.hasOwnProperty('holderName')) {
                        $(".holer_name").text(dirver.userBankDetails.holderName);

                    }

                    if (dirver.userBankDetails.hasOwnProperty('accountNumber')) {
                        $(".account_number").text(dirver.userBankDetails.accountNumber);

                    }


                    if (dirver.userBankDetails.hasOwnProperty('otherDetails')) {
                        $(".other_information").text(dirver.userBankDetails.otherDetails);

                    }
                } else {

                    $('.bank-details').html('<label class= "col-12 control-label">{{trans("lang.not_found")}}</label>');
                }
            }
            else{
                $('.driver_detail_div').html('<h5 class="font-weight-bold align text-danger text-center">{{trans('lang.driver_unknown_deleted')}}</h5>')
            }
                jQuery("#data-table_processing").hide();

            })

        });

        $("#add-wallet-btn").click(function () {
            var date = firebase.firestore.FieldValue.serverTimestamp();
            var amount = $('#amount').val();
            if (amount == '' || amount <= 0) {
                $('#wallet_error').text('{{trans("lang.add_wallet_amount_error")}}');
                return false;
            }
            var note = $('#note').val();
            database.collection('users').where('id', '==', id).get().then(async function (snapshot) {

                if (snapshot.docs.length > 0) {
                    var data = snapshot.docs[0].data();

                    var walletAmount = 0;

                    if (data.hasOwnProperty('wallet_amount') && !isNaN(data.wallet_amount) && data.wallet_amount != null) {
                        walletAmount = data.wallet_amount;

                    }
                    var user_id = data.id;
                    var newWalletAmount = parseFloat(walletAmount) + parseFloat(amount);

                    database.collection('users').doc(id).update({
                        'wallet_amount': newWalletAmount
                    }).then(function (result) {
                        var tempId = database.collection("tmp").doc().id;
                        database.collection('wallet').doc(tempId).set({
                            'amount': parseFloat(amount),
                            'date': date,
                            'isTopUp': true,
                            'id': tempId,
                            'order_id': '',
                            'payment_method': 'Wallet',
                            'payment_status': 'success',
                            'user_id': user_id,
                            'note': note,
                            'transactionUser': "driver",

                        }).then(async function (result) {
                            if (currencyAtRight) {
                                amount = parseInt(amount).toFixed(decimal_degits) + "" + currentCurrency;
                                newWalletAmount = newWalletAmount.toFixed(decimal_degits) + "" + currentCurrency;
                            } else {
                                amount = currentCurrency + "" + parseInt(amount).toFixed(decimal_degits);
                                newWalletAmount = currentCurrency + "" + newWalletAmount.toFixed(decimal_degits);
                            }

                            var formattedDate = new Date();
                            var month = formattedDate.getMonth() + 1;
                            var day = formattedDate.getDate();
                            var year = formattedDate.getFullYear();

                            month = month < 10 ? '0' + month : month;
                            day = day < 10 ? '0' + day : day;

                            formattedDate = day + '-' + month + '-' + year;

                            var message = emailTemplatesData.message;
                            message = message.replace(/{username}/g, data.firstName + ' ' + data.lastName);
                            message = message.replace(/{date}/g, formattedDate);
                            message = message.replace(/{amount}/g, amount);
                            message = message.replace(/{paymentmethod}/g, 'Wallet');
                            message = message.replace(/{transactionid}/g, tempId);
                            message = message.replace(/{newwalletbalance}/g, newWalletAmount);

                            emailTemplatesData.message = message;

                            var url = "{{url('send-email')}}";
                            if(data.email != '' && data.email != null){
                            var sendEmailStatus = await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [data.email]);

                            if (sendEmailStatus) {
                                window.location.reload();
                            }
                        }else{
                            window.location.reload();
                        }
                        })
                    })
                } else {
                    $('#user_account_not_found_error').text('{{trans("lang.user_detail_not_found")}}');

                }
            });

        });

    </script>

@endsection
