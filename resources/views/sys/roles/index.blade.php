@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item">RBAC</li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-olive">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa-solid fa-list"></i>&emsp;<b>List of role</b></h3>
                            <div class="card-tools">
                                <a href="{{ route('roles/create') }}" >
                                    <button type="button" class="btn bg-gradient-success" title="Add New Role"><i class="fa fa-plus"></i> <b>Add New Role</b></button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">Level</th>
                                                <th>Name</th>
                                                <th width="20%">Permission</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Created At</th>
                                                <th width="10%">Updated At</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td><center>{{ $role->level }}</center></td>
                                                    <td>{{ $role->name }} ({{ $role->id }})</td>
                                                    <td>
                                                        <?php $role_permissions = App\Models\Sys\RolePermissions::where('role_id', '=', $role->id)->get(); ?>
                                                        @foreach ($role_permissions as $key => $value)
                                                            <a href="{{ route('permissions/edit',$value->id) }}">{{ $value->permission->name }}</a><br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if($role->status_id == 1) {
                                                                echo '<span class="badge bg-success btn-block">'.$role->status->name.'</span>';
                                                            }

                                                            if($role->status_id == 2) {
                                                                echo '<span class="badge bg-secondary btn-block">'.$role->status->name.'</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>{{ date('d-m-Y H:i:s', strtotime($role->created_at)) }}</td>
                                                    <td>{{ date('d-m-Y H:i:s', strtotime($role->updated_at)) }}</td>
                                                    <td>
                                                        <center>
                                                            <form action="{{ route('roles/delete',$role->id) }}" method="POST">
                                                                <a href="{{ route('roles/edit',$role->id) }}" >
                                                                    <button type="button" class="btn bg-gradient-primary btn-sm" title='Edit'><i class="fa fa-edit"></i></button>
                                                                </a>

                                                                @csrf
                                                                <button type="submit" class="btn bg-gradient-danger btn-sm show_confirm" title='Delete'>
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </center>
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

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>
        $('.show_confirm').click(function(event) {
            event.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: "Are you sure?",
                text: "If you delete this data, it will be gone forever.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: false
            }, function(isConfirm){
                if (isConfirm)
                {
                    form.submit();
                }
            });
        });
    </script>

@endsection