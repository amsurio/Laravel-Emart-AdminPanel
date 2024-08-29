@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.category_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.category_plural')}}</li>
            </ol>
        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}
        </div>
        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.category_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('categories.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.category_create')}}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">



                        <div id="users-table_filter" class="pull-right">
                            <div class="row">
                            <div class="col-md-9">
                            </div>
                                <div class="col-md-3">
                                    <select id="section_id" class="form-control allModules" style="width:100%" onchange="clickLink(this.value)">
                                        <option value="" >{{trans('lang.select')}} {{trans('lang.section_plural')}}</option>
                                    </select>
                                    <p style="color: red;font-size: 13px;">{{trans('lang.rental_parcel_cab_service_are_not')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive m-t-10">
                            <table id="categoryTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                <thead>


                                    <tr>
                                        <?php if (in_array('categories.delete', json_decode(@session('user_permissions')))) { ?>

                                        <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                        <?php }?>        
                                        <th>{{trans('lang.category_image')}}</th>
                                        <th>{{trans('lang.faq_category_name')}}</th>
                                        <th>{{trans('lang.section')}}</th>
                                        <th>{{trans('lang.item')}}</th>
                                        <th> {{trans('lang.item_publish')}}</th>
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

</div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    var user_permissions = '<?php echo @session('user_permissions') ?>';

    user_permissions = JSON.parse(user_permissions);

    var checkDeletePermission = false;

    if ($.inArray('categories.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }
    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];
    var section_id = getCookie('section_id');

    if (section_id != '') {
        var ref = database.collection('vendor_categories').where('section_id', '==', section_id);
    } else {
        var ref = database.collection('vendor_categories');
    }
    var append_list = '';
    var placeholderImage = '';
    var ref_sections = database.collection('sections');
    let selected_gender = "";

    $(document).ready(function() {

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

            var html = '';
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
            $('#categoryTable').DataTable({
                order: [],
                columnDefs: [{
                        targets: (checkDeletePermission==true) ? 4 : 3,
                        type: 'date',
                        render: function(data) {

                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: (checkDeletePermission==true) ? [0,1,5,6] : [0,4,5]
                    },
                ],
                order: (checkDeletePermission==true) ? [2, "asc"] : [1,"asc"],
                "language": {
                    "zeroRecords": "{{trans('lang.no_record_found')}}",
                    "emptyTable": "{{trans('lang.no_record_found')}}"
                },
                responsive: true
            });

        });
        async function buildHTML(snapshots) {
        var html = '';
        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();

            let result = user_number.filter(obj => {
                return obj.id == val.author;
            })

            if (result.length > 0) {
                val.phoneNumber = result[0].phoneNumber;
                val.isActive = result[0].isActive;

            } else {
                val.phoneNumber = '';
                val.isActive = false;
            }

            var getData = await getListData(val);
            html += getData;
        }));
        return html;
    }

        ref_sections.get().then(async function(snapshots) {

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

    });

    async function getListData(val) {
            var html = '';

           

            html = html + '<tr>';
            newdate = '';

            var id = val.id;
            var route1 = '{{route("categories.edit",":id")}}';
            route1 = route1.replace(':id', id);
            if(checkDeletePermission){
                html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                'for="is_open_' + id + '" ></label></td>';

            }
            if (val.photo == '') {
                html = html + '<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>';
            } else {
                html = html + '<td><img class="rounded" style="width:50px" src="' + val.photo + '" alt="image" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></td>';
            }

            html = html + '<td><a href="' + route1 + '">' + val.title + '</a></td>';

            if (val.hasOwnProperty("section_id")) {
            var section = await getSectionName(val.section_id);
            html = html + '<td>' + section + '</td>';
           } else {
             html = html + '<td></td>';
           }
           var total= await getProductTotal(val.id, val.section_id);
            var categoryId = val.id;
            var url = '{{url("items?categoryID=id")}}';
            url = url.replace("id", categoryId);

           html = html + '<td ><a href="' + url + '">'+total+'</a></td>';

            if (val.publish) {
                html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
            } else {
                html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
            }

            html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
            if(checkDeletePermission){
            html= html+'<a id="' + val.id + '" name="category-delete" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
            }
            html=html+'</td>';


            html = html + '</tr>';
        
        return html;
    }

    /* toggal publish action code start*/
    $(document).on("click", "input[name='publish']", function(e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('vendor_categories').doc(id).update({
                'publish': true
            }).then(function(result) {

            });
        } else {
            database.collection('vendor_categories').doc(id).update({
                'publish': false
            }).then(function(result) {

            });
        }
    });

    /*toggal publish action code end*/

  
    async function getSectionName(sectionId) {

        var sectionName = '';
        if (sectionId != '') {
        await database.collection('sections').where("id", "==", sectionId).get().then(async function (snapshots) {

            if (snapshots.docs.length) {
            var data = snapshots.docs[0].data();
            sectionName = data.name;
            }
        });
    }

    return sectionName;
    }
    async function getProductTotal(id, section_id) {
        var Product_total ='';
        if (section_id != '') {
       await database.collection('vendor_products').where('categoryID', '==', id).where('section_id', '==', section_id).get().then(async function(productSnapshots) {
       
             Product_total = productSnapshots.docs.length;

        });
            
        }
        return Product_total;
    }

    $(document).on("click", "a[name='category-delete']", function(e) {
        var id = this.id;
        database.collection('vendor_categories').doc(id).delete().then(function(result) {
            window.location.href = '{{ route("categories")}}';
        });
    });

    function clickLink(value) {
        setCookie('section_id', value, 30);
        location.reload();
    }

    function clickpage(value) {
        setCookie('pagesizes', value, 30);
        location.reload();
    }

    $("#is_active").click(function() {
        $("#categoryTable .is_open").prop('checked', $(this).prop('checked'));

    });

    $("#deleteAll").click(function() {
        if ($('#categoryTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#categoryTable .is_open:checked').each(function() {
                    var dataId = $(this).attr('dataId');
                    database.collection('vendor_categories').doc(dataId).delete().then(function() {});
                    setTimeout(function() {
                        window.location.reload();
                    }, 5000);
                });

            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });
</script>

@endsection