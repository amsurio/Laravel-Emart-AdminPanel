@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor page-title">{{trans('lang.drivers_payout_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.drivers_payout_plural')}}</li>
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
                    <div class="menu-tab vendorMenuTab">
                        <ul>
                            <li>
                                <a href="{{route('drivers.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="{{route('drivers.vehicle',$id)}}">{{trans('lang.vehicle')}}</a>
                            </li>
                            <li class="service_type_orders">

                            </li>
                            <li class="active">
                                <a href="{{route('driver.payouts',$id)}}">{{trans('lang.tab_payouts')}}</a>
                            </li>
                            <li>
                                <a href="{{route('users.walletstransaction',$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                             </li>
                        </ul>
                    </div>
                    <?php } ?>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.drivers_payout_table')}}</a>
                            </li>
                            @if($id=='')
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('driversPayouts.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.drivers_payout_create')}}</a>
                            </li>
                            @else
                             <li class="nav-item">
                                <a class="nav-link" href="{{ url('driversPayouts/create/'.$id) }}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.drivers_payout_create')}}</a>
                            </li>
                            @endif

                        </ul>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive m-t-10">


                        <table id="example24"
                               class="display nowrap table table-hover table-striped table-bordered table table-striped"
                               cellspacing="0" width="100%">

                            <thead>

                            <tr>
                                <th>{{ trans('lang.driver')}}</th>
                                <th>{{trans('lang.paid_amount')}}</th>

                                <th>{{trans('lang.drivers_payout_paid_date')}}</th>
                                <th>{{trans('lang.drivers_payout_note')}}</th>
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
    var id="{{$id}}";
    var refData = database.collection('driver_payouts').where('paymentStatus', '==', 'Success');
    if(id!=''){
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+id));
        refData=refData.where('driverID','==',id);
    }
    var ref = refData.orderBy('paidDate', 'desc');
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
        if(id!=''){
            payoutDriverfunction(id);
        }
        
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
            $('#example24').DataTable({

                order: [],
                columnDefs: [{
                    targets: 2,
                    type: 'date',
                    render: function (data) {
                        return data;
                    }
                }
                   
                ],
                order: [0, "desc"],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
            });
            jQuery("#data-table_processing").hide();
        });

    });


    async function buildHTML(snapshots) {
        var html = '';

        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();
            var route1 = '{{route("drivers.edit",":id")}}';
            route1 = route1.replace(':id', val.id);
            var getData = await getListData(val);

            html += getData;
        }));
        return html;
    }

    async function getListData(val) {
        var html = '';
        const payoutDriver = await payoutDriverfunction(val.driverID);

        if (payoutDriver) {

            var routedriver = '{{route("drivers.view",":id")}}';
            routedriver = routedriver.replace(':id', val.driverID);
            html = html + '<tr>';

            html = html + '<td><a href="' + routedriver + '">' + payoutDriver + '</a></td>';

            if (currencyAtRight) {
                html = html + '<td>' + parseFloat(val.amount).toFixed(decimal_degits) + '' + currentCurrency + '</td>';
            } else {
                html = html + '<td>' + currentCurrency + '' + parseFloat(val.amount).toFixed(decimal_degits) + '</td>';
            }
            var date = val.paidDate.toDate().toDateString();
            var time = val.paidDate.toDate().toLocaleTimeString('en-US');
            html = html + '<td>' + date + ' ' + time + '</td>';
            html = html + '<td>' + val.note + '</td>';

            html = html + '</tr>';
        }
        return html;
    }

    async function payoutDriverfunction(driver) {
        var payoutDriver = '';

        await database.collection('users').where("id", "==", driver).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                var driver_data = snapshotss.docs[0].data();
                payoutDriver = driver_data.firstName + " " + driver_data.lastName;
                $('.page-title').html("{{trans('lang.drivers_payout_plural')}}")
                if (driver_data.serviceType == "cab-service") {

                        var url = "{{route('drivers.rides','driverId')}}";
                        url = url.replace('driverId', driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (driver_data.serviceType == "rental-service") {
                        var url = "{{route('rental_orders.driver','id')}}";
                        url = url.replace("id", driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (driver_data.serviceType == "delivery-service" || driver_data.serviceType == "ecommerce-service") {
                        var url = "{{route('orders','id')}}";
                        url = url.replace("id", 'driverId=' + driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    } else if (driver_data.serviceType == "parcel_delivery") {
                        var url = "{{route('parcel_orders.driver','id')}}";
                        url = url.replace("id", driver_data.id);
                        $('.service_type_orders').html('<a href="' + url + '">{{trans('lang.order_plural')}}</a>');

                    }
            }
        });
        return payoutDriver;
    }

</script>

@endsection
