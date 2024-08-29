@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.wallet_transaction_plural')}} <span class="userTitle"></span>
            </h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.wallet_transaction_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
            {{trans('lang.processing')}}
        </div>
        <div class="row">

            <div class="col-12">
                <?php if ($id != '') { ?>
                    <div class="menu-tab" id="user_view">
                        <ul>
                            <li><a href="{{route('users.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li><a href="{{route('orders','userId='.$id)}}">{{trans('lang.tab_orders')}}</a></li>
                            <li class="active">
                                <a href="#">{{trans('lang.wallet_transaction')}}</a>
                            </li>

                        </ul>
                    </div>

                    <div class="menu-tab d-none" id="store_view">
                        <ul>
                            <li>
                                <a href="#" class="vendor_basic">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="#" class="vendor_item">{{trans('lang.tab_items')}}</a>
                            </li>
                            <li>
                                <a href="#" class="vendor_order">{{trans('lang.tab_orders')}}</a>
                            </li>
                            <li>
                                <a href="#" class="vendor_review">{{trans('lang.tab_reviews')}}</a>
                            </li>
                            <li>
                                <a href="#" class="vendor_promo">{{trans('lang.tab_promos')}}</a>
                            <li>
                                <a href="#" class="vendor_payout">{{trans('lang.tab_payouts')}}</a>
                            </li>

                            <li class="dine_in_future" style="display:none;">
                                <a href="#" class="vendor_booktable">{{trans('lang.dine_in_future')}}</a>
                            </li>
                            <?php if (in_array('wallet-transaction', json_decode(@session('user_permissions')))) { ?>

                                <li class="active">
                                    <a href="#"
                                       class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                </li>

                            <?php } ?>

                        </ul>

                    </div>

                    <div class="menu-tab d-none" id="driver_view">
                        <ul>
                            <li>
                                <a href="#" class="basic">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="#" class="vehicle">{{trans('lang.vehicle')}}</a>
                            </li>
                            <li class="service_type_orders">

                            </li>
                            <li>
                                <a href="#" class="payout">{{trans('lang.tab_payouts')}}</a>
                            </li>

                            <?php if (in_array('wallet-transaction', json_decode(@session('user_permissions')))) { ?>

                                <li class="active">
                                    <a href="#"
                                       class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                </li>

                            <?php } ?>
                        </ul>

                    </div>

                    <div class="menu-tab d-none" id="provider_view">
                        <ul>
                            <li><a href="#" class="provider_basic">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li><a href="#" class="provider_services">{{trans('lang.services')}}</a></li>
                            <li>
                            <li><a href="#" class="provider_workers">{{trans('lang.workers')}}</a></li>
                            <li>
                            <li><a href="#" class="provider_bookings">{{trans('lang.booking_plural')}}</a></li>
                            <li>
                            <li><a href="#" class="provider_coupons">{{trans('lang.coupon_plural')}}</a></li>
                            <li>
                                <a href="#" class="provider_payout">{{trans('lang.tab_payouts')}}</a>
                            </li>

                            <li class="active">
                                <a href="#">{{trans('lang.wallet_transaction')}}</a>
                            </li>
                        </ul>
                    </div>

                <?php } ?>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.wallet_transaction_table')}}
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive m-t-10">

                            <table id="walletTransactionTable"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>
                                    <?php if ($id == '') { ?>
                                        <th>{{ trans('lang.users')}}</th>
                                        <th>{{ trans('lang.role')}}</th>
                                    <?php } ?>
                                    <th>{{trans('lang.amount')}}</th>
                                    <th>{{trans('lang.date')}}</th>
                                    <th>{{trans('lang.note')}}</th>
                                    <th>{{trans('lang.payment_method')}}</th>
                                    <th>{{trans('lang.payment_status')}}</th>
                                </tr>

                                </thead>

                                <tbody id="append_list1">


                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    var database = firebase.firestore();
    var id = '<?php echo $id; ?>';
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];

    var refData = database.collection('wallet');
    var search = jQuery("#search").val();
    var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })
    $(document.body).on('keyup', '#search', function () {
        search = jQuery(this).val();
    });

    var id = '{{$id}}';

    var storeID = (window.location.href.indexOf("storeID=") > -1) ? window.location.href.split("storeID=")[1] : "";
    var driverID = (window.location.href.indexOf("driverID=") > -1) ? window.location.href.split("driverID=")[1] : "";
    var providerID = (window.location.href.indexOf("providerID=") > -1) ? window.location.href.split("providerID=")[1] : "";

    var wallet_route = "{{route('users.walletstransaction','id')}}";

    if (storeID) {
        id = storeID;
        $('#user_view').addClass('d-none');
        $('#store_view').removeClass('d-none');



    } else if (driverID) {
        id = driverID;
        $('#user_view').addClass('d-none');
        $('#driver_view').removeClass('d-none');

        var basic = "{{route('drivers.view','id')}}";
        var vehicle = "{{route('drivers.vehicle','id')}}";
        var payouts = "{{route('driver.payouts','id')}}";

        $(".basic").attr("href", basic.replace('id', driverID));
        $(".vehicle").attr("href", vehicle.replace('id', driverID));
        $(".payout").attr("href", payouts.replace('id', driverID));

    } else if (providerID) {
        id = providerID;

        $('#user_view').addClass('d-none');
        $('#provider_view').removeClass('d-none');

        var provider_basic = "{{url('providers/view/{id}')}}";
        var provider_services = "{{url('ondemand-services/{id?}')}}";
        var provider_workers = "{{url('ondemand-workers/{id?}')}}";
        var provider_bookings = "{{url('ondemand-bookings/{id?}')}}";
        var provider_coupons = "{{url('ondemand-coupons/{id?}')}}";
        var provider_payout = "{{url('providerPayouts/{id}')}}";

        $(".provider_basic").attr("href", provider_basic.replace('{id}', providerID));
        $(".provider_services").attr("href", provider_services.replace('{id?}', providerID));
        $(".provider_workers").attr("href", provider_workers.replace('{id?}', providerID));
        $(".provider_bookings").attr("href", provider_bookings.replace('{id?}', providerID));
        $(".provider_coupons").attr("href", provider_coupons.replace('{id?}', providerID));
        $(".provider_payout").attr("href", provider_payout.replace('{id}', providerID));
    }

    if (id) {

        ref = refData.where('user_id', '==', id).orderBy('date', 'desc');
        $(".wallet_transaction").attr("href", wallet_route.replace('id', id));

    } else {

        ref = refData.orderBy('date', 'desc');

    }

    var append_list = '';

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
    });

    $(document).ready(function () {

        if (id) {
            var username = database.collection('users').where('id', '==', id);
            username.get().then(async function (snapshots) {
                var driver = snapshots.docs[0].data();
                $(".userTitle").text(' of ' + driver.firstName + " " + driver.lastName);

                if(driver.role == "vendor"){
                    var vendor_basic = "{{route('vendors.view','id')}}";
                    var vendor_item = "{{route('vendors.items','id')}}";
                    var vendor_order = "{{route('vendors.orders','id')}}";
                    var vendor_review = "{{route('vendors.reviews','id')}}";
                    var vendor_promo = "{{route('vendors.coupons','id')}}";
                    var vendor_payout = "{{route('vendors.payout','id')}}";
                    var vendor_booktable = "{{route('vendors.booktable','id')}}";

                    $(".vendor_basic").attr("href", vendor_basic.replace('id', driver.vendorID));
                    $(".vendor_item").attr("href", vendor_item.replace('id', driver.vendorID));
                    $(".vendor_order").attr("href", vendor_order.replace('id', driver.vendorID));
                    $(".vendor_review").attr("href", vendor_review.replace('id', driver.vendorID));
                    $(".vendor_promo").attr("href", vendor_promo.replace('id', driver.vendorID));
                    $(".vendor_payout").attr("href", vendor_payout.replace('id', driver.vendorID));
                    $(".vendor_booktable").attr("href", vendor_booktable.replace('id', driver.vendorID));
                }
                if (driver.serviceType == "cab-service") {

                    var url = "{{route('drivers.rides','driverId')}}";
                    url = url.replace('driverId', driver.id);
                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                } else if (driver.serviceType == "rental-service") {
                    var url = "{{route('rental_orders.driver','id')}}";
                    url = url.replace("id", driver.id);
                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                } else if (driver.serviceType == "delivery-service" || driver.serviceType == "ecommerce-service") {
                    var url = "{{route('orders','id')}}";
                    url = url.replace("id", 'driverId=' + driver.id);
                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                } else if (driver.serviceType == "parcel_delivery") {
                    var url = "{{route('parcel_orders.driver','id')}}";
                    url = url.replace("id", driver.id);
                    $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                }
            });
        }

        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });

        var inx = parseInt(offest) * parseInt(pagesize);
        jQuery("#data-table_processing").show();
        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            html = '';
            if (snapshots.docs.length > 0) {
                html = await buildHTML(snapshots);
            }

            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);
                if (snapshots.docs.length < pagesize) {
                    jQuery("#data-table_paginate").hide();
                }
            }

            if (id == '') {
                $('#walletTransactionTable').DataTable({
                    order: [],
                    columnDefs: [{
                        targets: 3,
                        type: 'date',
                        render: function (data) {

                            return data;
                        }
                    },
                        {
                            orderable: false,
                            targets: [4, 5]
                        },
                    ],
                    order: [3, "desc"],
                    "language": {
                        "zeroRecords": "{{trans('lang.no_record_found')}}",
                        "emptyTable": "{{trans('lang.no_record_found')}}"

                    },
                    responsive: true
                });
            } else {
                $('#walletTransactionTable').DataTable({
                    order: [],
                    columnDefs: [{
                        targets: 1,
                        type: 'date',
                        render: function (data) {

                            return data;
                        }
                    },
                        {
                            orderable: false,
                            targets: [2, 3]
                        },
                    ],
                    order: [1, "desc"],
                    "language": {
                        "zeroRecords": "{{trans('lang.no_record_found')}}",
                        "emptyTable": "{{trans('lang.no_record_found')}}"

                    },
                    responsive: true
                });
            }

            jQuery("#data-table_processing").hide();
        });

    });

    async function buildHTML(snapshots) {
        var html = '';

        await Promise.all(snapshots.docs.map(async (listval) => {

            var val = listval.data();

            var getData = await getWalletTransactionListData(val);
            html += getData;
        }));

        return html;
    }


    async function getWalletTransactionListData(val) {
        var html = '';

        html = html + '<tr>';

        if (id == "") {
            if (val.user_id) {
                var payoutuser = await payoutuserfunction(val.user_id);

                if (payoutuser != '') {

                    var user_role = payoutuser.role;
                    var user_name = '';

                    if (payoutuser.hasOwnProperty('firstName')) {
                        user_name = payoutuser.firstName;
                    }

                    if (payoutuser.hasOwnProperty('lastName')) {
                        user_name = user_name + ' ' + payoutuser.lastName;
                    }

                    var routeuser = "Javascript:void(0)";
                    if (user_role == "customer") {
                        routeuser = '{{route("users.view",":id")}}';
                        routeuser = routeuser.replace(':id', val.user_id);
                    } else if (user_role == "driver") {
                        routeuser = '{{route("drivers.view",":id")}}';
                        routeuser = routeuser.replace(':id', val.user_id);
                    } else if (user_role == "vendor") {

                        if (payoutuser.vendorID != '') {
                            routeuser = '{{route("vendors.view",":id")}}';
                            routeuser = routeuser.replace(':id', payoutuser.vendorID);
                        }

                    }
                    html = html + '<td class="user_' + val.user_id + '"><a href="' + routeuser + '">' + user_name + '</a></td>';
                    html = html + '<td class="user_role_' + val.user_id + '" >' + user_role + '</td>';
                } else {
                    html = html + '<td></td><td></td>';

                }

            } else {
                html = html + '<td></td><td></td>';
            }
        }
        amount = val.amount;
        if (!isNaN(amount)) {
            amount = parseFloat(amount).toFixed(decimal_degits);

        }

        if ((val.hasOwnProperty('isTopUp') && val.isTopUp) || (val.payment_method == "Cancelled Order Payment")) {

            if (currencyAtRight) {

                html = html + '<td class="text-green">' + parseFloat(amount).toFixed(decimal_degits) + '' + currentCurrency + '</td>';


            } else {
                html = html + '<td class="text-green">' + currentCurrency + '' + parseFloat(amount).toFixed(decimal_degits) + '</td>';
            }

        } else if (val.hasOwnProperty('isTopUp') && !val.isTopUp) {

            if (currencyAtRight) {
                html = html + '<td class="text-red">(-' + parseFloat(amount).toFixed(decimal_degits) + '' + currentCurrency + ')</td>';

            } else {
                html = html + '<td class="text-red">(-' + currentCurrency + '' + parseFloat(amount).toFixed(decimal_degits) + ')</td>';
            }

        } else {
            if (currencyAtRight) {
                html = html + '<td class="">' + parseFloat(amount).toFixed(decimal_degits) + '' + currentCurrency + '</td>';

            } else {
                html = html + '<td class="">' + currentCurrency + '' + parseFloat(amount).toFixed(decimal_degits) + '</td>';
            }
        }


        var date = "";
        var time = "";
        try {
            if (val.hasOwnProperty("date")) {
                date = val.date.toDate().toDateString();
                time = val.date.toDate().toLocaleTimeString('en-US');
            }
        } catch (err) {

        }


        html = html + '<td>' + date + ' ' + time + '</td>';
        if (val.note != undefined && val.note != '') {
            html = html + '<td>' + val.note + '</td>';
        } else {
            html = html + '<td></td>';
        }

        var payment_method = '';
        if (val.payment_method) {


            if (val.payment_method == "Stripe") {
                image = '{{asset("images/payment/stripe.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" >';

            } else if (val.payment_method == "RazorPay") {
                image = '{{asset("images/payment/razorepay.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" >';

            } else if (val.payment_method == "Paypal") {
                image = '{{asset("images/payment/paypal.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';

            } else if (val.payment_method == "payFast") {
                image = '{{asset("images/payment/payfast.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';

            } else if (val.payment_method == "PayFast") {
                image = '{{asset("images/payment/payfast.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" >';

            } else if (val.payment_method == "PayStack") {
                image = '{{asset("images/payment/paystack.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" >';

            } else if (val.payment_method == "FlutterWave") {
                image = '{{asset("images/payment/flutter_wave.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" >';

            } else if (val.payment_method == "Mercado Pago") {
                image = '{{asset("images/payment/marcado_pago.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';

            } else if (val.payment_method == "Wallet") {
                image = '{{asset("images/payment/emart_wallet.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';

            } else if (val.payment_method == "Paytm") {
                image = '{{asset("images/payment/paytm.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';

            } else if (val.payment_method == "Cancelled Order Payment") {
                image = '{{asset("images/payment/cancel_order.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';

            } else if (val.payment_method == "Refund Amount") {
                image = '{{asset("images/payment/refund_amount.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
            } else if (val.payment_method == "Referral Amount") {
                image = '{{asset("images/payment/reffral_amount.png")}}';
                payment_method = '<img alt="image" src="' + image + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
            } else {
                payment_method = val.payment_method;
            }
        }


        html = html + '<td class="payment_images">' + payment_method + '</td>';

        if (val.payment_status == 'success') {
            html = html + '<td class="success"><span>' + val.payment_status + '</span></td>';
        } else if (val.payment_status == 'undefined') {
            html = html + '<td class="undefined"><span>' + val.payment_status + '</span></td>';
        } else if (val.payment_status == 'Refund success') {
            html = html + '<td class="refund_success"><span>' + val.payment_status + '</span></td>';

        } else {
            html = html + '<td class="refund_success"><span>' + val.payment_status + '</span></td>';

        }

        html = html + '</tr>';
        return html;
    }

 
    async function payoutuserfunction(user) {
        var payoutuser = '';

        await database.collection('users').where("id", "==", user).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                payoutuser = snapshotss.docs[0].data();
            }
        });
        return payoutuser;
    }
</script>


@endsection