@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.provider_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.provider_table')}}</li>
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
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.provider_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('providers.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.provider_create')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive m-t-10">
                            <table id="userTable"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                <?php if (in_array('providers.delete', json_decode(@session('user_permissions')))) { ?>

                                    <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                                                               class="do_not_delete"
                                                                                               href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                    <?php }?>
                                    <th>{{trans('lang.extra_image')}}</th>
                                    <th>{{trans('lang.user_name')}}</th>
                                    <th>{{trans('lang.email')}}</th>
                                    <th>{{trans('lang.date')}}</th>
                                    <th>{{trans('lang.total_orders')}}</th>
                                    <th>{{trans('lang.active')}}</th>
                                    <th>{{trans('lang.wallet_transaction')}}</th>
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

    var ref = database.collection('users').where("role", "in", ["provider"]).orderBy('createdAt', 'desc');
    var user_permissions = '<?php echo @session('user_permissions') ?>';

        user_permissions = JSON.parse(user_permissions);

        var checkDeletePermission = false;

        if ($.inArray('providers.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }

    var placeholderImage = '';
    var append_list = '';

    $(document).ready(function() {

        $(document.body).on('click', '.redirecttopage', function() {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        var inx = parseInt(offest) * parseInt(pagesize);
        jQuery("#data-table_processing").show();

        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function(snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        })

        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function(snapshots) {

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
            $('#userTable').DataTable(
                     {
                order: [],
                columnDefs: [{
                         targets: (checkDeletePermission==true)? 4 : 3,
                         type: 'date',
                        render: function(data) {
                            return data;
                        }
                    },

                    {
                        orderable: false,
                        targets: (checkDeletePermission==true) ? [0, 1, 6, 7, 8] : [0,4,5,6]
                    },
                ],
                order: (checkDeletePermission==true) ? [4,"desc"] : [3,"desc"],
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
        var route1 = '{{route("providers.edit",":id")}}';
        route1 = route1.replace(':id', id);
        var trroute1 = '{{route("users.walletstransaction",":id")}}';
        trroute1 = trroute1.replace(':id', "providerID="+val.id);

        var providerView = '{{route("providers.view",":id")}}';
        providerView = providerView.replace(':id', id);



        if (checkDeletePermission) {

        html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>';
        }
        if (val.profilePictureURL == '') {

            html = html + '<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>';
        } else {
            html = html + '<td><img class="rounded" style="width:50px" src="' + val.profilePictureURL + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image"></td>';
        }


        html = html + '<td data-url="' + providerView + '" class="redirecttopage">' + val.firstName + ' ' + val.lastName + '</td>';

        html = html + '<td>' + val.email + '</td>';
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

        var providerr = await orderDetails(val.id); 
        
        html = html +'<td>'+providerr+'</td>';    
        
        if (val.active) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        }
        html = html + '<td><a href="' + trroute1 + '">{{trans("lang.transaction")}}</a></td>';

        html = html + '<td class="action-btn"><a href="' + providerView + '"><i class="fa fa-eye"></i></a>';
        html = html + '<a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
        if (checkDeletePermission) {
        html=html+'<a id="' + val.id + '" class="do_not_delete" name="user-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        }
        html=html+'</td>';
        html = html + '</tr>';

        return html;
    }

     async function orderDetails(id) {
        var count_order_complete = 0;

        await database.collection('provider_orders').where('provider.author', '==', id).get().then(async function (orderSnapshots) {
            count_order_complete = orderSnapshots.docs.length;

        });

        return count_order_complete;
    }




    $("#is_active").click(function() {
        $("#userTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAll").click(function() {
        if ($('#userTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#userTable .is_open:checked').each(function() {
                    var dataId = $(this).attr('dataId');
                    database.collection('users').doc(dataId).delete().then(function() {
                        const getStoreName = deleteUserData(dataId);
                        setTimeout(function() {
                            window.location.reload();
                        }, 7000);
                    });

                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    async function deleteUserData(userId) {


          await database.collection('providers_workers').where('providerId', '==', userId).get().then(async function(snapshotsItem) {
 
            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                        var objectnew = {
                            "data": {
                                "uid": item_data.id
                            }
                        };
                        var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';
                        jQuery.ajax({
                            url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
                            method: 'POST',
                            contentType: "application/json; charset=utf-8",
                            data: JSON.stringify(objectnew),
                            success: function(data) { 
                                console.log('Delete user worker success:', data.result);

                            },
                            error: function(xhr, status, error) {
                                var responseText = JSON.parse(xhr.responseText);
                                console.log('Delete user worker error:', responseText.error);
                            }
                        });


                    database.collection('providers_workers').doc(item_data.id).delete().then(function() {

                    });


                });
            }

        });

        await database.collection('wallet').where('user_id', '==', userId).get().then(async function(snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('wallet').doc(item_data.id).delete().then(function() {

                    });
                });
            }

        });
        await database.collection('favorite_provider').where('provider_id', '==', userId).get().then(async function(snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('favorite_provider').doc(item_data.id).delete().then(function() {

                    });
                });
            }

        });
        await database.collection('providers_services').where('author', '==', userId).get().then(async function(snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('providers_services').doc(item_data.id).delete().then(function() {

                    });
                });
            }

        });
    
        await database.collection('providers_coupons').where('providerId', '==', userId).get().then(async function(snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('providers_coupons').doc(item_data.id).delete().then(function() {

                    });
                });
            }

        });
      
         await database.collection('payouts').where('vendorID', '==', userId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();

                        database.collection('payouts').doc(item_data.id).delete().then(function () {

                        });
                    });
                }

            });

        //delete user from authentication    
        var dataObject = {
            "data": {
                "uid": userId
            }
        };
        var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';
        jQuery.ajax({
            url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
            method: 'POST',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(dataObject),
            success: function(data) { 
                console.log('Delete user success:', data.result);

            },
            error: function(xhr, status, error) {
                var responseText = JSON.parse(xhr.responseText);
                console.log('Delete user error:', responseText.error);
            }
        });
    }


    $(document).on("click", "a[name='user-delete']", function(e) {
        var id = this.id;
        jQuery("#data-table_processing").show();
        database.collection('users').doc(id).delete().then(function(result) {
            const getStoreName = deleteUserData(id);
            setTimeout(function() {
                window.location.reload();
            }, 7000);
        });
    });

    $(document).on("click", "input[name='isActive']", function(e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('users').doc(id).update({
                'active': true
            }).then(function(result) {});
        } else {
            database.collection('users').doc(id).update({
                'active': false
            }).then(function(result) {});
        }
    });
</script>

@endsection