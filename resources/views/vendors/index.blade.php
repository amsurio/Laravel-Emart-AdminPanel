@extends('layouts.app')

@section('content')

    <div class="page-wrapper">

        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor">{{trans('lang.vendor_plural')}}</h3>

            </div>

            <div class="col-md-7 align-self-center">

                <ol class="breadcrumb">

                    <li class="bhttps://emartadmin.siswebapp.com/rental_orders/edit/66192f928b320readcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.vendor_table')}}</li>

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
                                                class="fa fa-list mr-2"></i>{{trans('lang.vendors_table')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('vendors.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.create_vendor')}}</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">


                            <div id="users-table_filter" class="pull-right">
                                <div class="row">

                                </div>
                                <div class="col-md-3 ml-auto">
                                    <select id="section_id" class="form-control allModules" style="width:100%"
                                            onchange="clickLink(this.value)">
                                        <option value="">{{trans('lang.select')}} {{trans('lang.section_plural')}}
                                        </option>
                                    </select>
                                    <p style="color: red;font-size: 13px;">
                                        {{trans('lang.rental_parcel_cab_service_are_not')}}</p>
                                </div>
                            </div>

                            <div class="table-responsive m-t-10">


                                <table id="storeTable"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">

                                    <thead>

                                    <tr>
                                <?php if (in_array('stores.delete', json_decode(@session('user_permissions')))) { ?>

                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                    class="col-3 control-label" for="is_active"><a id="deleteAll"
                                                                                                   class="do_not_delete"
                                                                                                   href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a></label>
                                        </th>
                                    <?php }?>
                                        <th>{{trans('lang.actions')}}</th>
                                        <th>{{trans('lang.vendor_image')}}</th>

                                        <th>{{trans('lang.vendor_name')}}</th>
                                        <th>{{trans('lang.section')}}</th>

                                        <th>{{trans('lang.vendor_phone')}}</th>
                                        <th>{{trans('lang.date')}}</th>

                                        <th>{{trans('lang.wallet_history')}}</th>
                                        <th>{{trans('lang.item')}}</th>
                                        <th>{{trans('lang.order_plural')}}</th>
                                        <th>{{trans('lang.timing')}}</th>


                                    </tr>

                                    </thead>

                                    <tbody id="append_vendors">


                                    </tbody>

                                </table>
                            </div>

                        </div>

                        <!-- Popup -->

                        <div class="modal fade" id="create_vendor" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered notification-main" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">{{trans('lang.copy_vendor')}}
                                            <span id="vendor_title_lable"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="data-table_processing2"
                                             class="dataTables_processing panel panel-default"
                                             style="display: none;">{{trans('lang.processing')}}
                                        </div>
                                        <div class="error_top"></div>
                                        <!-- Form -->
                                        <div class="form-row">
                                            <div class="col-md-12 form-group">
                                                <label class="form-label">{{trans('lang.first_name')}}</label>
                                                <div class="input-group">
                                                    <input placeholder="Name" type="text" id="user_name"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="form-label">{{trans('lang.last_name')}}</label>
                                                <div class="input-group">
                                                    <input placeholder="Name" type="text" id="user_last_name"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label class="form-label">{{trans('lang.vendor_title')}}</label>
                                                <div class="input-group">
                                                    <input placeholder="Vendor Title" type="text" id="vendor_title"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group"><label
                                                        class="form-label">{{trans('lang.email')}}</label><input
                                                        placeholder="Email" value="" id="user_email" type="text"
                                                        class="form-control"></div>
                                            <div class="col-md-12 form-group"><label
                                                        class="form-label">{{trans('lang.password')}}</label><input
                                                        placeholder="Password" id="user_password" type="password"
                                                        class="form-control">
                                            </div>

                                        </div>
                                        <!-- Form -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                                id="create_vendor_submit">{{trans('lang.create')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Popup -->

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
        var pagesizes = 0;
        var end = null;
        var endarray = [];
        var start = null;
        var user_number = [];
        var user_permissions = '<?php echo @session('user_permissions') ?>';

            user_permissions = JSON.parse(user_permissions);

            var checkDeletePermission = false;
            var checkCopyPermission=false;
            if ($.inArray('stores.delete', user_permissions) >= 0) {
                checkDeletePermission = true;
            }
            if($.inArray('stores.copy',user_permissions) >= 0){
                checkCopyPermission = true;
            }
        var section_id = getCookie('section_id');
        if (section_id != '') {
            var refData = database.collection('vendors').where('section_id', '==', section_id);

        } else {
            var refData = database.collection('vendors');

        }

        var ref = refData.orderBy('createdAt', 'desc');
        var append_list = '';

        var userData = [];
        var vendorData = [];
        var vendorProducts = [];

        var placeholderImage = '';
        var placeholder = database.collection('settings').doc('placeHolderImage');
        var ref_sections = database.collection('sections');

        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        })

        $(document).ready(function () {

            jQuery("#data-table_processing").show();

            append_list = document.getElementById('append_vendors');
            append_list.innerHTML = '';
            ref.get().then(async function (snapshots) {
                var html = '';
                html = await buildHTML(snapshots);
                jQuery("#data-table_processing").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.push(snapshots.docs[0]);
                    if (snapshots.docs.length < pagesizes) {
                        jQuery("#data-table_paginate").hide();
                    }
                }
                $('#storeTable').DataTable({
                    order: [],
                    columnDefs: [{
                        targets: (checkDeletePermission==true) ? 6 : 5,
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                        {orderable: false,
                         targets: (checkDeletePermission==true) ? [0, 1, 2] : [0,1]},
                    ],
                    order: (checkDeletePermission==true) ? [6, "desc"] : [5,"desc"],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                });

            });

            ref_sections.get().then(async function (snapshots) {

                snapshots.docs.forEach((listval) => {
                    var data = listval.data();

                    if (data.serviceTypeFlag == "delivery-service" || data.serviceTypeFlag == "ecommerce-service") {
                        $('#section_id').append($("<option></option>")
                            .attr("value", data.id)
                            .text(data.name));
                    }

                })

                $('#section_id').val(section_id);
            })

        })

        async function buildHTML(snapshots) {
            var html = '';
            await Promise.all(snapshots.docs.map(async (listval) => {
                var val = listval.data();
                if(val.title != ''){
                    var getData = await getListData(val);
                    html += getData;
                }

            }));
            return html;
        }

        async function getListData(val) {

            var html = '';
            var number = [];
            html = html + '<tr>';
            newdate = '';
            var id = val.id;
            var route1 = '{{route("vendors.edit",":id")}}';
            route1 = route1.replace(':id', id);

            var route_view = '{{route("vendors.view",":id")}}';
            route_view = route_view.replace(':id', id);
            if(checkDeletePermission){
            html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '" author="' + val.author + '"><label class="col-3 control-label"\n' +
                'for="is_open_' + id + '" ></label></td>';
            }
            html=html+'<td class="vendor-action-btn">';
            if(checkCopyPermission){
             html = html + '<a href="javascript:void(0)" vendor_id="' + val.id + '" author="' + val.author + '" name="vendor-clone"><i class="fa fa-clone"></i></a>';
            }
            html=html+'<a href="' + route_view + '"><i class="fa fa-eye"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
            if(checkDeletePermission){
            html=html+'<a id="' + val.id + '" author="' + val.author + '" name="vendor-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
            }
            html=html+'</td>';

            if (val.photo != '') {
                if(val.photo){
                    photo=val.photo;
                }else{
                    photo=placeholderImage;
                }
                html = html + '<td><img alt="" width="100%" style="width:70px;height:70px;" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image"></td>';

            } else {

                html = html + '<td><img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image"></td>';
            }


            html = html + '<td data-url="' + route_view + '" class="redirecttopage">' + val.title + '</td>';  
 
            if (val.section_id) {

                const section = await getSectionName(val.section_id);
                html = html + '<td class="sectionName_' + val.section_id + '">' + section + '</td>';

            } else {
                html = html + '<td></td>';

            }

            const phone = userPhone(val.author);
            if (val.hasOwnProperty('phonenumber')) {
                html = html + '<td>' + val.phonenumber + '</td>';
            } else {
                html = html + '<td></td>';
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

            var payoutRequests = '{{route("users.walletstransaction",":id")}}';
            payoutRequests = payoutRequests.replace(':id', 'storeID='+val.author);

            html = html + '<td><a href="'+payoutRequests+'">{{trans("lang.wallet_history")}}</a></td>';


            var totalProduct = await getTotalProduct(val.id);
            var vendorId = val.id;
            var url = '{{route("vendors.items",":id")}}';
            url1 = url.replace(":id", vendorId);
            html = html + '<td ><a class="producttotal_' + val.id + '" href="' + url1 + '">' + totalProduct + '</a></td>';
            var totalOrders = await getTotalOrders(val.id);

            var url = '{{route("vendors.orders",":id")}}';
            url2 = url.replace(":id", vendorId);
            html = html + '<td><a class="ordertotal_' + val.id + '" href="' + url2 + '" >' + totalOrders + '</a></td>';
            var opentime = '';
            var closetime = '';
            if (val.opentime != undefined) {
                opentime = val.opentime;
            }
            if (val.closetime != undefined) {
                closetime = val.closetime;
            }
            html = html + '<td>' + opentime + "-" + closetime + '</td>';
            var active = val.isActive;
            html = html + '</tr>';
            return html;
        }

        async function getSectionName(sectionId) {
            var sectionName = '';
            await database.collection('sections').where("id", "==", sectionId).get().then(async function (snapshots) {

                if (snapshots.docs.length > 0) {
                    var data = snapshots.docs[0].data();
                    sectionName = data.name;

                }
            });
            return sectionName;
        }

        async function getTotalProduct(id) {
            var totalProduct = '';
            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function (productSnapshots) {
                totalProduct = productSnapshots.docs.length;
            });
            return totalProduct;
        }

        async function getTotalOrders(id) {
            var order_total = '';
            await database.collection('vendor_orders').where('vendorID', '==', id).get().then(async function (productSnapshots) {
                order_total = productSnapshots.docs.length;
            });
            return order_total;
        }


        $("#is_active").click(function () {
            $("#storeTable .is_open").prop('checked', $(this).prop('checked'));

        });

        $("#deleteAll").click(function () {
            if ($('#storeTable .is_open:checked').length) {
                if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                    jQuery("#data-table_processing").show();

                    $('#storeTable .is_open:checked').each(function () {
                            var dataId = $(this).attr('dataId');
                            var author = $(this).attr('author');

                                database.collection('vendors').doc(dataId).delete().then(function () {
                                    const getStoreName = deleteStoreData(dataId);
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 7000);
                                });


                        }
                    );

                }
            } else {
                alert("{{trans('lang.select_delete_alert')}}");
            }
        });

        async function deleteStoreData(storeId) {

            await database.collection('users').where('vendorID', '==', storeId).get().then(async function (userssanpshots) {

                if (userssanpshots.docs.length > 0) {

                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID') ?>';

                    var item_data = userssanpshots.docs[0].data();
                    var dataObject = {"data": {"uid": item_data.id}};

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
                }
            });            

            await database.collection('vendor_products').where('vendorID', '==', storeId).get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {
                    snapshots.docs.forEach((listval) => {
                        var data = listval.data();

                        database.collection('vendor_products').doc(data.id).delete().then(function () {

                        });
                    });
                }
            });

            await database.collection('vendor_orders').where('vendorID', '==', storeId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();

                        database.collection('vendor_orders').doc(item_data.id).delete().then(function () {

                        });
                    });
                }

            });

       
            await database.collection('items_review').where('VendorId', '==', storeId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();

                        database.collection('items_review').doc(item_data.Id).delete().then(function () {

                        });
                    });
                }

            });

            await database.collection('coupons').where('vendorID', '==', storeId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();

                        database.collection('coupons').doc(item_data.id).delete().then(function () {

                        });
                    });
                }

            });
            await database.collection('favorite_vendor').where('store_id','==',storeId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('favorite_vendor').doc(item_data.id).delete().then(function () {

                    });
                });
            }
            })
            await database.collection('payouts').where('vendorID', '==', storeId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();

                        database.collection('payouts').doc(item_data.id).delete().then(function () {

                        });
                    });
                }

            });


        }

        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });

        async function userPhone(author) {
            var userPhones = '';
            await database.collection('users').where("id", "==", author).get().then(async function (snapshotss) {

                if (snapshotss.docs[0]) {
                    var user = snapshotss.docs[0].data();
                    userPhones = user.phoneNumber;
                    if (user.isActive) {

                        jQuery(".active_vendor_" + author + " span").addClass('badge-danger');
                        jQuery(".active_vendor_" + author + " span").text('No');

                    } else {
                        jQuery(".active_vendor_" + author + " span").addClass('badge-success');
                        jQuery(".active_vendor_" + author + " span").text('Yes');
                    }

                } else {
                    jQuery(".phone_" + author).html('');
                    jQuery(".active_vendor_" + author + " span").addClass('badge-success');
                    jQuery(".active_vendor_" + author + " span").text('Yes');
                }
            });
            return userPhones;
        }

        function clickpage(value) {
            setCookie('pagesizes', value, 30);
            location.reload();
        }


        $(document).on("click", "a[name='vendor-delete']", function (e) {
            var id = this.id;
            var author = $(this).attr('author');
            jQuery("#data-table_processing").show();
                database.collection('vendors').doc(id).delete().then(function () {
                deleteStoreData(id).then(function () {
                    setTimeout(function () {
                        window.location.reload();
                    }, 9000);
                });
                });
        });

        function clickLink(value) {
            setCookie('section_id', value, 30);
            location.reload();
        }

        $(document).on("click", "a[name='vendor-clone']", async function (e) {

            var id = $(this).attr('vendor_id');
            var author = $(this).attr('author');

            await database.collection('users').doc(author).get().then(async function (snapshotsusers) {
                userData = snapshotsusers.data();
            });
            await database.collection('vendors').doc(id).get().then(async function (snapshotsvendors) {
                vendorData = snapshotsvendors.data();
            });
            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function (snapshotsproducts) {
                vendorProducts = [];
                snapshotsproducts.docs.forEach(async (product) => {
                    vendorProducts.push(product.data());
                });

            });


            if (userData && vendorData) {
                jQuery("#create_vendor").modal('show');
                jQuery("#vendor_title_lable").text(vendorData.title);
            }
        });


        $(document).on("click", "#create_vendor_submit", async function (e) {

            var vendor_id = database.collection("tmp").doc().id;

            if (userData && vendorData) {

                var vendor_title = jQuery("#vendor_title").val();
                var userFirstName = jQuery("#user_name").val();
                var userLastName = jQuery("#user_last_name").val();
                var email = jQuery("#user_email").val();
                var password = jQuery("#user_password").val();

                if (userFirstName == '') {

                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{trans('lang.user_name_required')}}</p>");
                    window.scrollTo(0, 0);

                } else if (userLastName == '') {

                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{trans('lang.user_last_name_required')}}</p>");
                    window.scrollTo(0, 0);

                } else if (vendor_title == '') {

                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{trans('lang.vendor_title_required')}}</p>");
                    window.scrollTo(0, 0);

                } else if (email == '') {

                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{trans('lang.user_email_required')}}</p>");
                    window.scrollTo(0, 0);
                } else if (password == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{trans('lang.enter_owners_password_error')}}</p>");
                    window.scrollTo(0, 0);
                } else {

                    jQuery("#data-table_processing2").show();

                    firebase.auth().createUserWithEmailAndPassword(email, password).then(async function (firebaseUser) {
                        var user_id = firebaseUser.user.uid;

                        userData.email = email;
                        userData.firstName = userFirstName;
                        userData.lastName = userLastName;
                        userData.id = user_id;
                        userData.vendorID = vendor_id;
                        userData.createdAt = createdAt;
                        userData.wallet_amount = 0;

                        vendorData.author = user_id;
                        vendorData.authorName = userFirstName + ' ' + userLastName;
                        vendorData.title = vendor_title;
                        vendorData.id = vendor_id;
                        coordinates = new firebase.firestore.GeoPoint(vendorData.latitude, vendorData.longitude);
                        vendorData.coordinates = coordinates;
                        vendorData.createdAt = createdAt;

                        await database.collection('users').doc(user_id).set(userData).then(async function (result) {

                            await geoFirestore.collection('vendors').doc(vendor_id).set(vendorData).then(async function (result) {
                                var count = 0;
                                await vendorProducts.forEach(async (product) => {
                                    var product_id = await database.collection("tmp").doc().id;
                                    product.id = product_id;
                                    product.vendorID = vendor_id;
                                    await database.collection('vendor_products').doc(product_id).set(product).then(function (result) {
                                        count++;
                                        if (count == vendorProducts.length) {
                                            jQuery("#data-table_processing2").hide();
                                            alert('Successfully created.');
                                            jQuery("#create_vendor").modal('hide');
                                            location.reload();
                                        }
                                    });

                                });


                            });
                        })

                    }).catch(function (error) {
                        $(".error_top").show();
                        jQuery("#data-table_processing2").hide();
                        $(".error_top").html("");
                        $(".error_top").append("<p>" + error + "</p>");
                    });


                }
            }
        });

    </script>

@endsection