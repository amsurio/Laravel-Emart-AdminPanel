@extends('layouts.app')

@section('content')

    <div class="page-wrapper">


        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor">{{trans('lang.ondemand_plural')}} - {{trans('lang.category_plural')}}</h3>

            </div>

            <div class="col-md-7 align-self-center">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                    <li class="breadcrumb-item active">{{trans('lang.ondemand_plural')}} - {{trans('lang.category_plural')}}</li>

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
                                    <a class="nav-link active" href="{!! route('ondemandcategory') !!}"><i
                                                class="fa fa-list mr-2"></i>{{trans('lang.category_table')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('ondemandcategory.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.category_create')}}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive m-t-10">

                                <table id="categoryTable"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">

                                    <thead>

                                    <tr>
                                        <?php if (in_array('ondemand.categories.delete', json_decode(@session('user_permissions')))) { ?>
                                        <th class="delete-all">
                                            <input type="checkbox" id="is_active">
                                            <label class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" href="javascript:void(0)"><i class="fa fa-trash"></i> {{trans('lang.all')}}</a>
                                            </label>
                                        </th>
                                        <?php }?>
                                        <th>{{trans('lang.category_image')}}</th>
                                        <th>{{trans('lang.name')}}</th>
                                        <th>{{trans('lang.section')}}</th>
                                        <th>{{trans('lang.item_publish')}}</th>
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
        if ($.inArray('ondemand.categories.delete', user_permissions) >= 0) {
            checkDeletePermission = true;
        }

        var database = firebase.firestore();

        var pagesize = 10;
        var user_number = [];
        var ref = database.collection('provider_categories');
        var placeholderImage = '';
        var append_list = '';

        $(document).ready(function () {

            jQuery("#data-table_processing").show();

            var placeholder = database.collection('settings').doc('placeHolderImage');
            placeholder.get().then(async function (snapshotsimage) {
                var placeholderImageData = snapshotsimage.data();
                placeholderImage = placeholderImageData.image;
            })

            append_list = document.getElementById('append_list1');
            append_list.innerHTML = '';

            ref.get().then(async function (snapshots) {

                html = '';

                html = await buildHTML(snapshots);
                
                jQuery("#data-table_processing").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    if (snapshots.docs.length < pagesize) {
                        jQuery("#data-table_paginate").hide();
                    }
                }

                $('#categoryTable').DataTable({
                    columnDefs: [{
                        targets: (checkDeletePermission==true) ? 3 :2,
                        type: 'date',
                        render: function (data) {
                            return data;
                        }
                    },
                    {orderable: false, targets: [0, 1, 2, 3, 4,5]},
                    ],
                    order: [],
                    "language": {
                        "zeroRecords": "{{trans('lang.no_record_found')}}",
                        "emptyTable": "{{trans('lang.no_record_found')}}"
                    },
                    responsive: true,
                });
            });
        });

        async function buildHTML(snapshots) {
            
            var categories_data = [];
            snapshots.docs.forEach((listval) => {
                var datas = listval.data();
                datas.id = listval.id;
                categories_data.push(datas);
            });
            
            var categories_list = [];
            for(var i = 0; i < categories_data.length ; i++){
                if(categories_data[i].level == 0){
                    categories_list.push({
                        'id':categories_data[i].id,
                        'image':categories_data[i].image,
                        'level':categories_data[i].level,
                        'parentCategoryId':categories_data[i].parentCategoryId,
                        'publish':categories_data[i].publish,
                        'title':'<p class="font-weight-bold">'+categories_data[i].title+'</p>',
                        'sectionId': categories_data[i].sectionId,
                    });
                    var children = await getChildCategories(categories_data[i].id, 0, 1);
                    if(children.length > 0){
                        for(var j = 0; j < children.length ; j++){
                            categories_list.push(children[j]);
                        }
                    }
                }
            }
            
            var html = await getListData(categories_list);
            
            return html;
        }

        async function getChildCategories(categoryId, level, depth = 0) {
            
            var snapshots = await database.collection('provider_categories').where("parentCategoryId", "==", categoryId).get();

            var sub_categories_data = [];
            snapshots.docs.forEach((listval) => {
                var datas = listval.data();
                sub_categories_data.push(datas);
            });

            var sub_html = "";
            for(var count = 0; count < depth ; count++){
                sub_html = sub_html + "-";
            }

            var sub_categories_list = [];
            for(var i = 0; i < sub_categories_data.length ; i++){
                sub_categories_list.push({
                    'id':sub_categories_data[i].id,
                    'image':sub_categories_data[i].image,
                    'level':sub_categories_data[i].level,
                    'parentCategoryId':sub_categories_data[i].parentCategoryId,
                    'publish':sub_categories_data[i].publish,
                    'title':sub_html + sub_categories_data[i].title,
                    'sectionId': sub_categories_data[i].sectionId,
                });
            }
            
            return sub_categories_list;
        }

        async function getListData(categories) {

            var html = '';
            
            for(var i = 0; i < categories.length ; i++){
                
                var val = categories[i];
                var id = val.id;

                var route1 = '{{route("ondemandcategory.edit",":id")}}';
                route1 = route1.replace(':id', id);
                
                if (checkDeletePermission) {
                    html += '<tr><td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
                        'for="is_open_' + id + '" ></label></td>';
                }
                
                if (val.image == '') {
                    html += '<td><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image"></td>';
                } else {
                    html += '<td><img class="rounded" style="width:50px" src="' + val.image + '" alt="image"></td>';
                }

                html += '<td><a href="' + route1 + '">' + val.title + '</a></td>';

                if (val.hasOwnProperty("sectionId")) {
                    var sectionName = await getSectionName(val.sectionId);
                    html = html + '<td>' + sectionName + '</td>';
                } else {
                    html = html + '<td></td>';
                }

                if (val.publish) {
                    html += '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
                } else {
                    html += '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="publish"><span class="slider round"></span></label></td>';
                }

                html += '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a>';
                
                if (checkDeletePermission) {
                    html += '<a id="' + val.id + '" name="category-delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
                }
                
                html += '</td></tr>';
            }
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
        
        $(document).on("click", "input[name='publish']", function(e) {
            var ischeck = $(this).is(':checked');
            var id = this.id;
            var publish = ischeck ? true : false;
            database.collection('provider_categories').doc(id).update({
                'publish': publish
            });
        });

        $(document).on("click", "a[name='category-delete']", function (e) {
            var id = this.id;
            database.collection('provider_categories').doc(id).delete().then(function () {
                window.location.reload();
            });
        });

        $("#is_active").click(function () {
            $("#categoryTable .is_open").prop('checked', $(this).prop('checked'));
        });

        $("#deleteAll").click(function () {
            if ($('#categoryTable .is_open:checked').length) {
                if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                    jQuery("#data-table_processing").show();
                    $('#categoryTable .is_open:checked').each(function () {
                        var dataId = $(this).attr('dataId');
                        database.collection('provider_categories').doc(dataId).delete().then(function () {
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

    </script>

@endsection
