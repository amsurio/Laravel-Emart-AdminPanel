@extends('layouts.app')

@section('content')
<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.rental_vehicle')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.rental_vehicle')}}</li>
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

                    <div class="card-body">


                        <div class="table-responsive m-t-10">


                            <table id="example24"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>

                                    <th>{{trans('lang.image')}}</th>

                                    <th>{{trans('lang.car_name')}}</th>

                                    <th>{{trans('lang.associate_driver')}}</th>

                                    <th>{{trans('lang.actions')}}</th>

                                </tr>

                                </thead>

                                <tbody id="append_list1">


                                </tbody>

                            </table>
                            <div id="data-table_paginate" style="display:none">
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

    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;

    var append_list = '';
    var user_number = [];
    var refData = database.collection('users').where('serviceType', '==', 'rental-service');

     var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
placeholder.get().then(async function (snapshotsimage) {
      var placeholderImageData = snapshotsimage.data();
      placeholderImage = placeholderImageData.image;
    })

    $(document).ready(function () {

        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });

        jQuery("#data-table_processing").show();
        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        database.collection('users').where('serviceType', '==', 'rental-service').get().then(async function (snapshots) {
            html = '';

            html = await buildHTML(snapshots);
            jQuery("#data-table_processing").hide();
            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);

            }
    
            $('#example24').DataTable({

                order: [],
                columnDefs: [
                    {orderable: false, targets: [0, 3]},
                ],
                order: [1, "desc"],
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
   

        var count = 0;
       
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

        var id = val.id;
        var route1 = '{{route("rental_orders.edit",":id")}}';
        route1 = route1.replace(':id', id);

        var route1 = '{{route("drivers.edit",":id")}}';
        route1 = route1.replace(':id', val.id);
        var route2 = '{{route("drivers.vehicle",":id")}}';
        route2 = route2.replace(':id', val.id);


        if (val.carPictureURL != undefined && val.carPictureURL != '') {
            html = html + '<td><img  style="width:50px" src="' + val.carPictureURL + '" alt="Image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></td>';

        } else {
           
            html = html + '<td><img class="image_' + val.id + '" style="width:50px" src="'+placeholderImage+'" alt="Image"></td>';

        }

        html = html + '<td>' + val.carName + '</td>';

        html = html + '<td data-url="' + route1 + '" class="redirecttopage driver_' + val.driverID + '">' + val.firstName + " " + val.lastName + '</td>';

        html = html + '<td class="action-btn">' +
            '<a href="' + route2 + '"><i class="fa fa-eye"></i></a>' +
            '<a href="' + route1 + '"><i class="fa fa-edit"></i></a>' +

            '</td>';

        html = html + '</tr>';
        count = count + 1;
        return html;
    }


</script>


@endsection
