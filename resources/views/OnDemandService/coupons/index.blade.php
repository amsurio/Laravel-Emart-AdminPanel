@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor PageTitle">{{trans('lang.ondemand_plural')}} - {{trans('lang.coupon_plural')}} <span class="storeTitle"></span></h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.ondemand_plural')}} - {{trans('lang.coupon_plural')}}</li>

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
                                <li class="active"><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a></li>
                                
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
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.coupon_table')}}</a>
                            </li>
                            @if($id=='')
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('ondemand.coupons.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.coupon_create')}}</a>
                                </li>
                             @else
                             <li class="nav-item">
                                    <a class="nav-link" href="{!! route('ondemand.coupons.create','id='.$id) !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.coupon_create')}}</a>
                                </li>
                             @endif   
                           
                        </ul>
                    </div>
                    <div class="card-body">
                        

                        <div class="table-responsive m-t-10">

                            <table id="couponTable"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>
                                    <?php if (in_array('ondemand.coupons.delete', json_decode(@session('user_permissions')))) { ?>

                                    <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active"
                                        ><a id="deleteAll" class="do_not_delete"
                                            href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                        <?php }?>
                                    <th>{{trans('lang.coupon_code')}}</th>
                                    <th>{{trans('lang.coupon_discount')}}</th>
                                    <th>{{trans('lang.section')}}</th>
                                    <th>{{trans('lang.provider')}}</th>
                                    <th>{{trans('lang.coupon_privacy')}}</th>
                                    <th>{{trans('lang.coupon_expires_at')}}</th>
                                    <th>{{trans('lang.coupon_enabled')}}</th>
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
    if ($.inArray('ondemand.coupons.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
    }

    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];
    var id="{{$id}}";
    if(id!=''){
        $('.tabDiv').show();
        var ref = database.collection('providers_coupons').where('providerId','==',id);
    }else{
        $('.tabDiv').hide();
        var ref = database.collection('providers_coupons');
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

    var append_list = '';

    $(document).ready(function () {
        if(id!=''){
            var wallet_route = "{{route('users.walletstransaction','id')}}";
            $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID='+id));

            getProviderNameForFilter(id);
        }
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

            $('#couponTable').DataTable({

                order: [],
                columnDefs: [{
                    targets: (checkDeletePermission==true) ? 6 : 5,
                    type: 'date',
                    render: function (data) {
                        return data;
                    }
                },
                    {orderable: false, targets: (checkDeletePermission==true) ? [0, 7, 8] : [6, 7]},
                ],
                order: (checkDeletePermission==true) ? [1, "asc"] : [0,"asc"],
                "language": {
                    "zeroRecords": "{{trans('lang.no_record_found')}}",
                    "emptyTable": "{{trans('lang.no_record_found')}}"
                },
                responsive: true,
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
        var discount_price = '';

        html = html + '<tr>';

        if (currencyAtRight) {
            if (val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = parseFloat(val.discount).toFixed(decimal_degits) + "" + currentCurrency;
            }
        } else {
            if (val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = currentCurrency + "" + parseFloat(val.discount).toFixed(decimal_degits);
            }
        }

        var id = val.id;
        var route1 = '{{route("ondemand.coupons.edit",":id")}}';
        var idOfProviderDetailPage="<?php echo $id; ?>";
        if(idOfProviderDetailPage!=''){
            route1 = route1.replace(':id', val.id+"?id="+idOfProviderDetailPage);
        }else{
        route1 = route1.replace(':id', id);
        }
       
        if(checkDeletePermission){
              html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>';
        }
        html = html + '<td  data-url="' + route1 + '" class="redirecttopage">' + val.code + '</td>';
        html = html + '<td>' + discount_price + '</td>';

        if (val.hasOwnProperty("sectionId")) {
            var sectionName = await getSectionName(val.sectionId);
            html = html + '<td>' + sectionName + '</td>';
        } else {
            html = html + '<td></td>';
        }
        
        if (val.hasOwnProperty("providerId")) {
            var providerName = await getProviderName(val.providerId);
            var providerView = '{{route("providers.view",":id")}}';
            providerView = providerView.replace(':id', val.providerId);
             if(providerName==""){
                providerView="javascript:void(0)";
                providerName="{{trans('lang.unknown')}}"
            }
            html = html + '<td><a href="' + providerView + '">' + providerName + '</a></td>';
        } else {
            html = html + '<td></td>';
        }

        if (val.hasOwnProperty('isPublic') && val.isPublic) {
            html = html + '<td class="success"><span class="badge badge-success py-2 px-3">{{trans("lang.public")}}</sapn></td>';
        } else {
            html = html + '<td class="danger"><span class="badge badge-danger py-2 px-3">{{trans("lang.private")}}</sapn></td>';
        }
        var date = '';
        var time = '';
        if (val.hasOwnProperty("expiresAt")) {
            try {
                date = val.expiresAt.toDate().toDateString();
                time = val.expiresAt.toDate().toLocaleTimeString('en-US');
            } catch (err) {

            }
            html = html + '<td class="dt-time">' + date + ' ' + time + '</td>';
        } else {
            html = html + '<td></td>';
        }
        if (val.isEnabled) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isEnabled"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isEnabled"><span class="slider round"></span></label></td>';
        }

        html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
        if(checkDeletePermission){
            html=html+'<a id="' + val.id + '" name="coupon_delete_btn" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        }
        html=html+'</td>';

        html = html + '</tr>';
        count = count + 1;
        
        return html;
    }

    $(document).on("click", "input[name='isEnabled']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        var isEnabled = ischeck ? true : false;
        database.collection('providers_coupons').doc(id).update({
            'isEnabled': isEnabled
        });
    });

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
                providerName = providerData.firstName +' '+providerData.lastName;
            }
        }
        return providerName;
    }

    $("#is_active").click(function () {
        $("#couponTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAll").click(function () {
        if ($('#couponTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#couponTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('providers_coupons').doc(dataId).delete().then(function () {
                        window.location.reload();
                    });

                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    $(document).on("click", "a[name='coupon_delete_btn']", function (e) {
        var id = this.id;
        jQuery("#data-table_processing").show();
        database.collection('providers_coupons').doc(id).delete().then(function () {
            window.location = "{{! url()->current() }}";
        });
    });
async function getProviderNameForFilter(providerId){
        await database.collection('users').where('id', '==', providerId).get().then(async function (snapshots) {
            var providerData = snapshots.docs[0].data();
            providerName = providerData.firstName+' '+providerData.lastName;
            $('.PageTitle').html("{{trans('lang.coupon_plural')}} - " + providerName);
        });

}

</script>

@endsection
