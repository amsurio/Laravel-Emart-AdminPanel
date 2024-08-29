@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor page-title">{{trans('lang.parcel_plural')}} {{trans('lang.order_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb" id="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.parcel_plural')}} {{trans('lang.order_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{ trans('lang.processing')}}
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
                            <li class="active">
                                <a href="{{route('parcel_orders.driver',$id)}}">{{trans('lang.order_plural')}}</a>
                            </li>
                            <li>
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

                    <div class="card-body">


                        <div class="table-responsive m-t-10">
                            <table id="parcelTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>

                                    <tr>
                                    <?php if (in_array('parcel.orders.delete', json_decode(@session('user_permissions')))) { ?>

                                        <th class="delete-all">
                                            <input type="checkbox" id="is_active">
                                            <label class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i> {{trans('lang.all')}}</a>
                                            </label>
                                        </th>
                                        <?php }?>
                                        <th>{{trans('lang.order_id')}}</th>

                                        <th>{{trans('lang.item_review_user_id')}}</th>
                                        <th>{{trans('lang.driver')}}</th>

                                        <th>{{trans('lang.amount')}}</th>

                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.order_order_status_id')}}</th>
                                        <th>{{trans('lang.actions')}}</th>

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
    var user_permissions = '<?php echo @session('user_permissions') ?>';

        user_permissions = JSON.parse(user_permissions);

        var checkDeletePermission = false;

        if ($.inArray('parcel.orders.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }

    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;

    var append_list = '';
    var user_number = [];

    var driverID = '{{$id}}';

    var refData = database.collection('parcel_orders');
    var ref = database.collection('parcel_orders').orderBy('createdAt', 'desc');

    if(driverID){
        getDriverInfo(driverID);
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+driverID));
        var refData = database.collection('parcel_orders').where('driverID','==',driverID);
        var ref = database.collection('parcel_orders').where('driverID','==',driverID).orderBy('createdAt', 'desc');
    }

    var currentCurrency = '';
    var currencyAtRight = false;
    var decimal_degits = 0;

    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function(snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }
    });

    $(document).ready(function() {
        var order_status = jQuery('#order_status').val();
        var search = jQuery("#search").val();


        $(document.body).on('click', '.redirecttopage', function() {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        jQuery('#search').hide();

        $(document.body).on('change', '#selected_search', function() {

            if (jQuery(this).val() == 'status') {
                jQuery('#order_status').show();
                jQuery('#search').hide();
            } else {

                jQuery('#order_status').hide();
                jQuery('#search').show();

            }
        });


        jQuery("#data-table_processing").show();
        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function(snapshots) {

            var html = '';
            html = await buildHTML(snapshots);
            jQuery("#data-table_processing").hide();
            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);
                if (snapshots.docs.length < pagesize) {
                    jQuery("#data-table_paginate").hide();
                }
            }
            $('#parcelTable').DataTable({
                order: [],
                columnDefs: [{
                        targets: (checkDeletePermission==true) ? 5 : 4,
                        type: 'date',
                        render: function(data) {

                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: (checkDeletePermission==true) ? [0, 7] : [6]
                    },
                ],
                order: (checkDeletePermission==true) ? ['5', 'desc'] : [4,'desc'],
                "language": {
                    "zeroRecords": "{{trans('lang.no_record_found')}}",
                    "emptyTable": "{{trans('lang.no_record_found')}}"
                },
                responsive: true
            });

        });

    });
    async function buildHTML(snapshots) {
        var html = '';
        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();

            let result = user_number.filter(obj => {
                return obj.id == val.author;
            })

            if (result.length > 0) {
                val.phoneNumber = result[0].phoneNumber;
                val.isActive = result[0].isActive;

            } else {
                val.phoneNumber = '';
                val.isActive = false;
            }

            var getData = await getListData(val);
            html += getData;
        }));
        return html;
    }
    async function getListData(val) {
            var html = '';

            html = html + '<tr>';
            newdate = '';
            var id = val.id;
            var vendorID = val.vendorID;
            var user_id = val.authorID;
            var route1 = '{{route("parcel_orders.edit",":id")}}';
            route1 = route1.replace(':id', id);

            var user_view = '{{route("users.view",":id")}}';
            user_view = user_view.replace(':id', user_id);

            var driver_id = val.driverID;
            var driverView = '{{route("drivers.view",":id")}}';
            driverView = driverView.replace(':id', driver_id);
            if(checkDeletePermission){
            html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                'for="is_open_' + id + '" ></label></td>';
            }

            html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.id + '</td>';
            html = html + '<td data-url="' + user_view + '" class="redirecttopage">' + val.author.firstName + ' ' + val.author.lastName + '</td>';

            if (val.driver != undefined) {
                var firstName = val.driver.firstName;
                var lastName = val.driver.lastName;
                html = html + '<td data-url="' + driverView + '" class="redirecttopage">' + firstName + ' ' + lastName + '</td>';

            } else {
                var firstName = '';
                var lastName = '';
                html = html + '<td></td>';

            }



            var price = 0;



            price = buildParcelTotal(val);

            html = html + '<td>' + price + '</td>';

        var date = '';
        var time = '';
        if (val.hasOwnProperty("createdAt")) {
            try {
                date = val.createdAt.toDate().toDateString();
                time = val.createdAt.toDate().toLocaleTimeString('en-US');
            } catch (err) {

            }
            html = html + '<td class="dt-time">' + date + ' ' + time + '</td>';
        } else {
            html = html + '<td></td>';
        }

            if (val.status == 'Order Placed') {
                html = html + '<td class="order_placed"><span>' + val.status + '</span></td>';

                }
                else if (val.status == 'Order Accepted') {
                    html = html + '<td class="order_accepted"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Order Rejected') {
                    html = html + '<td class="order_rejected"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Driver Pending') {
                    html = html + '<td class="driver_pending"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Driver Rejected') {
                    html = html + '<td class="driver_rejected"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Order Shipped') {
                    html = html + '<td class="order_shipped"><span>' + val.status + '</span></td>';

                } else if (val.status == 'In Transit') {
                    html = html + '<td class="in_transit"><span>' + val.status + '</span></td>';

                } else if (val.status == 'Order Completed') {
                    html = html + '<td class="order_completed"><span>' + val.status + '</span></td>';

                } else {
                    html = html + '<td class="order_completed"><span>' + val.status + '</span></td>';

                }

                html = html + '<td class="action-btn"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
                if(checkDeletePermission){
                html=html+'<a id="' + val.id + '" class="do_not_delete" name="order-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
                }
                html=html+'</td>';


                html = html + '</tr>';

                return html;
            }


            $(document.body).on('change', '#order_status', function() {
                order_status = jQuery(this).val();
            });

            $(document.body).on('keyup', '#search', function() {
                search = jQuery(this).val();
            });
            var orderStatus = '<?php if (isset($_GET['status'])) {
                                    echo $_GET['status'];
                                } else {
                                    echo '';
                                } ?>';
            if (orderStatus) {
                if (orderStatus == 'order-placed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Placed');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_placed')}}</li>");

                } else if (orderStatus == 'order-confirmed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Accepted', 'Driver Accepted']);
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_accepted')}}</li>");

                } else if (orderStatus == 'order-shipped') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', 'in', ['Order Shipped', 'In Transit']);
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_shipped')}}</li>");

                } else if (orderStatus == 'order-completed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Completed');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_completed')}}</li>");

                } else if (orderStatus == 'order-canceled') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Order Rejected');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.order_rejected')}}</li>");

                } else if (orderStatus == 'order-failed') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Rejected');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.driver_rejected')}}</li>");

                } else if (orderStatus == 'order-pending') {
                    ref = refData.orderBy('createdAt', 'desc').where('status', '==', 'Driver Pending');
                    $("ol.breadcrumb ").append("<li class='breadcrumb-item active'>{{trans('lang.driver_pending')}}</li>");

                } else {

                    ref = refData.orderBy('createdAt', 'desc');
                }
            }

            $(document).on("click", "a[name='order-delete']", function(e) {
                var id = this.id;
                database.collection('parcel_orders').doc(id).delete().then(function(result) {
                    window.location.href = '{{ url()->current() }}';
                });


            });

            function buildParcelTotal(snapshotsProducts) {

                var adminCommission = snapshotsProducts.adminCommission;
                var adminCommissionType = snapshotsProducts.adminCommissionType;
                var discount = snapshotsProducts.discount;
                var subTotal = snapshotsProducts.subTotal;


                var total_price = subTotal;

                var intRegex = /^\d+$/;
                var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                if (intRegex.test(discount) || floatRegex.test(discount)) {

                    discount = parseFloat(discount).toFixed(2);
                    total_price -= parseFloat(discount);

                }

                var total_tax_amount = 0;

                if (snapshotsProducts.hasOwnProperty('taxSetting') && snapshotsProducts.taxSetting != '' && snapshotsProducts.taxSetting != null) {
                    for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                        var data = snapshotsProducts.taxSetting[i];

                        var tax = 0;

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {

                                tax = (data.tax * total_price) / 100;
                            } else {
                                tax = data.tax;
                            }
                        }
                        total_tax_amount += parseFloat(tax);
                    }
                }

                total_price += parseFloat(total_tax_amount);

                if (currencyAtRight) {

                    var total_price_val = total_price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    var total_price_val = currentCurrency + "" + total_price.toFixed(decimal_degits);
                }

                return total_price_val;
            }

            $("#is_active").click(function() {
                $("#parcelTable .is_open").prop('checked', $(this).prop('checked'));

            });

            $("#deleteAll").click(function() {
                if ($('#parcelTable .is_open:checked').length) {
                    if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                        jQuery("#data-table_processing").show();
                        $('#parcelTable .is_open:checked').each(function() {
                            var dataId = $(this).attr('dataId');
                            database.collection('parcel_orders').doc(dataId).delete().then(function() {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 5000);
                            });
                        });
                    }
                } else {
                    alert("{{trans('lang.select_delete_alert')}}");
                }
            });

async function getDriverInfo(driverId){
   
            await database.collection('users').where("id", "==", driverId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                var driver_data = snapshotss.docs[0].data();
                driverName = driver_data.firstName + " " + driver_data.lastName;
                $('.page-title').html("{{trans('lang.parcel_plural')}} {{trans('lang.order_plural')}} - "+driverName);
            }
        });

}
</script>


@endsection