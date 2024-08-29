@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.dynamic_notification')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item">{{trans('lang.dynamic_notification')}}</li>

            </ol>

        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">

        <div class="row">

            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.notificaions_table')}}</a>
                            </li>
                         

                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive m-t-10">


                            <table id="notificationTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">

                                <thead>

                                    <tr>

                                        <th>{{trans('lang.service_type')}}</th>

                                        <th>{{trans('lang.notification_type')}}</th>

                                        <th>{{trans('lang.subject')}}</th>

                                        <th>{{trans('lang.message')}}</th>

                                        <th>{{trans('lang.date_created')}}</th>

                                        <th>{{trans('lang.actions')}}</th>

                                    </tr>

                                </thead>

                                <tbody id="append_restaurants">


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
    var refData = database.collection('dynamic_notification').orderBy('service_type', 'asc');
    var ref = refData.orderBy('createdAt', 'desc');
    var append_list = '';

    $(document).ready(function() {

        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_restaurants');
        append_list.innerHTML = '';

        ref.get().then(function(snapshots) {

            var html = '';
            html = buildHTML(snapshots);
            jQuery("#data-table_processing").hide();

            if (html != '') {
                append_list.innerHTML = html;
                $('[data-toggle="tooltip"]').tooltip();
            }

            $('#notificationTable').DataTable({
                order: [],
                columnDefs: [{
                        targets: 3,
                        type: 'date',
                        render: function(data) {

                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: [4]
                    },
                ],
                "language": {
                    "zeroRecords": "{{trans('lang.no_record_found')}}",
                    "emptyTable": "{{trans('lang.no_record_found')}}"
                },
                responsive: true
            });
        });

    });

    function buildHTML(snapshots) {

        var html = '';
        var number = [];
        snapshots.docs.forEach(async (listval) => {
            var listval = listval.data();

            var val = listval;
            val.id = listval.id;
            html = html + '<tr>';
            newdate = '';
            var id = val.id;
            var route1 = '{{route("dynamic-notification.save",":id")}}';
            route1 = route1.replace(":id", id);

            var type = '';
            var title = '';

            if (val.type == "restaurant_rejected") {

                type = "{{trans('lang.order_rejected_by_restaurant')}}";
                title = "{{trans('lang.order_reject_notification')}}";
            } else if (val.type == "restaurant_accepted") {
                type = "{{trans('lang.order_accepted_by_restaurant')}}";
                title = "{{trans('lang.order_accept_notification')}}";
            } else if (val.type == "takeaway_completed") {
                type = "{{trans('lang.takeaway_order_completed')}}";
                title = "{{trans('lang.takeaway_order_complete_notification')}}";
            } else if (val.type == "store_accepted") {
                type = "{{trans('lang.order_accepted_by_restaurant')}}";
                title = "{{trans('lang.order_accept_notification')}}";
            } else if (val.type == "store_intransit") {
                type = "{{trans('lang.order_intransit_by_restaurant')}}";
                title = "{{trans('lang.order_intransit_notification')}}";
            } else if (val.type == "store_completed") {
                type = "{{trans('lang.order_completed_by_restaurant')}}";
                title = "{{trans('lang.order_complete_notification')}}";
            } else if (val.type == "cab_accepted") {
                type = "{{trans('lang.cab_accepted_by_driver')}}";
                title = "{{trans('lang.cab_accepted_order_notification')}}";
            } else if (val.type == "cab_completed") {
                type = "{{trans('lang.cab_completed_by_driver')}}";
                title = "{{trans('lang.cab_completed_order_notification')}}";
            } else if (val.type == "driver_completed") {
                type = "{{trans('lang.driver_completed_order')}}";
                title = "{{trans('lang.order_complete_notification')}}";

            } else if (val.type == "driver_accepted") {
                type = "{{trans('lang.driver_accepted_order')}}";
                title = "{{trans('lang.driver_accept_order_notification')}}";
            } else if (val.type == "dinein_canceled") {
                type = "{{trans('lang.dine_order_book_canceled_by_restaurant')}}";
                title = "{{trans('lang.dinein_cancel_notification')}}";
            } else if (val.type == "dinein_accepted") {
                type = "{{trans('lang.dine_order_book_accepted_by_restaurant')}}";
                title = "{{trans('lang.dinein_accept_notification')}}";
            } else if (val.type == "order_placed") {
                type = "{{trans('lang.new_order_place')}}";
                title = "{{trans('lang.order_placed_notification')}}";
            } else if (val.type == "dinein_placed") {
                type = "{{trans('lang.new_dine_booking')}}";
                title = "{{trans('lang.dinein_order_place_notification')}}";

            } else if (val.type == "schedule_order") {
                type = "{{trans('lang.shedule_order')}}";
                title = "{{trans('lang.schedule_order_notification')}}";
            } else if (val.type == "payment_received") {
                type = "{{trans('lang.pament_received')}}";
                title = "{{trans('lang.payment_receive_notification')}}";
            } else if (val.type == "parcel_accepted") {

                type = "{{trans('lang.parcel_accepted_by_driver')}}";
                title = "{{trans('lang.parcel_accept_notification')}}";
            } else if (val.type == "parcel_rejected") {
                type = "{{trans('lang.parcel_rejected_by_driver')}}";
                title = "{{trans('lang.parcel_reject_notification')}}";
            } else if (val.type == "rental_booked") {
                type = "{{trans('lang.rental_booked_by_customer')}}";
                title = "{{trans('lang.rental_book_notification')}}";
            } else if (val.type == "rental_rejected") {
                type = "{{trans('lang.rental_rejected_by_driver')}}";
                title = "{{trans('lang.rental_reject_notification')}}";
            } else if (val.type == "rental_accepted") {
                type = "{{trans('lang.rental_accepted_by_driver')}}";
                title = "{{trans('lang.rental_accept_notification')}}";
            } else if (val.type == "start_ride") {
                type = "{{trans('lang.start_ride_by_driver')}}";
                title = "{{trans('lang.start_ride_notification')}}";
            } else if (val.type == "rental_completed") {
                type = "{{trans('lang.rental_completed_by_driver')}}";
                title = "{{trans('lang.rental_complete_notification')}}";
            } else if (val.type == "parcel_completed") {
                type = "{{trans('lang.parcel_completed_by_driver')}}";
                title = "{{trans('lang.parcel_complete_notification')}}";
            } else if (val.type == "provider_accepted") {
                type = "{{trans('lang.booking_accepted_by_provider')}}";
                title = "{{trans('lang.booking_accepted_notification')}}";
            } else if (val.type == "booking_placed") {
                type = "{{trans('lang.service_booked_by_customer')}}";
                title = "{{trans('lang.service_booked_notification')}}";
            } else if (val.type == "service_intransit") {
                type = "{{trans('lang.service_intransit_by_provider')}}";
                title = "{{trans('lang.service_intransit_notification')}}";
            } else if (val.type == "provider_rejected") {
                type = "{{trans('lang.service_rejected_by_provider')}}";
                title = "{{trans('lang.service_rejected_notification')}}";
            }else if (val.type == "service_completed") {
                type = "{{trans('lang.service_completed_by_provider')}}";
                title = "{{trans('lang.service_completed_notification')}}";
            }
            else if (val.type == "stop_time") {
                type = "{{trans('lang.service_stop_by_provider')}}";
                title = "{{trans('lang.service_stop_notification')}}";
            }
            else if (val.type == "service_cancelled") {
                type = "{{trans('lang.service_cancelled_by_customer')}}";
                title = "{{trans('lang.service_cancelled_notification')}}";
            }
            else if (val.type == "service_charges") {
                type = "{{trans('lang.service_add_extra_charges')}}";
                title = "{{trans('lang.extra_charge_notification')}}";
            }
             else if (val.type == "worker_assigned") {
                type = "{{trans('lang.service_assigned_to_worker')}}";
                title = "{{trans('lang.service_assigned_to_worker_notification')}}";
            }


            html = html + '<td>' + val.service_type + '</td>';
            html = html + '<td>' + type + '</td>';
            html = html + '<td>' + val.subject + '</td>';
            html = html + '<td>' + val.message + '</td>';

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

            html = html + '<td class="action-btn"><i class="text-dark fs-12 fa-solid fa fa-info" data-toggle="tooltip" title="' + title + '" aria-describedby="tippy-3"></i><a href="' + route1 + '"><i class="fa fa-edit"></i></a></td>';

            html = html + '</tr>';

        });

        return html;
    }
</script>

@endsection