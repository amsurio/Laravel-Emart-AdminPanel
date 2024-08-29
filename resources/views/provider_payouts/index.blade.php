@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.provider_payout_plural')}} <span class="providerTitle"></span></h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.provider_payout_plural')}}</li>
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
                @if($id!='')
                    <div class="resttab-sec">

                        <div class="menu-tab tabDiv">
                            <ul>
                                <li ><a href="{{route('providers.view', $id)}}">{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li><a href="{{route('ondemand.services.index', $id)}}">{{trans('lang.services')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a></li>
                                 <li class="active">
                                    <a href="{{route('providerPayouts.payout', $id)}}">{{trans('lang.tab_payouts')}}</a>
                                </li>
                                 <li>
                                    <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    @endif

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.provider_payout_table')}}</a>
                            </li>

                            <?php if ($id != '') { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('providerPayouts.create') !!}/{{$id}}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.provider_payout_create')}}</a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('providerPayouts.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.provider_payout_create')}}</a>
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
                                    <th>{{ trans('lang.provider')}}</th>
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

    var intRegex = /^\d+$/;
    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

    <?php if ($id != '') { ?>
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID='+id));

    var ref = database.collection('payouts').where('vendorID', '==', '<?php echo $id; ?>').where('paymentStatus', '==', 'Success').where('role','==','provider').orderBy('paidDate', 'desc');
    getProviderName('<?php echo $id; ?>');
    <?php } else { ?>
    var ref = database.collection('payouts').where('paymentStatus', '==', 'Success').where('role','==','provider').orderBy('paidDate', 'desc');
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

      
        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            html = '';

            html = await buildHTML(snapshots);

            if (html != '') {
                append_list.innerHTML = html;
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
                        {orderable: false, targets: [0, 3]},
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
                        {orderable: false, targets: [0, 3]},
                    ],
                    order: [2, "desc"],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                });
            }

            jQuery("#data-table_processing").hide();
        });

    });


    function getProviderName(providerId) {
        var providerName = '';
        database.collection('users').where('id', '==', providerId).get().then(function (snapshots) {
            var providerData = snapshots.docs[0].data();
            providerName = providerData.firstName+' '+providerData.lastName;
            $(".providerTitle").text(' - ' + providerName);
           
        });
        return providerName;
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
      
        const provider = await payoutProvider(val.vendorID);

        if (provider) {

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
            var route = '{{route("providers.view",":id")}}';
            route = route.replace(':id', val.vendorID);
            html = html + '<td><a href="' + route + '">' + provider + '</a></td>';
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


    async function payoutProvider(provider) {
        var payoutProvider = '';

        await database.collection('users').where("id", "==", provider).get().then(async function (snapshotss) {
            if (snapshotss.docs[0]) {
                var provider_data = snapshotss.docs[0].data();
                payoutProvider = provider_data.firstName+' '+provider_data.lastName;

            }
        });
        return payoutProvider;
    }

</script>


@endsection