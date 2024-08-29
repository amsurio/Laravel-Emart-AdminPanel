@extends('layouts.app')

@section('content')
<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor PageTitle">{{trans('lang.ondemand_plural')}} - {{trans('lang.booking_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.ondemand_plural')}} - {{trans('lang.booking_plural')}}</li>
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
                                <li ><a href="{{route('providers.view', $id)}}">{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li><a href="{{route('ondemand.services.index', $id)}}">{{trans('lang.services')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a></li>
                                <li>
                                <li class="active"><a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a></li>
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
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link new_booking_list active" data-toggle="pill"
                                   href="#new_booking_list" role="tab">{{trans('lang.new_bookings')}}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link today_booking_list" data-toggle="pill"
                                   href="#today_booking_list"
                                   role="tab">{{trans('lang.today')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link upcoming_booking_list" data-toggle="pill"
                                   href="#upcoming_booking_list"
                                   role="tab">{{trans('lang.upcoming')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link completed_booking_list" data-toggle="pill"
                                   href="#completed_booking_list"
                                   role="tab">{{trans('lang.completed')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link canceled_booking_list" data-toggle="pill"
                                   href="#canceled_booking_list"
                                   role="tab">{{trans('lang.canceled')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                         <div id="users-table_filter" class="pull-right">
                            <div class="row">
                                <div class="col-sm-9">
                                </div>
                                <div class="col-sm-3 sectionDiv">
                                    <select id="section_id" class="form-control allModules" style="width:100%"
                                            onchange="clickLink(this.value)">
                                        <option value="">{{trans('lang.select')}} {{trans('lang.section_plural')}}
                                        </option>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="new_booking_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="newBookingTable"
                                           class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <?php if (in_array('ondemand.bookings.delete', json_decode(@session('user_permissions')))) { ?>
                                            <th class="delete-all"><input type="checkbox" id="del_new"><label
                                                        class="col-3 control-label" for="del_new"
                                                ><a id="deleteAllNew" class="do_not_delete"
                                                    href="javascript:void(0)"><i
                                                                class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                            <?php } ?>
                                            <th>{{trans('lang.booking_id')}}</th>
                                            <th>{{trans('lang.order_user_id')}}</th>
                                            <th>{{trans('lang.status')}}</th>
                                            <th>{{trans('lang.amount')}}</th>
                                            <th>{{trans('lang.booking_date')}}</th>
                                            <th>{{trans('lang.created_at')}}</th>
                                             <th>{{trans('lang.section')}}</th>
                                            <th>{{trans('lang.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="new_bookings_row"></tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="today_booking_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="todayBookingTable"
                                           class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <?php if (in_array('ondemand.bookings.delete', json_decode(@session('user_permissions')))) { ?>
                                            <th class="delete-all"><input type="checkbox" id="del_today"><label
                                                        class="col-3 control-label" for="del_today"
                                                ><a id="deleteAllToday" class="do_not_delete"
                                                    href="javascript:void(0)"><i
                                                                class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                            <?php } ?>
                                            <th>{{trans('lang.booking_id')}}</th>
                                            <th>{{trans('lang.order_user_id')}}</th>
                                            <th>{{trans('lang.status')}}</th>
                                            <th>{{trans('lang.amount')}}</th>
                                            <th>{{trans('lang.booking_date')}}</th>
                                            <th>{{trans('lang.created_at')}}</th>
                                            <th>{{trans('lang.section')}}</th>
                                            <th>{{trans('lang.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="today_bookings_row"></tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="upcoming_booking_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="upcomingBookingTable"
                                           class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <?php if (in_array('ondemand.bookings.delete', json_decode(@session('user_permissions')))) { ?>
                                            <th class="delete-all"><input type="checkbox" id="del_upcoming"><label
                                                        class="col-3 control-label" for="del_upcoming"
                                                ><a id="deleteAllUpcoming" class="do_not_delete"
                                                    href="javascript:void(0)"><i
                                                                class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                            <?php } ?>
                                            <th>{{trans('lang.booking_id')}}</th>
                                            <th>{{trans('lang.order_user_id')}}</th>
                                            <th>{{trans('lang.status')}}</th>
                                            <th>{{trans('lang.amount')}}</th>
                                            <th>{{trans('lang.booking_date')}}</th>
                                            <th>{{trans('lang.created_at')}}</th>
                                            <th>{{trans('lang.section')}}</th>
                                            <th>{{trans('lang.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="upcoming_bookings_row"></tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="completed_booking_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="completedBookingTable"
                                           class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <?php if (in_array('ondemand.bookings.delete', json_decode(@session('user_permissions')))) { ?>
                                            <th class="delete-all"><input type="checkbox" id="del_completed"><label
                                                        class="col-3 control-label" for="del_completed"
                                                ><a id="deleteAllCompleted" class="do_not_delete"
                                                    href="javascript:void(0)"><i
                                                                class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                            <?php } ?>
                                            <th>{{trans('lang.booking_id')}}</th>
                                            <th>{{trans('lang.order_user_id')}}</th>
                                            <th>{{trans('lang.status')}}</th>
                                            <th>{{trans('lang.amount')}}</th>
                                            <th>{{trans('lang.booking_date')}}</th>
                                            <th>{{trans('lang.created_at')}}</th>
                                            <th>{{trans('lang.section')}}</th>
                                            <th>{{trans('lang.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="completed_bookings_row"></tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="canceled_booking_list" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="cancelBookingTable"
                                           class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <?php if (in_array('ondemand.bookings.delete', json_decode(@session('user_permissions')))) { ?>
                                            <th class="delete-all"><input type="checkbox" id="del_canceled"><label
                                                        class="col-3 control-label" for="del_canceled"
                                                ><a id="deleteAllCancel" class="do_not_delete"
                                                    href="javascript:void(0)"><i
                                                                class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                            <?php } ?>
                                            <th>{{trans('lang.booking_id')}}</th>
                                            <th>{{trans('lang.order_user_id')}}</th>
                                            <th>{{trans('lang.status')}}</th>
                                            <th>{{trans('lang.amount')}}</th>
                                            <th>{{trans('lang.booking_date')}}</th>
                                            <th>{{trans('lang.created_at')}}</th>
                                            <th>{{trans('lang.section')}}</th>
                                            <th>{{trans('lang.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="cancel_bookings_row"></tbody>

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

</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript">

    var user_permissions = '<?php echo @session('user_permissions') ?>';
    user_permissions = JSON.parse(user_permissions);
    var checkDeletePermission = false;
    if ($.inArray('ondemand.bookings.delete', user_permissions) >= 0) {
        checkDeletePermission = true;
    }

    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;

    var append_list = '';
    var user_number = [];
    var id="{{$id}}";
    var  currentDateTime = new Date();
    var startOfToday = new Date(currentDateTime);
    startOfToday.setHours(0, 0, 0, 0);
    var endOfToday = new Date(currentDateTime);
    endOfToday.setHours(23, 59, 59, 999);
    var startTimestamp = firebase.firestore.Timestamp.fromDate(startOfToday);
    var endTimestamp = firebase.firestore.Timestamp.fromDate(endOfToday);
    if(id!=''){
        var wallet_route = "{{route('users.walletstransaction','id')}}";
        $(".wallet_transaction").attr("href", wallet_route.replace('id', 'providerID='+id));

        $('.tabDiv').show();
        var newBookingRef = database.collection('provider_orders').where('status','==','Order Placed').where('provider.author','==',id).orderBy('createdAt', 'desc');
        var todayBookingRef = database.collection('provider_orders').where('newScheduleDateTime', '>=',startTimestamp).where('newScheduleDateTime', '<=',endTimestamp).where('status','in',['Order Accepted','Order Assigned','Order Ongoing']).where('provider.author','==',id);
        var upcomingBookingRef=database.collection('provider_orders').where('status','in',['Order Accepted','Order Assigned']).where('newScheduleDateTime', '>=',endTimestamp).where('provider.author','==',id);
        var completedBookingRef = database.collection('provider_orders').where('status','==','Order Completed').where('provider.author','==',id).orderBy('createdAt', 'desc');
        var cancelBookingRef = database.collection('provider_orders').where('status','in',['Order Cancelled','Order Rejected']).where('provider.author','==',id).orderBy('createdAt', 'desc');

    }else{
        $('.tabDiv').hide();
    var newBookingRef = database.collection('provider_orders').where('status','==','Order Placed').orderBy('createdAt', 'desc');
    var todayBookingRef = database.collection('provider_orders').where('newScheduleDateTime', '>=',startTimestamp).where('newScheduleDateTime', '<=',endTimestamp).where('status','in',['Order Accepted','Order Assigned','Order Ongoing']);
    var upcomingBookingRef=database.collection('provider_orders').where('status','in',['Order Accepted','Order Assigned']).where('newScheduleDateTime', '>=',endTimestamp);
    var completedBookingRef = database.collection('provider_orders').where('status','==','Order Completed').orderBy('createdAt', 'desc');
    var cancelBookingRef = database.collection('provider_orders').where('status','in',['Order Cancelled','Order Rejected']).orderBy('createdAt', 'desc');
    }
   
    var section_id = '<?php if(@$_COOKIE['ondemand_section_id']) {
        echo @$_COOKIE['ondemand_section_id'];
    }else{
        echo '';
    } ?>';
    if (section_id != '') {
             newBookingRef = newBookingRef.where('sectionId', '==', section_id);
             todayBookingRef=todayBookingRef.where('sectionId', '==', section_id);
             upcomingBookingRef=upcomingBookingRef.where('sectionId', '==', section_id);
             completedBookingRef=completedBookingRef.where('sectionId', '==', section_id);
             cancelBookingRef=cancelBookingRef.where('sectionId', '==', section_id);
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
    $(document).on('click', '.new_booking_list', function () {
        getNewBookings();
    });
    $(document).on('click', '.today_booking_list', function () {
        getTodayBookings();
    });
    $(document).on('click', '.upcoming_booking_list', function () {
        getUpcomingBookings();
    });
    $(document).on('click', '.completed_booking_list', function () {
        getCompletedBookings();
    });
    $(document).on('click', '.canceled_booking_list', function () {
        getCancelBookings();
    });
    var orderStatus = '<?php if (isset($_GET['status'])) {
        echo $_GET['status'];
    } else {
        echo '';
    } ?>';
    $(document).ready(function () {
        if (id != '') {
            getProviderNameForFilter(id);
        }
        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        database.collection('sections').where('serviceTypeFlag','==','ondemand-service').get().then(async function (snapshots) {

            snapshots.docs.forEach((listval) => {
                var data = listval.data();
                $('#section_id').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.name));

            })

            $('#section_id').val(section_id);
        })

        $('.new_booking_list').removeClass('active');
        $('#new_booking_list').removeClass('active');

        if (orderStatus == "order-placed") {
            $('.new_booking_list').addClass('active');
            $('#new_booking_list').addClass('active');
            getNewBookings();
        } else if (orderStatus == "order-today" || orderStatus == "order-ongoing") {
            $('.today_booking_list').addClass('active');
            $('#today_booking_list').addClass('active');
            getTodayBookings();
        } else if (orderStatus == "order-upcoming"){
            $('.upcoming_booking_list').addClass('active');
            $('#upcoming_booking_list').addClass('active');
            getUpcomingBookings();
        }else if (orderStatus == "order-completed"){
            $('.completed_booking_list').addClass('active');
            $('#completed_booking_list').addClass('active');
            getCompletedBookings();
        }else if (orderStatus == "order-canceled"){
            $('.canceled_booking_list').addClass('active');
            $('#canceled_booking_list').addClass('active');
            getCancelBookings();
        }else {
            $('.new_booking_list').addClass('active');
            $('#new_booking_list').addClass('active');
            getNewBookings();
        }

    });
    function getNewBookings() {

        $("#new_bookings_row").html('');

        jQuery("#data-table_processing").show();
        newBookingRef.get().then(async function (docSnapshot) {
            let html = '';
            html = await buildBookingHtml(docSnapshot);
            if (html != '') {
                $("#new_bookings_row").html(html);
            }
            var table = $('#newBookingTable').DataTable();
            table.destroy();
            table = $('#newBookingTable').DataTable({
                order: [],
                columnDefs: [
                    {
                        targets: checkDeletePermission ? [5,6] : [4,5],
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                    {orderable: false, targets: checkDeletePermission ? [0, 7,8] : [6,7]},
                ],
                order: checkDeletePermission ? [['6', 'desc']] : [['5', 'desc']],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true

            });

            jQuery("#data-table_processing").hide();


        });
    }
    function getTodayBookings() {

        $("#today_bookings_row").html('');

        jQuery("#data-table_processing").show();
        todayBookingRef.get().then(async function (docSnapshot) {
            let html = '';
            html = await buildBookingHtml(docSnapshot);
            if (html != '') {
                $("#today_bookings_row").html(html);
            }
            var table = $('#todayBookingTable').DataTable();
            table.destroy();
            table = $('#todayBookingTable').DataTable({
                order: [],
                columnDefs: [
                    {
                        targets: checkDeletePermission ? [5,6] : [4,5],
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                    {orderable: false, targets: checkDeletePermission ? [0, 7,8] : [6,7]},
                ],
                order: checkDeletePermission ? [['6', 'desc']] : [['5', 'desc']],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true

            });

            jQuery("#data-table_processing").hide();


        });
    }
    function getUpcomingBookings() {

        $("#upcoming_bookings_row").html('');

        jQuery("#data-table_processing").show();
        upcomingBookingRef.get().then(async function (docSnapshot) {
            let html = '';
            html = await buildBookingHtml(docSnapshot);
            if (html != '') {
                $("#upcoming_bookings_row").html(html);
            }
            var table = $('#upcomingBookingTable').DataTable();
            table.destroy();
            table = $('#upcomingBookingTable').DataTable({
                order: [],
                columnDefs: [
                    {
                        targets: checkDeletePermission ? [5,6] : [4,5],
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                    {orderable: false, targets: checkDeletePermission ? [0, 7,8] : [6,7]},
                ],
                order: checkDeletePermission ? [['6', 'desc']] : [['5', 'desc']],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true


            });

            jQuery("#data-table_processing").hide();


        });
    }
    function getCompletedBookings() {

        $("#completed_bookings_row").html('');

        jQuery("#data-table_processing").show();
        completedBookingRef.get().then(async function (docSnapshot) {
            let html = '';
            html = await buildBookingHtml(docSnapshot);
            if (html != '') {
                $("#completed_bookings_row").html(html);
            }
            var table = $('#completedBookingTable').DataTable();
            table.destroy();
            table = $('#completedBookingTable').DataTable({
                order: [],
                columnDefs: [
                    {
                        targets: checkDeletePermission ? [5,6] : [4,5],
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                    {orderable: false, targets: checkDeletePermission ? [0, 7,8] : [6,7]},
                ],
                order: checkDeletePermission ? [['6', 'desc']] : [['5', 'desc']],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true


            });

            jQuery("#data-table_processing").hide();


        });
    }
    function getCancelBookings() {

        $("#cancel_bookings_row").html('');

        jQuery("#data-table_processing").show();
        cancelBookingRef.get().then(async function (docSnapshot) {
            let html = '';
            html = await buildBookingHtml(docSnapshot);
            if (html != '') {
                $("#cancel_bookings_row").html(html);
            }
            var table = $('#cancelBookingTable').DataTable();
            table.destroy();
            table = $('#cancelBookingTable').DataTable({
                order: [],
                columnDefs: [
                    {
                        targets: checkDeletePermission ? [5,6] : [4,5],
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                    {orderable: false, targets: checkDeletePermission ? [0, 7,8] : [6,7]},
                ],
                order: checkDeletePermission ? [['6', 'desc']] : [['5', 'desc']],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true


            });

            jQuery("#data-table_processing").hide();


        });
    }

    async function buildBookingHtml(snapshots) {
        var html = '';
        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();
            var getData = await getListData(val);
            html += getData;
        }));
        return html;
    }

    async function getListData(val) {

        var html='';
        html = html + '<tr>';

        var id = val.id;
        var route1 = '{{route("ondemand.bookings.edit",":id")}}';
        route1 = route1.replace(':id', id);

        var userRoute = '{{route("users.view",":id")}}';
        userRoute = userRoute.replace(':id', val.author.id);

        var printRoute = '{{route("ondemand.bookings.print",":id")}}';
        printRoute = printRoute.replace(':id', id);

        if(checkDeletePermission){
            html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>';
        }

        html = html + '<td><a href="'+route1+'">' + val.id + '</a></td>';

        html = html + '<td><a href="' + userRoute + '">' + val.author.firstName + ' ' + val.author.lastName + '<a/></td>';

        if (val.status == 'Order Placed') {
            html = html + '<td class="order_placed"><span>' + val.status + '</span></td>';

        }else if (val.status == 'Order Assigned') {
            html = html + '<td class="order_assigned"><span>' + val.status + '</span></td>';
        }
        else if (val.status == 'Order Ongoing') {
            html = html + '<td class="order_ongoing"><span>' + val.status + '</span></td>';

        }
        else if (val.status == 'Order Accepted') {
            html = html + '<td class="order_accept"><span>' + val.status + '</span></td>';

        }else if (val.status == 'Order Rejected') {
            html = html + '<td class="order_rejected"><span>' + val.status + '</span></td>';

        }else if (val.status == 'Order Completed') {
            html = html + '<td class="order_completed"><span>' + val.status + '</span></td>';

        }
        else if (val.status == 'Order Cancelled') {
            html = html + '<td class="order_rejected"><span>' + val.status + '</span></td>';
        }else{
            html = html + '<td class="order_completed"><span>' + val.status + '</span></td>';

        }
        var price = 0;

        var price =  buildHTMLProductstotal(val);
        if(val.provider.priceUnit!='Hourly'){
            html = html + '<td>' + price + '</td>';
        }else{
            if(val.status!='Order Completed'){
                var perHourPrice=parseFloat(val.provider.price);
                 if (val.provider.disPrice != null && val.provider.disPrice != undefined && val.provider.disPrice != '' && val.provider.disPrice != '0') {
                        perHourPrice = parseFloat(val.provider.disPrice)
                    }
                    if (currencyAtRight) {
                        perHourPrice = perHourPrice.toFixed(decimal_degits) + "" + currentCurrency;
                    } else {
                        perHourPrice = currentCurrency + "" + perHourPrice.toFixed(decimal_degits);
                    }
                html = html + '<td>' + perHourPrice + ' /hr</td>';
            }else{
                html = html + '<td>' + price + '</td>';
            }
        }
        var bookingDate = '';
        var bookingTime = '';
        if (val.hasOwnProperty("scheduleDateTime")) {

            bookingDate = val.scheduleDateTime.toDate().toDateString();
            bookingTime = val.scheduleDateTime.toDate().toLocaleTimeString('en-US');
        }
        if (val.hasOwnProperty("newScheduleDateTime") && val.newScheduleDateTime!=null && val.newScheduleDateTime!='') {
            bookingDate = val.newScheduleDateTime.toDate().toDateString();
            bookingTime = val.newScheduleDateTime.toDate().toLocaleTimeString('en-US');

        }
        html = html + '<td class="dt-time">' + bookingDate + ' ' + bookingTime + '</td>';
      

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
        const section = await getSectionName(val.sectionId);
        html = html + '<td>' + section + '</td>';
        html = html + '<td class="action-btn"><a href="' + printRoute + '"><i class="fa fa-print" style="font-size:20px;"></i></a><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
        if(checkDeletePermission){
            html = html+'<a id="' + val.id + '" name="order-delete" class="" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        }
        html = html+'</td>';

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


    $("#del_new").click(function () {
        $("#newBookingTable .is_open").prop('checked', $(this).prop('checked'));
    });
    $("#del_today").click(function () {
        $("#todayBookingTable .is_open").prop('checked', $(this).prop('checked'));
    });
    $("#del_upcoming").click(function () {
        $("#upcomingBookingTable .is_open").prop('checked', $(this).prop('checked'));
    });
    $("#del_completed").click(function () {
        $("#completedBookingTable .is_open").prop('checked', $(this).prop('checked'));
    });
    $("#del_canceled").click(function () {
        $("#cancelBookingTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAllNew").click(function () {
        if ($('#newBookingTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#newBookingTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('provider_orders').doc(dataId).delete().then(function () {
                        window.location.reload();
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });
    $("#deleteAllToday").click(function () {
        if ($('#todayBookingTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#todayBookingTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('provider_orders').doc(dataId).delete().then(function () {
                        window.location.reload();
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });
    $("#deleteAllUpcoming").click(function () {
        if ($('#upcomingBookingTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#upcomingBookingTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('provider_orders').doc(dataId).delete().then(function () {
                        window.location.reload();
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });
    $("#deleteAllCompleted").click(function () {
        if ($('#completedBookingTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#completedBookingTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('provider_orders').doc(dataId).delete().then(function () {
                        window.location.reload();
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });
    $("#deleteAllCancel").click(function () {
        if ($('#cancelBookingTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#cancelBookingTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('provider_orders').doc(dataId).delete().then(function () {
                        window.location.reload();
                    });
                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    $(document).on("click", "a[name='order-delete']", function (e) {
        var id = this.id;
        database.collection('provider_orders').doc(id).delete().then(function (result) {
            window.location.href = '{{ url()->current() }}';
        });
    });

    function buildHTMLProductstotal(snapshotsProducts) {
        var adminCommission = snapshotsProducts.adminCommission;
        var discount = snapshotsProducts.discount;
        var couponCode = snapshotsProducts.couponCode;
        var status = snapshotsProducts.status;
        var products = snapshotsProducts;
        var totalProductPrice = 0;
        var total_price = 0;

        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;


        var val = products;
      
        var sub_total = parseFloat(val.provider.price);

        if (val.provider.disPrice != null && val.provider.disPrice != undefined && val.provider.disPrice != '' && val.provider.disPrice != '0') {
            sub_total = parseFloat(val.provider.disPrice)
        }
        var price = sub_total;
        
        sub_total=parseFloat(val.quantity)*sub_total;
       
        total_price += parseFloat(sub_total);

        if (intRegex.test(discount) || floatRegex.test(discount)) {

            discount = parseFloat(discount).toFixed(decimal_degits);
            total_price -= parseFloat(discount);

            if (currencyAtRight) {
                discount_val = discount + "" + currentCurrency;
            } else {
                discount_val = currentCurrency + "" + discount;
            }


        }
        var tax = 0;
        taxlabel = '';
        taxlabeltype = '';

        if (snapshotsProducts.hasOwnProperty('taxSetting')) {
            var total_tax_amount = 0;
            for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                var data = snapshotsProducts.taxSetting[i];

                if (data.type && data.tax) {
                    if (data.type == "percentage") {
                        tax = (data.tax * total_price) / 100;
                        taxlabeltype = "%";
                    } else {
                        tax = data.tax;
                        taxlabeltype = "fix";
                    }
                    taxlabel = data.title;
                }

                total_tax_amount += parseFloat(tax);
            }
            total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
        }

        if (currencyAtRight) {
            var total_price_val = parseFloat(total_price).toFixed(decimal_degits) + "" + currentCurrency;
        } else {
            var total_price_val = currentCurrency + "" + parseFloat(total_price).toFixed(decimal_degits);
        }

        return total_price_val;
    }
async function getProviderNameForFilter(providerId){
        await database.collection('users').where('id', '==', providerId).get().then(async function (snapshots) {
            var providerData = snapshots.docs[0].data();
            providerName = providerData.firstName+' '+providerData.lastName;
            $('.PageTitle').html("{{trans('lang.booking_plural')}} - " + providerName);
        });

}
function clickLink(value) {
        setCookie('ondemand_section_id', value, 30);
        location.reload();
    }

</script>


@endsection
