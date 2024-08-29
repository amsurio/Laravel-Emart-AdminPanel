@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.parcel_plural')}} {{trans('lang.coupon_plural')}} <span
                        class="storeTitle"></span></h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.parcel_plural')}} {{trans('lang.coupon_table')}}</li>

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
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.parcel_plural')}}
                                    {{trans('lang.coupon_table')}}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('parcel_coupons.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.coupon_create')}} </a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">

                    <div class="table-responsive m-t-10">

                        <table id="example24"
                               class="display nowrap table table-hover table-striped table-bordered table table-striped"
                               cellspacing="0" width="100%">

                            <thead>

                            <tr>

                                <th>{{trans('lang.coupon_code')}}</th>

                                <th>{{trans('lang.coupon_discount')}}</th>

                                <th>{{trans('lang.coupon_description')}}</th>

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

if ($.inArray('parcel.coupons.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
}

var database = firebase.firestore();
var offest = 1;
var pagesize = 10;
var end = null;
var endarray = [];
var start = null;

var ref = database.collection('parcel_coupons');

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
        $('#example24').DataTable({
                
                order: [],
                columnDefs: [{
                         targets: 5,
                         type: 'date',
                        render: function(data) {
                            return data;
                        }
                    },
                    {orderable: false, targets: [4, 5]},
                ],
                order: [3,"desc"],
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
    var getData = await getListData(val);
    
    html += getData;
}));
return html;
}
async function getListData(val) {

    var html = '';
    var number = [];
    var count = 0;

        html = html + '<tr>';
        newdate = '';
        if (currencyAtRight) {
            if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = parseFloat(val.discount).toFixed(decimal_degits) + "" + currentCurrency;
            }
        } else {
            if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = currentCurrency + "" + parseFloat(val.discount).toFixed(decimal_degits);
            }
        }
        var id = val.id;
        var route1 = '{{route("parcel_coupons.edit",":id")}}';
        route1 = route1.replace(':id', id);

        html = html + '<td  data-url="' + route1 + '" class="redirecttopage">' + val.code + '</td>';
        html = html + '<td>' + discount_price + '</td>';
        html = html + '<td>' + val.description + '</td>';
        var date = '';
        var time = '';
        if (val.hasOwnProperty("expiresAt")) {

            try {
                date = val.expiresAt.toDate().toDateString();
                time = val.expiresAt.toDate().toLocaleTimeString('en-US');
            } catch (err) {

            }
            html = html + '<td>' + date + ' ' + time + '</td>';
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

$(document).on("click","input[name='isEnabled']",function(e){
    var ischeck=$(this).is(':checked');
    var id=this.id;
    if(ischeck){
        database.collection('parcel_coupons').doc(id).update({'isEnabled': true}).then(function (result) {

        });
    }else{
        database.collection('parcel_coupons').doc(id).update({'isEnabled': false}).then(function (result) {

        });
    }

});




$(document).on("click", "a[name='coupon_delete_btn']", function (e) {
    var id = this.id;
    database.collection('parcel_coupons').doc(id).delete().then(function () {
        window.location = "{{! url()->current() }}";
    });
});

</script>

@endsection
