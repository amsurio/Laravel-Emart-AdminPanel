@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.vendors_payout_plural')}} <span class="storeTitle"></span></h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.vendors_payout_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default"
             style="display: none;">{{trans('lang.processing')}}
        </div>
        <div class="row">

            <div class="col-12">
                <?php if ($id != '') { ?>
                    <div class="menu-tab">
                        <ul>
                            <li>
                                <a href="{{route('vendors.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="{{route('vendors.items',$id)}}">{{trans('lang.tab_items')}}</a>
                            </li>
                            <li>
                                <a href="{{route('vendors.orders',$id)}}">{{trans('lang.tab_orders')}}</a>
                            </li>
                            <li>
                                <a href="{{route('vendors.reviews',$id)}}">{{trans('lang.tab_reviews')}}</a>
                            </li>
                            <li>
                                <a href="{{route('vendors.coupons',$id)}}">{{trans('lang.tab_promos')}}</a>
                            <li class="active">
                                <a href="{{route('vendors.payout',$id)}}">{{trans('lang.tab_payouts')}}</a>
                            </li>
                            <li>
                                <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                            </li>
                            <li class="dine_in_future" style="display:none;">
                                <a href="{{route('vendors.booktable',$id)}}">{{trans('lang.dine_in_future')}}</a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.vendors_payout_table')}}</a>
                            </li>

                            <?php if ($id != '') { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('vendorsPayouts.create') !!}/{{$id}}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.vendors_payout_create')}}</a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('vendorsPayouts.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.vendors_payout_create')}}</a>
                                </li>
                            <?php } ?>


                        </ul>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive m-t-10">


                        <table id="example24"
                               class="display nowrap table table-hover table-striped table-bordered table table-striped"
                               cellspacing="0" width="100%">

                            <thead>

                            <tr>
                                <?php if ($id == '') { ?>
                                    <th>{{ trans('lang.vendor')}}</th>
                                <?php } ?>
                                <th>{{trans('lang.paid_amount')}}</th>
                                <th>{{trans('lang.date')}}</th>
                                <th>{{trans('lang.vendors_payout_note')}}</th>
                                <th>Admin {{trans('lang.vendors_payout_note')}}</th>
                            </tr>

                            </thead>

                            <tbody id="append_list1">


                            </tbody>

                        </table>
                        <div id="data-table_paginate">
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript">


    var database = firebase.firestore();
    var id = '<?php echo $id; ?>';
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];

    var intRegex = /^\d+$/;
    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
    var vendorID="{{$id}}"; 
    <?php if ($id != '') { ?>
    var wallet_route = "{{route('users.walletstransaction','id')}}";
    $(".wallet_transaction").attr("href", wallet_route.replace('id', 'storeID='+vendorID));

    var refData = database.collection('payouts').where('vendorID', '==', '<?php echo $id; ?>').where('paymentStatus', '==', 'Success');
    var ref = refData.orderBy('paidDate', 'desc');
    getStoreNameFunction('<?php echo $id; ?>');
    <?php } else { ?>
    var refData = database.collection('payouts').where('paymentStatus', '==', 'Success');
    var ref = refData.orderBy('paidDate', 'desc');
    <?php } ?>

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

    var append_list = '';

    $(document).ready(function () {

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

            html = await buildHTML(snapshots);

            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);
                if (snapshots.docs.length < pagesize) {
                    jQuery("#data-table_paginate").hide();
                }

            }
            if (id == '') {
                $('#example24').DataTable({

                    order: [],
                    columnDefs: [{
                        targets: 1,
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                        {orderable: false, targets: [3]},
                    ],
                    order: [1, "desc"],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                });
            } else {
                $('#example24').DataTable({

                    order: [],
                    columnDefs: [{
                        targets: 2,
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                        {orderable: false, targets: [3]},
                    ],
                    order: [2, "desc"],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                });
            }


            if (snapshots.docs.length < pagesize) {
                jQuery("#data-table_paginate").hide();
            }

            jQuery("#data-table_processing").hide();
        });

    });


    function getStoreNameFunction(vendorId) {
        var vendorName = '';
        database.collection('vendors').where('id', '==', vendorId).get().then(function (snapshots) {
            var vendorData = snapshots.docs[0].data();
            vendorName = vendorData.title;
            $(".storeTitle").text(' - ' + vendorName);
            if (vendorData.dine_in_active == true) {
                $(".dine_in_future").show();
            }
        });
        return vendorName;
    }

    async function buildHTML(snapshots) {
        var html = '';
        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();
            var getData = await getListData(val);

            html += getData;
        }));
        return html;
    }

    async function getListData(val) {
        var html = '';
        var count = 0;
        const vendor = await payoutVendor(val.vendorID);

        if (vendor) {

            var price_val = '';
            var price = val.amount;

            if (intRegex.test(price) || floatRegex.test(price)) {

                price = parseFloat(price).toFixed(decimal_degits);
            } else {
                price = 0;
            }

            if (currencyAtRight) {
                price_val = parseFloat(price).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                price_val = currentCurrency + "" + parseFloat(price).toFixed(decimal_degits);
            }
            html = html + '<tr>';
            <?php if ($id == '') { ?>
            var route = '{{route("vendors.view",":id")}}';
            route = route.replace(':id', val.vendorID);
            html = html + '<td><a href="' + route + '">' + vendor + '</a></td>';
            <?php } ?>
            html = html + '<td>' + price_val + '</td>';
            var date = val.paidDate.toDate().toDateString();
            var time = val.paidDate.toDate().toLocaleTimeString('en-US');
            html = html + '<td>' + date + ' ' + time + '</td>';

            if (val.note != undefined && val.note != '') {
                html = html + '<td>' + val.note + '</td>';
            } else {
                html = html + '<td></td>';
            }
            if (val.adminNote != undefined && val.adminNote != '') {
                html = html + '<td>' + val.adminNote + '</td>';
            } else {
                html = html + '<td></td>';
            }

            html = html + '</tr>';
        }
        return html;
    }


    async function payoutVendor(vendor) {
        var payoutVendor = '';

        await database.collection('vendors').where("id", "==", vendor).get().then(async function (snapshotss) {
            if (snapshotss.docs[0]) {
                var vendor_data = snapshotss.docs[0].data();
                payoutVendor = vendor_data.title;

            }
        });
        return payoutVendor;
    }

</script>


@endsection