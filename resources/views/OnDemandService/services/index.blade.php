@extends('layouts.app')

@section('content')
    <div class="page-wrapper">


        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor PageTitle">{{trans('lang.ondemand_plural')}}
                    - {{trans('lang.service_plural')}}</h3>

            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.ondemand_plural')}}
                        - {{trans('lang.service_plural')}}</li>
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
                    @if($id!='')
                        <div class="resttab-sec">

                            <div class="menu-tab tabDiv">
                                <ul>
                                    <li><a href="{{route('providers.view', $id)}}">{{trans('lang.tab_basic')}}</a>
                                    </li>
                                    <li class="active"><a
                                                href="{{route('ondemand.services.index', $id)}}">{{trans('lang.services')}}</a>
                                    </li>
                                    <li>
                                    <li><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a>
                                    </li>
                                    <li>
                                    <li>
                                        <a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a>
                                    </li>
                                    <li>
                                    <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a>
                                    </li>
                                    <li>
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

                        <div class="card-body">

                            <div class="card-header">
                                <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{!! url()->current() !!}"><i
                                                    class="fa fa-list mr-2"></i>{{trans('lang.service_table')}}</a>
                                    </li>
                                    @if($id=='')
                                        <li class="nav-item">
                                            <a class="nav-link" href="{!! route('ondemand.services.create') !!}"><i
                                                        class="fa fa-plus mr-2"></i>{{trans('lang.service_create')}}</a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link"
                                               href="{!! route('ondemand.services.create','id='.$id) !!}"><i
                                                        class="fa fa-plus mr-2"></i>{{trans('lang.service_create')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>


                            <div class="table-responsive m-t-10">


                                <table id="serviceTable"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">

                                    <thead>

                                    <tr>

                                        <?php if (in_array('ondemand.services.delete', json_decode(@session('user_permissions')))) { ?>
                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                    class="col-3 control-label" for="is_active"
                                            ><a id="deleteAll" class="do_not_delete"
                                                href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> {{trans('lang.all')}}</a></label>
                                        </th>
                                        <?php } ?>
                                        <th>{{trans('lang.name')}}</th>
                                        <th>{{trans('lang.ondemand_category')}}</th>
                                        <th>{{trans('lang.section')}}</th>
                                        <th>{{trans('lang.provider')}}</th>
                                        <th>{{trans('lang.price')}}</th>
                                        <th>{{trans('lang.publish')}}</th>
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
        var id = "{{$id}}";

        var user_permissions = '<?php echo @session('user_permissions') ?>';
        user_permissions = JSON.parse(user_permissions);
        var checkDeletePermission = false;
        if ($.inArray('ondemand.services.delete', user_permissions) >= 0) {
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
        if (id != '') {
            var wallet_route = "{{route('users.walletstransaction','id')}}";
            $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID=' + id));
            $('.tabDiv').show();
            var ref = database.collection('providers_services').where('author', '==', id).orderBy('createdAt', 'desc');

        } else {
            $('.tabDiv').show();
            var ref = database.collection('providers_services').orderBy('createdAt', 'desc');

        }

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
            jQuery("#data-table_processing").show();
            if (id !== '') {
                getProviderNameForFilter(id);
            }
            var append_list = document.getElementById('append_list1');
            append_list.innerHTML = '';

            ref.get().then(async function (snapshots) {
                var html = '';
                html = await buildHTML(snapshots);

                jQuery("#data-table_processing").hide();
                if (html !== '') {
                    append_list.innerHTML = html;
                }

                $('#serviceTable').DataTable({
                    columnDefs: [
                        {targets: checkDeletePermission ? [0, 6, 7] : [5, 6],
                            type: 'currency',
                        },
                        {targets: (checkDeletePermission==true) ? 5 : 4 , type: "html-num-fmt"},
                        {orderable: false, targets: checkDeletePermission ? [0,6,7] : [0,5,6]}

                    ],
                    order: checkDeletePermission ? [[1, 'desc']] : [[0, 'desc']], // Assuming 1 is the correct column index for descending sorting
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
            var idOfProviderDetailPage = "{{$id}}";
            var route1 = '{{route("ondemand.services.edit",":id")}}';
            if (idOfProviderDetailPage != '') {
                route1 = route1.replace(':id', val.id + "?id=" + idOfProviderDetailPage);
            } else {
                route1 = route1.replace(':id', id);
            }

            if (checkDeletePermission) {
                html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                    'for="is_open_' + id + '" ></label></td>'; 
            }

            html = html + '<td><a href="' + route1 + '">' + val.title + '</a></td>';

            var categoryName = await getCategoryName(val.categoryId);
            html = html + '<td>' + categoryName + '</td>';

            if (val.hasOwnProperty("sectionId")) {
                var sectionName = await getSectionName(val.sectionId);
                html = html + '<td>' + sectionName + '</td>';
            } else {
                html = html + '<td></td>';
            }

            if (val.hasOwnProperty("author")) {
                var providerView = '{{route("providers.view",":id")}}';
                providerView = providerView.replace(':id', val.author);
                var providerName = await getProviderName(val.author);
                if (providerName == "") {
                    providerView = "javascript:void(0)";
                    providerName = "{{trans('lang.unknown')}}"
                }
                html = html + '<td><a href="' + providerView + '">' + providerName + '</a></td>';
            } else {
                html = html + '<td></td>';
            }
            
            if (val.disPrice == "0"){
                if (val.priceUnit == "Hourly") {
                    if (currencyAtRight) {
                        html = html + '<td data-html="true" data-order="' + val.price + '">' + parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency + '/hr</td>';
                    }else {
                        html = html + '<td data-html="true" data-order="' + val.price + '">' + currentCurrency + parseFloat(val.price).toFixed(decimal_degits) + '/hr</td>';
                    }
                } else {
                    if (currencyAtRight) {
                        html = html + '<td data-html="true" data-order="' + val.price + '">' + parseFloat(val.price).toFixed(decimal_degits) +  '' + currentCurrency + '</td>';
                    }else {
                        html = html + '<td data-html="true" data-order="' + val.price + '">' + currentCurrency + parseFloat(val.price).toFixed(decimal_degits) + '</td>';
                    }
                }
            }else {
                if (val.priceUnit == "Hourly") {
                    if (currencyAtRight) {
                        html = html + '<td data-html="true" data-order="' + val.disPrice + '">' + parseFloat(val.disPrice).toFixed(decimal_degits) + '' + currentCurrency + '/hr  <s>' + parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency + '/hr</s></td>';
                    } else {
                        html = html + '<td data-html="true" data-order="' + val.disPrice + '">' + '' + currentCurrency + parseFloat(val.disPrice).toFixed(decimal_degits) + '/hr  <s>' + currentCurrency + '' + parseFloat(val.price).toFixed(decimal_degits) + '/hr</s> </td>';
                    }
                } else {
                    if (currencyAtRight) {
                        html = html + '<td data-html="true" data-order="' + val.disPrice + '">' + parseFloat(val.disPrice).toFixed(decimal_degits) + '' + currentCurrency + '  <s>' + parseFloat(val.price).toFixed(decimal_degits) + '' + currentCurrency + '</s></td>';
                    } else {
                        html = html + '<td data-html="true" data-order="' + val.disPrice + '">' + '' + currentCurrency + parseFloat(val.disPrice).toFixed(decimal_degits) + ' <s>' + currentCurrency + '' + parseFloat(val.price).toFixed(decimal_degits) + '</s> </td>';
                    }
                }
            }


            if (val.publish) {
                html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
            } else {
                html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
            }

            html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
            if (checkDeletePermission) {
                html = html + '<a id="' + val.id + '" name="service-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
            }
            html = html + '</td>';

            html = html + '</tr>';

            return html;
        }

        async function getSectionName(sectionId) {
            let sectionName = '';
            if (sectionId != '' && sectionId != null) {
                let sectionDoc = await database.collection('sections').doc(sectionId).get();
                if (sectionDoc.exists) {
                    let sectionData = sectionDoc.data();
                    sectionName = sectionData.name;
                }
            }
            return sectionName;
        }

        async function getProviderName(providerId) {
            let providerName = '';
            if (providerId != '' && providerId != null) {
                let providerDoc = await database.collection('users').doc(providerId).get();
                if (providerDoc.exists) {
                    let providerData = providerDoc.data();
                    providerName = providerData.firstName + ' ' + providerData.lastName;
                }
            }
            return providerName;
        }

        async function getCategoryName(categoryId) {
            let categoryName = '';
            if (categoryId != '' && categoryId != null) {
                let categoryDoc = await database.collection('provider_categories').doc(categoryId).get();
                if (categoryDoc.exists) {
                    let categoryData = categoryDoc.data();
                    categoryName = categoryData.title;
                }
            }
            return categoryName;
        }

        $(document).on("click", "input[name='publish']", function (e) {
            var ischeck = $(this).is(':checked');
            var id = this.id;
            var publish = ischeck ? true : false;
            database.collection('providers_services').doc(id).update({
                'publish': publish
            });
        });

        $(document).on("click", "a[name='service-delete']", function (e) {
            var id = this.id;
            database.collection('providers_services').doc(id).delete().then(function (result) {
                deleteServiceData(id);
                setTimeout(function() {
                window.location.reload();
            }, 3000);
            });
        });

        $("#is_active").click(function () {
            $("#serviceTable .is_open").prop('checked', $(this).prop('checked'));
        });

        $("#deleteAll").click(function () {
            if ($('#serviceTable .is_open:checked').length) {
                if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                    jQuery("#data-table_processing").show();
                    $('#serviceTable .is_open:checked').each(function () {
                        var dataId = $(this).attr('dataId');
                        database.collection('providers_services').doc(dataId).delete().then(function () {
                            deleteServiceData(dataId);
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

        async function getProviderNameForFilter(providerId) {
            await database.collection('users').where('id', '==', providerId).get().then(async function (snapshots) {
                var providerData = snapshots.docs[0].data();
                providerName = providerData.firstName + ' ' + providerData.lastName;
                $('.PageTitle').html("{{trans('lang.service_plural')}} - " + providerName);
            });

        }
        async function deleteServiceData(serviceId){
            await database.collection('favorite_service').where('service_id', '==', serviceId).get().then(async function(snapshotsItem) {

            if (snapshotsItem.docs.length > 0) {
                snapshotsItem.docs.forEach((temData) => {
                    var item_data = temData.data();

                    database.collection('favorite_service').doc(item_data.id).delete().then(function() {

                    });
                });
            }

        });
        }
    </script>


@endsection
