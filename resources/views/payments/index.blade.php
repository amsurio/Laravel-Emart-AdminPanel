@extends('layouts.app')

@section('content')
<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.payment_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.payment_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default"
                                 style="display: none;">{{ trans('lang.processing')}}
                                </div>
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">


                    <div class="table-responsive m-t-10">


                        <table id="example24"
                               class="display nowrap table table-hover table-striped table-bordered table table-striped"
                               cellspacing="0" width="100%">

                            <thead>

                            <tr>
                                <th>{{ trans('lang.vendor')}}</th>
                                <th>{{ trans('lang.total_amount')}}</th>
                                <th>{{trans('lang.paid_amount')}}</th>
                                <th>{{trans('lang.remaining_amount')}}</th>
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

</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript">

var database = firebase.firestore();
var offest = 1;
var pagesize = 10;
var end = null;
var endarray = [];
var start = null;
var user_number = [];
var ref = database.collection('vendors');

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

        html =await buildHTML(snapshots);
        jQuery("#data-table_processing").hide();
        if (html != '') {
            append_list.innerHTML = html;
            start = snapshots.docs[snapshots.docs.length - 1];
            endarray.push(snapshots.docs[0]);
            if (snapshots.docs.length < pagesize) {
                jQuery("#data-table_paginate").hide();
            }
        }
        $('#example24').DataTable({
                
                order: [0, "desc"],

                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
            });
    });

});


    async function buildHTML(snapshots) {
        var html = '';

        await Promise.all(snapshots.docs.map(async (listval) => {

            var val = listval.data();

            var getData = await getPaymentListData(val);
            html += getData;
        }));

        return html;
    }

    async function getPaymentListData(val) {
        var html = '';

        html = html + '<tr>';
        newdate = '';
        var id = val.id;
        var route1 = '{{route("vendors.view",":id")}}';
        route1 = route1.replace(':id', id);

        html = html + '<td data-url="' + route1 + '" class="redirecttopage ">' + val.title + '</td>';

        var data = await remainingPrice(val.id);

        var total_class = '';
        var paid_price_val_class = '';
        var remaining_val_class = '';

        if (currencyAtRight) {

            if (data.total < 0) {
                total_class = '';

                total = Math.abs(data.total);
                data.total = '(-' + parseFloat(total).toFixed(decimal_degits) + "" + currentCurrency + ')';

            } else {
                data.total = parseFloat(data.total).toFixed(decimal_degits) + "" + currentCurrency;

            }

            
            paid_price_val = Math.abs(data.paid_price_val);
            data.paid_price_val = '(' + parseFloat(paid_price_val).toFixed(decimal_degits) + "" + currentCurrency + ')';
            


            if (data.remaining_val < 0) {
                remaining_val_class = '';
                remaining_val = Math.abs(data.remaining_val);
                data.remaining_val = '(-' + parseFloat(remaining_val).toFixed(decimal_degits) + "" + currentCurrency + ')';
            } else {
                data.remaining_val = parseFloat(data.remaining_val).toFixed(decimal_degits) + "" + currentCurrency;

            }
        } else {

            if (data.total < 0) {
                total_class = '';

                total = Math.abs(data.total);
                data.total = '(-' + currentCurrency + "" + parseFloat(total).toFixed(decimal_degits) + ')';

            } else {
                data.total = currentCurrency + "" + parseFloat(data.total).toFixed(decimal_degits);

            }

            paid_price_val = Math.abs(data.paid_price_val);
            data.paid_price_val = '(' + currentCurrency + "" + parseFloat(paid_price_val).toFixed(decimal_degits) + ')';
            

            if (data.remaining_val < 0) {
                remaining_val_class = '';

                remaining_val = Math.abs(data.remaining_val);

                data.remaining_val = '(-' + currentCurrency + "" + parseFloat(remaining_val).toFixed(decimal_degits) + ')';

            } else {
                data.remaining_val = currentCurrency + "" + parseFloat(data.remaining_val).toFixed(decimal_degits);

            }


        }


        html = html + '<td class="' + total_class + '">' + data.total + '</td>';
        html = html + '<td class="' + paid_price_val_class + '">' + data.paid_price_val + '</td>';
        html = html + '<td class="' + remaining_val_class + '">' + data.remaining_val + '</td>';
        html = html + '</tr>';

        return html;
    }

  
    async function remainingPrice(vendorID) {

        var data = {};

        var paid_price = 0;

        var total_price = 0;

        var remaining = 0;

        var adminCommission = 0;

        await database.collection('payouts').where('vendorID', '==', vendorID).where('paymentStatus', '==', 'Success').get().then(async function (payoutSnapshots) {

            payoutSnapshots.docs.forEach((payout) => {

                var payoutData = payout.data();

                paid_price = parseFloat(paid_price) + parseFloat(payoutData.amount);

            });

            await database.collection('users').where('vendorID', '==', vendorID).get().then(async function (vendorSnapshots) {
                var vendor = [];
                var wallet_amount = 0;
                if (vendorSnapshots.docs.length) {
                    vendor = vendorSnapshots.docs[0].data();

                    if (isNaN(vendor.wallet_amount) || vendor.wallet_amount == undefined || vendor.wallet_amount == "") {
                        wallet_amount = 0;
                    } else {
                        wallet_amount = vendor.wallet_amount;
                    }

                }

                var remaining = wallet_amount;

                total_price = wallet_amount + paid_price;

                if (Number.isNaN(paid_price)) {
                    paid_price = 0;
                }

                if (Number.isNaN(total_price)) {
                    total_price = 0;
                }

                if (Number.isNaN(remaining)) {
                    remaining = 0;
                }

                data = {
                    'total': total_price,
                    'paid_price_val': paid_price,
                    'remaining_val': remaining,
                };
            });

        });

        return data;

    }

</script>

@endsection
