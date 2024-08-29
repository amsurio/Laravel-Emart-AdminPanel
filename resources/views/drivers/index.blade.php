@extends('layouts.app')

@section('content') 

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.driver_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.driver_table')}}</li>

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

                <div class="card">

                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! route('drivers') !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.driver_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('drivers.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.drivers_create')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">


                        <div class="table-responsive m-t-10">

                            <table id="driverTable"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>
                                <?php if (in_array('drivers.delete', json_decode(@session('user_permissions')))) { ?>

                                    <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active"
                                        ><a id="deleteAll" class="do_not_delete"
                                            href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                    <?php }?>
                                    <th>{{trans('lang.actions')}}</th>
                                    <th>{{trans('lang.extra_image')}}</th>
                                    <th>{{trans('lang.user_name')}}</th>
                                    <th>{{trans('lang.service_type')}}</th>
                                    <th>{{trans('lang.active')}}</th>
                                    <th>{{trans('lang.driver_online')}}</th>
                                    <th>{{trans('lang.date')}}</th>
                                    <th>{{trans('lang.total_orders')}}</th>
                                    <th>{{trans('lang.wallet_history')}}</th>

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

    if ($.inArray('drivers.delete', user_permissions) >= 0) {
        checkDeletePermission = true;
    }
    var database = firebase.firestore();
    var ref = database.collection('users').where("role", "==", "driver").orderBy('createdAt', 'desc');
    var alldriver = database.collection('users').where("role", "==", "driver").orderBy('createdAt', 'desc');
    var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })

    var append_list = '';
   
    $(document).ready(function () {


        jQuery("#data-table_processing").show();
        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            html = '';
            html = await buildHTML(snapshots);
            if (html != '') {
                append_list.innerHTML = html;
               
            }
            $('#driverTable').DataTable({
                order: [],
                columnDefs: [{
                    targets: (checkDeletePermission==true) ? 7 : 6,
                    type: 'date',
                    render: function (data) {
                        return data;
                    }
                },
                    {orderable: false, 
                    targets: (checkDeletePermission==true) ? [0, 1, 2, 5, 6,9] : [0,1,4,5,7,8]},
                ],
                order: (checkDeletePermission==true) ? [7, "desc"] : [6,"desc"],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
            });
            jQuery("#data-table_processing").hide();

        });


        alldriver.get().then(async function (snapshotsdriver) {

            snapshotsdriver.docs.forEach((listval) => {
                database.collection('vendor_orders').where('driverID', '==', listval.id).where("status", "in", ["Order Completed"]).get().then(async function (orderSnapshots) {
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
        html = html + '<tr>';
        newdate = '';
        var id = val.id;
        var route1 = '{{route("drivers.edit",":id")}}';
        route1 = route1.replace(':id', id);

        var driverView = '{{route("drivers.view",":id")}}';
        driverView = driverView.replace(':id', id);

        if(checkDeletePermission){
        html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>';
        }
        html = html + '<td class="action-btn"><a href="' + driverView + '"><i class="fa fa-eye"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
        if(checkDeletePermission){
        html = html+'<a id="' + val.id + '" name="driver-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        }
        html = html + '</td>';

        if (val.profilePictureURL == '') {
            html = html + '<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>';
        } else {
            if(val.profilePictureURL){
                photo=val.profilePictureURL;
            }else{
                photo=placeholderImage;
            }
            html = html + '<td><img class="rounded" style="width:50px" src="' + photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></td>';
        }

        html = html + '<td data-url="' + driverView + '" class="redirecttopage">' + val.firstName + ' ' + val.lastName + '</td>';
        
        if (val.serviceType) {
            var service = await serviceTypes(val.serviceType);
            html = html + '<td class="service_client' + val.serviceType + '">' + service + '</td>';
        } else {
            html = html + '<td>-</td>';

        }

        if (val.active == true) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="active"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="active"><span class="slider round"></span></label></td>';
        }
        if (val.isActive) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        }
       
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
    
        if (val.serviceType) {

            var driver = await orderDetails(val.id, val.serviceType);

            var url = "Javascript:void(0)";
            if (val.serviceType == "cab-service") {

                url = "{{route('drivers.rides','driverId')}}";
                url = url.replace('driverId', val.id);

            } else if (val.serviceType == "rental-service") {
                url = "{{route('rental_orders.driver','id')}}";
                url = url.replace("id", val.id);

            } else if (val.serviceType == "delivery-service" || val.serviceType == "ecommerce-service") {
                url = "{{route('orders','id')}}";
                url = url.replace("id", 'driverId=' + val.id);

            } else if (val.serviceType == "parcel_delivery") {
                url = "{{route('parcel_orders.driver','id')}}";
                url = url.replace("id", val.id);

            }

            html = html + '<td><a href="' + url + '">' + driver + '</a></td>';

        } else {
            html = html + '<td></td>';
        }


        var payoutRequests = '{{route("users.walletstransaction",":id")}}';
        payoutRequests = payoutRequests.replace(':id', 'driverID='+val.id);

        html = html + '<td><a href="'+payoutRequests+'">{{trans("lang.wallet_history")}}</a></td>';


        html = html + '</tr>';
        return html;
    }

    async function orderDetails(driver, type) {
        var count_order_complete = 0;

        if (type == "cab-service") {

            await database.collection('rides').where('driverID', '==', driver).get().then(async function (orderSnapshots) {
                count_order_complete = orderSnapshots.docs.length;

            });

        } else if (type == "rental-service") {
            await database.collection('rental_orders').where('driverID', '==', driver).get().then(async function (orderSnapshots) {
                count_order_complete = orderSnapshots.docs.length;

            });

        } else if (type == "delivery-service" || type == "ecommerce-service") {
            await database.collection('vendor_orders').where('driverID', '==', driver).get().then(async function (orderSnapshots) {
                count_order_complete = orderSnapshots.docs.length;

            });

        } else if (type == "parcel_delivery") {
            await database.collection('parcel_orders').where('driverID', '==', driver).get().then(async function (orderSnapshots) {
                count_order_complete = orderSnapshots.docs.length;

            });

        }


        return count_order_complete;
    }

    $(document).on("click", "input[name='isActive']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('users').doc(id).update({'isActive': true}).then(function (result) {
            });
        } else {
            database.collection('users').doc(id).update({'isActive': false}).then(function (result) {
            });
        }
    });
    $(document).on("click", "input[name='active']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('users').doc(id).update({'active': true}).then(function (result) {
            });
        } else {
            database.collection('users').doc(id).update({'active': false}).then(function (result) {
            });
        }
    });

    $("#is_active").click(function () {
        $("#driverTable .is_open").prop('checked', $(this).prop('checked'));

    });

    $("#deleteAll").click(function () {
        if ($('#driverTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#driverTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('users').doc(dataId).delete().then(function () {
                        const getStoreName = deleteDriverData(dataId);
                        setTimeout(function () {
                            window.location.reload();
                        }, 7000);
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    async function serviceTypes(service) {
        var serviceTypes = '';
       
        await database.collection('services').where("flag", "==", service).get().then(async function (snapshotservice) {

            if (snapshotservice.docs[0]) {
                var ride_data = snapshotservice.docs[0].data();
                serviceTypes = ride_data.name;
            } else {
            }
        });
        return serviceTypes;
    }


    async function deleteDriverData(driverId) {

        await database.collection('driver_payouts').where('driverID', '==', driverId).get().then(async function (snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('driver_payouts').doc(item_data.id).delete().then(function () {

                    });
                });
            }

        });

        //delete user from authentication
        var dataObject = {"data": {"uid": driverId}};
        var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';
        jQuery.ajax({
            url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
            method: 'POST',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataObject),
            success: function (data) {
                console.log('Delete user success:', data.result);
            },
            error: function (xhr, status, error) {
                var responseText = JSON.parse(xhr.responseText);
                console.log('Delete user error:', responseText.error);
            }
        });
    }

    $(document.body).on('click', '.redirecttopage', function () {
        var url = $(this).attr('data-url');
        window.location.href = url;
    });


    $(document).on("click", "a[name='driver-delete']", function (e) {
        var id = this.id;
        jQuery("#data-table_processing").show();
        database.collection('users').doc(id).delete().then(function (result) {
            const getStoreName = deleteDriverData(id);
            setTimeout(function () {
                window.location.reload();
            }, 7000);
        });

    });

    var rows = document.getElementsByTagName("table")[0].rows;

</script>

@endsection
