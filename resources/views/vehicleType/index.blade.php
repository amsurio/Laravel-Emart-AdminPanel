@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.vehicle_type')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.vehicle_type')}}</li>

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
                                <a class="nav-link active" href="{!! route('vehicleType') !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.vehicle_type')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('vehicleType.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>{{trans('lang.add_vehicle_type')}}</a>
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


                                <th>{{trans('lang.name')}}</th>
                                <th>{{trans('lang.icon')}}</th>


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
    var ref = database.collection('vehicle_type');
    var placeholderImage = '';

    var placeholder = database.collection('settings').doc('placeHolderImage');

    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })
    var append_list = '';

    $(document).ready(function () {

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
                columnDefs: [
                    {orderable: false, targets: [1, 2, 3]},
                ],
                order: [0, "asc"],
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
        var count = 0;
        html = html + '<tr>';
        newdate = '';
        var id = val.id;
        var route1 = '{{route("vehicleType.edit",":id")}}';
        route1 = route1.replace(':id', id);


        html = html + '<td data-url="' + route1 + '" class="redirecttopage">' + val.name + '</td>';
        var photo = val.vehicle_icon;
        if (photo != '') {

            html = html + '<td><img class="rounded" style="width:50px" src="' + photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></td>';

        } else {

            html = html + '<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>';

        }

        if (val.isActive) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isActive"><span class="slider round"></span></label></td>';
        }

        html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';

        <?php if(in_array('cab-vehicle-type.delete', json_decode(@session('user_permissions')))){?>

        html = html + '<a id="' + val.id + '" name="vehicleType-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
        <?php }?>

        html = html + '</td>';
        html = html + '</tr>';
        count = count + 1;
        return html;
    }

    $(document).on("click", "input[name='isActive']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('vehicle_type').doc(id).update({'isActive': true}).then(function (result) {
            });
        } else {
            database.collection('vehicle_type').doc(id).update({'isActive': false}).then(function (result) {
            });
        }

    });

    $(document.body).on('click', '.redirecttopage', function () {
        var url = $(this).attr('data-url');
        window.location.href = url;
    });


    $(document).on("click", "a[name='vehicleType-delete']", function (e) {
        var id = this.id;
        database.collection('vehicle_type').doc(id).delete().then(function () {
            window.location.reload();
        });
    });

</script>

@endsection