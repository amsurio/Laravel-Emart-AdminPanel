@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor restaurantTitle">{{trans('lang.role_plural')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.role_plural')}}</li>
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
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                        class="fa fa-list mr-2"></i>{{trans('lang.role_table')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! route('role.save') !!}"><i
                                        class="fa fa-plus mr-2"></i>{{trans('lang.create_role')}}</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">

                        <div id="data-table_processing" class="dataTables_processing panel panel-default"
                            style="display: none;">Processing...
                        </div>

                        <div class="table-responsive m-t-10">

                            <table id="roleTable"
                                class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                cellspacing="0" width="100%">

                                <thead>

                                    <tr>
                                    <?php if (in_array('role.delete', json_decode(@session('user_permissions')))) { ?>

                                        <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active">
                                                <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>
                                        <?php }?>                
                                        <th>{{trans('lang.name')}}</th>
                                        <th>{{trans('lang.actions')}}</th>
                                    </tr>

                                </thead>

                                <tbody id="append_list1">
                                    @foreach($roles as $role)
                                            <tr>
                                       <?php if (in_array('role.delete', json_decode(@session('user_permissions')))) { ?>
                                             
                                                <td class="delete-all">
                                                  @if($role->role_name!="Super Administrator")
                                                    <input type="checkbox" id="is_open_{{$role->id}}" class="is_open" dataid="{{$role->id}}">
                                                    <label class="col-3 control-label" for="is_open_{{$role->id}}"></label>
                                                    @endif
                                                </td>
                                        <?php }?>
                                                <td>
                                                    <a href="{{route('role.edit', ['id' => $role->id])}}">{{ $role->role_name}}</a>
                                                </td>
                                                <td class="action-btn">

                                                    <a href="{{route('role.edit', ['id' => $role->id])}}"><i
                                                            class="fa fa-edit"></i></a>
                                            @if($role->role_name!="Super Administrator")
                                               @if(in_array('role.delete', json_decode(@session('user_permissions'))))

                                                    <a href="{{route('role.delete', ['id' => $role->id])}}"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            @endif            
                                                </td>
                                            </tr>
                                    @endforeach

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

            if ($.inArray('role.delete', user_permissions) >= 0) {
                checkDeletePermission = true;
            }

        $('#roleTable').DataTable({
                    order: [],
                    columnDefs: [
                        { orderable: false, targets: (checkDeletePermission==true) ? [0,2] : [1] },

                    ],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true
                });

            $("#is_active").click(function () {
                $("#roleTable .is_open").prop('checked', $(this).prop('checked'));

            });

            $("#deleteAll").click(function () {
                if ($('#roleTable .is_open:checked').length) {
                      if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                        var arrayUsers = [];
                        $('#roleTable .is_open:checked').each(function () {
                            var dataId = $(this).attr('dataId');
                            arrayUsers.push(dataId);

                        });

                        arrayUsers = JSON.stringify(arrayUsers);
                        var url = "{{url('role/delete', 'id')}}";
                        url = url.replace('id', arrayUsers);

                        $(this).attr('href', url);
                    }
                } else {
                     alert("{{trans('lang.select_delete_alert')}}");
                }
            });
</script>


@endsection