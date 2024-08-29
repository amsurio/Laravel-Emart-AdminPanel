@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor orderTitle page-title ">{{trans('lang.rides')}}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.rides')}}</li>
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
                            <li class="active">
                                <a href="{{route('drivers.ride',$id)}}">{{trans('lang.order_plural')}}</a>
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
                                <table id="example24"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>
                                        <th class="delete-all">
                                            <input type="checkbox" id="is_active">
                                            <label class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a>
                                            </label>
                                        </th>
                                        <?php }?>

                                        <th>{{trans('lang.order_id')}}</th>
                                        <th>{{trans('lang.order_user_id')}}</th>
                                        <?php if ($id == '') { ?>
                                        <th class="driverClass">{{trans('lang.driver_plural')}}</th>
                                        <?php } ?>
                                        <th>{{trans('lang.ridetype')}}</th>
                                        <th>{{trans('lang.address')}}</th>
                                        <th>{{trans('lang.amount')}}</th>
                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.status')}}</th>
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

        @endsection

        @section('scripts')

            <script type="text/javascript">

                var database = firebase.firestore();
                var id = '<?php echo $id; ?>';
                var sosId = '<?php echo @$sosId; ?>';
                var offest = 1;
                var pagesize = 10;
                var end = null;
                var endarray = [];
                var start = null;
                var user_number = [];
                var data = '';

                if (id != '') {
                    getDriverInfo(id);
                    var wallet_route = "{{route('users.walletstransaction','id')}}";
                    $(".wallet_transaction").attr("href", wallet_route.replace('id', 'driverID='+id));
                    var ref = database.collection('rides').where('driverID', '==', id).orderBy('createdAt', 'desc');
                } else if (sosId != '') {
                    var ref = database.collection('rides').where('id', '==', sosId).orderBy('createdAt', 'desc');

                } else {
                    var ref = database.collection('rides').orderBy('createdAt', 'desc');

                }
                var alldriver = database.collection('users').where("id", "==", id).orderBy('createdAt', 'desc');
                var placeholderImage = '';
                var append_list = '';
                var refCurrency = database.collection('currencies').where('isActive', '==', true);
                refCurrency.get().then(async function (snapshots) {
                    var currencyData = snapshots.docs[0].data();
                    currentCurrency = currencyData.symbol;
                    currencyAtRight = currencyData.symbolAtRight;
                });
                $(document).ready(function () {

                    var inx = parseInt(offest) * parseInt(pagesize);
                    jQuery("#data-table_processing").show();

                    var placeholder = database.collection('settings').doc('placeHolderImage');
                    placeholder.get().then(async function (snapshotsimage) {
                        var placeholderImageData = snapshotsimage.data();
                        placeholderImage = placeholderImageData.image;
                    })


                    append_list = document.getElementById('append_list1');
                    append_list.innerHTML = '';
                    ref.get().then(async function (snapshots) {
                        html = '';

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

                        <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>

                        if (id == '') {
                            $('#example24').DataTable({

                                order: [],
                                columnDefs: [{
                                    targets: 7,
                                    type: 'date',
                                    render: function (data) {
                                        return data;
                                    }
                                },
                                    {orderable: false, targets: [0, 8, 9]},
                                ],
                                order: [7, "desc"],
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
                                    targets: 6,
                                    type: 'date',
                                    render: function (data) {
                                        return data;
                                    }
                                },
                                    {orderable: false, targets: [0, 8]},
                                ],
                                order: [6, "desc"],
                                "language": {
                                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                                    "emptyTable": "{{trans("lang.no_record_found")}}"
                                },
                                responsive: true,
                            });
                        }
                        <?php }else{?>
                        if (id == '') {
                            $('#example24').DataTable({

                                order: [],
                                columnDefs: [{
                                    targets: 6,
                                    type: 'date',
                                    render: function (data) {
                                        return data;
                                    }
                                },
                                    {orderable: false, targets: [7, 8]},
                                ],
                                order: [6, "desc"],
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
                                    targets: 5,
                                    type: 'date',
                                    render: function (data) {
                                        return data;
                                    }
                                },
                                    {orderable: false, targets: [7]},
                                ],
                                order: [5, "desc"],
                                "language": {
                                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                                    "emptyTable": "{{trans("lang.no_record_found")}}"
                                },
                                responsive: true,
                            });
                        }

                        <?php }?>
                    });


                    alldriver.get().then(async function (snapshotsdriver) {

                        snapshotsdriver.docs.forEach((listval) => {
                            database.collection('rides').where('driverID', '==', listval.id).where("status", "in", ["Order Completed"]).get().then(async function (orderSnapshots) {
                                var count_order_complete = orderSnapshots.docs.length;
                                database.collection('users').doc(listval.id).update({'orderCompleted': count_order_complete}).then(function (result) {

                                });

                            });

                        });
                    });

                });

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

                    html = html + '<tr>';
                    newdate = '';
                    var id = val.id;
                    var user_id = val.author.id;
                    var route1 = '{{route("rides.edit",":id")}}';
                    route1 = route1.replace(':id', id);
                    var customer_view = '{{route("users.view",":id")}}';
                    customer_view = customer_view.replace(':id', user_id);
                    var driverView = '{{route("rides.view",":id")}}';
                    driverView = driverView.replace(':id', id);

                    <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>

                        html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                        'for="is_open_' + id + '" ></label></td>';
                    <?php }?>
                        html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.id + '</td>';

                    if (val.hasOwnProperty("author")) {
                        html = html + '<td data-url="' + customer_view + '" class="redirecttopage">' + val.author.firstName + '</td>';
                    } else {
                        html = html + '<td></td>';
                    }
                    if ('<?php echo $id; ?>' == "") {
                        if (val.hasOwnProperty("driver")) {
                            var driverId = val.driver.id;
                            var diverRoute = '{{route("drivers.view",":id")}}';
                            diverRoute = diverRoute.replace(':id', driverId);
                            html = html + '<td data-url="' + diverRoute + '" class="redirecttopage">' + val.driver.firstName + '</td>';
                        } else {
                            html = html + '<td></td>';
                        }
                    }
                    if (val.hasOwnProperty('rideType')) {
                        html = html + '<td>' + val.rideType + '</td>';
                    } else {
                        html = html + '<td></td>';
                    }
                    html = html + '<td>' + val.destinationLocationName + '</td>';
                    var total_price = parseFloat(val.subTotal).toFixed(2);
                    var discount = parseFloat(val.discount).toFixed(2);

                    total_price = total_price - discount;

                    try {
                        if (val.tax) {
                            if (val.taxType && val.tax) {
                                if (val.taxType == "percent") {
                                    tax = (val.tax * total_price) / 100;
                                } else {
                                    tax = val.tax;
                                }
                                tax = parseFloat(tax).toFixed(2);
                                if (!isNaN(tax) && tax != 0) {
                                    total_price = total_price + parseFloat(tax);
                                }
                            }
                        }
                    } catch (error) {

                    }

                    var tip_amount = parseFloat(val.tip_amount).toFixed(2);
                    if (!isNaN(tip_amount) && tip_amount != 0) {
                        total_price = total_price + tip_amount;
                    }
                    if (currencyAtRight) {
                        total_price = parseFloat(total_price).toFixed(2) + "" + currentCurrency;
                    } else {
                        total_price = currentCurrency + "" + parseFloat(total_price).toFixed(2);
                    }
                    html = html + '<td>' + total_price + '</td>';
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

                    if (val.status == 'Order Completed') {
                        html = html + '<td><span class="badge badge-success">Order Completed</span></td>';
                    } else if (val.status == 'Order Rejected') {
                        html = html + '<td><span class="badge badge-danger">Order Rejected</span></td>';
                    } else {
                        html = html + '<td><span class="badge badge-danger">Pending</span></td>';

                    }

                    html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
                    <?php if(in_array('rides.delete', json_decode(@session('user_permissions')))){?>

                        html = html + '<a id="' + val.id + '" name="driver-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
                    <?php }?>
                        html = html + '</td>';

                    html = html + '</tr>';
                    count = count + 1;

                    return html;
                }

                $(document.body).on('click', '.redirecttopage', function () {
                    var url = $(this).attr('data-url');
                    window.location.href = url;
                });
                $(document.body).on('change', '#selected_search', function () {
                    jQuery('#ride_type').hide();
                    if (jQuery(this).val() == 'rideType') {
                        jQuery('#ride_type').show();
                        jQuery('#search').hide();

                    } else {

                        jQuery('#ride_type').hide();
                        jQuery('#search').show();

                    }
                });

                $(document).on("click", "a[name='driver-delete']", function (e) {
                    var id = this.id;
                    database.collection('rides').doc(id).delete().then(function () {
                        window.location.reload();
                    });


                });


                $("#is_active").click(function () {
                    $("#example24 .is_open").prop('checked', $(this).prop('checked'));

                });

                $("#deleteAll").click(function () {
                    if ($('#example24 .is_open:checked').length) {
                        if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                            jQuery("#data-table_processing").show();
                            $('#example24 .is_open:checked').each(function () {
                                var dataId = $(this).attr('dataId');
                                database.collection('rides').doc(dataId).delete().then(function () {
                                    setTimeout(function () {
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
                $('.page-title').html("{{trans('lang.rides')}}  - "+driverName);
            }
        });

}

</script>

@endsection