@extends('layouts.app')

@section('content')

    <div class="page-wrapper">

        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor">{{trans('lang.section_plural')}}</h3>

            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.section_plural')}}</li>
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

                    <div class="card">

                        <div class="card-header">
                            <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                                <li class="nav-item">
                                    <a class="nav-link active" href="{!! url()->current() !!}"><i
                                                class="fa fa-list mr-2"></i>{{trans('lang.section_table')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link section-create" href="{!! route('section.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.section_create')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive m-t-10">


                                <table id="sectionTable"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">

                                    <thead>

                                    <tr>

                                        <th>{{trans('lang.section_image')}}</th>

                                        <th>{{trans('lang.faq_section_name')}}</th>
                                        <th>{{trans('lang.service_type')}}</th>

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
        var ref = database.collection('sections');
        var append_list = '';
        var placeholderImage = '';
        var user_permissions = '<?php echo @session('user_permissions') ?>';
        user_permissions = JSON.parse(user_permissions);
        var checkDeletePermission = false;

        if ($.inArray('section.service.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }

        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        });


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
                $('#sectionTable').DataTable({
                    order: [],
                    columnDefs: [
                        {
                            orderable: false,
                            targets: [0, 3, 4]
                        },
                    ],
                    order: [1, "asc"],
                    "language": {
                        "zeroRecords": "{{trans('lang.no_record_found')}}",
                        "emptyTable": "{{trans('lang.no_record_found')}}"
                    },
                    responsive: true
                });
            });
      jQuery("#data-table_processing").hide();
        });

        async function buildHTML(snapshots) {
            var html = '';
            await Promise.all(snapshots.docs.map(async (listval) => {
                var val = listval.data();

                if (val.title != '') {
                    var getData = await getListData(val);
                    html += getData;
                }

            }));
            return html;
        }

        async function getListData(val) {

            var html = '';

            html = html + '<tr>';
            newdate = '';
            var id = val.id;
            var vendorUserId = val.author;
            var route1 = '{{route("section.edit",":id")}}';
            route1 = route1.replace(':id', id);

            if (val.sectionImage != '') {
                if (val.sectionImage) {
                    photo = val.sectionImage;
                } else {
                    photo = placeholderImage;
                }
                html = html + '<td><img alt="" width="100%" style="width:70px;height:70px;" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image"></td>';

            } else {

                html = html + '<td><img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image"></td>';
            }

            html = html + '<td data-url="' + route1 + '" class="redirecttopage"><a href="' + route1 + '">' + val.name + '</a></td>';
            html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.serviceType + '</td>';

            if (val.isActive) {
                html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
            } else {
                html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
            }
            html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
            if (checkDeletePermission) {
                html = html + '<a id="' + val.id + '" name="section-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
            }
            html = html + '</td>';

            html = html + '</tr>';

            return html;
        }

        $(document).on("click", "input[name='isActive']", function (e) {

            var ischeck = $(this).is(':checked');
            var id = this.id;
            if (ischeck) {
                database.collection('sections').doc(id).update({'isActive': true}).then(function (result) {
                });
            } else {
                database.collection('sections').doc(id).update({'isActive': false}).then(function (result) {
                });
            }

        });

        $(document).on("click", "a[name='section-delete']", function (e) {
            var id = this.id;
            var all_delete_alert = '{{trans("lang.all_delete_alert")}}';
            if (confirm(all_delete_alert)) {
                jQuery("#data-table_processing").show();
                database.collection('sections').doc(id).delete().then(function (result) {
                    deleteAllSectionData(id).then(function () {
                        setTimeout(function () {
                            window.location.reload();
                        }, 9000);
                    });
                });
            }
        });

        async function deleteAllSectionData(sectionId) {

            await database.collection('banner_items').where('sectionId', '==', sectionId).get().then(async function (bannersnapshots) {
                if (bannersnapshots.docs.length > 0) {
                    bannersnapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('banner_items').doc(item_data.id).delete().then(function () {
                        });
                    });

                }
            });

            await database.collection('coupons').where('section_id', '==', sectionId).get().then(async function (couponssnapshots) {
                if (couponssnapshots.docs.length > 0) {
                    couponssnapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('coupons').doc(item_data.id).delete().then(function () {

                        });
                    });

                }

            });

            await database.collection('favorite_item').where('section_id', '==', sectionId).get().then(async function (favitemsnapshots) {
                if (favitemsnapshots.docs.length > 0) {
                    favitemsnapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('favorite_item').doc(item_data.id).delete().then(function () {
                        });
                    });
                }
            });

            await database.collection('favorite_vendor').where('section_id', '==', sectionId).get().then(async function (favvendorsnapshots) {
                if (favvendorsnapshots.docs.length > 0) {
                    favvendorsnapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('favorite_vendor').doc(item_data.id).delete().then(function () {
                        });
                    });
                }
            });

            await database.collection('brands').where('sectionId', '==', sectionId).get().then(async function (brandsnapshots) {
                if (brandsnapshots.docs.length > 0) {
                    brandsnapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('brands').doc(item_data.id).delete().then(function () {
                        });
                    });
                }
            });

            await database.collection('vendor_categories').where('section_id', '==', sectionId).get().then(async function (vendorcatsnapshots) {
                if (vendorcatsnapshots.docs.length > 0) {
                    vendorcatsnapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('vendor_categories').doc(item_data.id).delete().then(function () {
                        });
                    });
                }
            });

            await database.collection('vendor_products').where('section_id', '==', sectionId).get().then(async function (vendorproductsanpshots) {
                if (vendorproductsanpshots.docs.length > 0) {
                    vendorproductsanpshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('vendor_products').doc(item_data.id).delete().then(function () {
                        });
                    });
                }
            });

            await database.collection('vendors').where('section_id', '==', sectionId).get().then(async function (vendorsnapshots) {

                if (vendorsnapshots.docs.length > 0) {
                    vendorsnapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        var vendorID = item_data.id;
                        database.collection('vendors').doc(item_data.id).delete().then(async function () {
                            await database.collection('order_transactions').where('vendorId', '==', vendorID).get().then(async function (ordertransactionsanpshots) {
                                if (ordertransactionsanpshots.docs.length > 0) {
                                    ordertransactionsanpshots.docs.forEach((val) => {
                                        var item_data = val.data();
                                        database.collection('order_transactions').doc(item_data.id).delete().then(function () {

                                        });
                                    });

                                }
                            });
                            await database.collection('payouts').where('vendorID', '==', vendorID).get().then(async function (payoutssanpshots) {
                                if (payoutssanpshots.docs.length > 0) {
                                    payoutssanpshots.docs.forEach((val) => {
                                        var item_data = val.data();
                                        database.collection('payouts').doc(item_data.id).delete().then(function () {

                                        });
                                    });

                                }
                            });
                            await database.collection('users').where('vendorID', '==', vendorID).get().then(async function (userssanpshots) {
                                if (userssanpshots.docs.length > 0) {
                                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';
                                    userssanpshots.docs.forEach((val) => {
                                        var item_data = val.data();
                                        var dataObject = {
                                            "data": {
                                                "uid": item_data.id
                                            }
                                        };
                                        jQuery.ajax({
                                            url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
                                            method: 'POST',
                                            contentType: "application/json; charset=utf-8",
                                            data: JSON.stringify(dataObject),
                                            success: function (data) {
                                                console.log('Delete user success:', data.result);
                                                database.collection('users').doc(item_data.id).delete().then(function () {
                                                });
                                            },
                                            error: function (xhr, status, error) {
                                                var responseText = JSON.parse(xhr.responseText);
                                                console.log('Delete user error:', responseText.error);
                                            }
                                        });
                                    });
                                }
                            });

                            await database.collection('vendor_orders').where('vendorID', '==', vendorID).get().then(async function (vendorordersanpshots) {
                                if (vendorordersanpshots.docs.length > 0) {
                                    vendorordersanpshots.docs.forEach((val) => {
                                        var item_data = val.data();
                                        database.collection('vendor_orders').doc(item_data.id).delete().then(function () {

                                        });
                                    });

                                }
                            });
                            await database.collection('vendor_products').where('vendorID', '==', vendorID).get().then(async function (vendorproductsanpshots) {
                                if (vendorproductsanpshots.docs.length > 0) {
                                    vendorproductsanpshots.docs.forEach((val) => {
                                        var item_data = val.data();
                                        database.collection('vendor_products').doc(item_data.id).delete().then(function () {

                                        });
                                    });

                                }
                            });


                        });


                    });
                }
            });

            //Delete ondemand service data
            await database.collection('provider_categories').where('sectionId', '==', sectionId).get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {
                    snapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('provider_categories').doc(item_data.id).delete();
                    });
                }
            });

            await database.collection('provider_orders').where('sectionId', '==', sectionId).get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {
                    snapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('provider_orders').doc(item_data.id).delete();
                    });
                }
            });

            await database.collection('providers_coupons').where('sectionId', '==', sectionId).get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {
                    snapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('providers_coupons').doc(item_data.id).delete();
                    });
                }
            });

            await database.collection('providers_services').where('sectionId', '==', sectionId).get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {
                    snapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('providers_services').doc(item_data.id).delete();
                    });
                }
            });

            await database.collection('favorite_provider').where('section_id', '==', sectionId).get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {
                    snapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('favorite_provider').doc(item_data.id).delete();
                    });
                }
            });

            await database.collection('favorite_service').where('section_id', '==', sectionId).get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {
                    snapshots.docs.forEach((val) => {
                        var item_data = val.data();
                        database.collection('favorite_service').doc(item_data.id).delete();
                    });
                }
            });

        }
    </script>

@endsection