@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item">Admin Management</li>
                        <li class="breadcrumb-item active">List of user</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-olive">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa-solid fa-list"></i>&emsp;<b>List of user</b></h3>
                            <div class="card-tools">
                                <a href="{{ route('users/create') }}" >
                                    <button type="button" class="btn bg-gradient-success" title="Register New User"><i class="fa-solid fa-user-plus"></i> <b>Register New User</b></button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card card-success shadow-sm">
                                        <div class="card-body">
                                        <form action="{{ route('users/list') }}" method="GET" enctype="multipart/form-data" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-md-1"><b>Role</b></div>
                                                <div class="col-md-3">
                                                    <select id="role" name="role" class="select2 form-control">
                                                        <?php
                                                            $select_all = null;
                                                            $select_admin = null;
                                                            $select_expert = null;
                                                            $select_normal = null;

                                                            if($role == null) { $select_all = 'selected="selected"'; }
                                                            elseif($role == '2') { $select_admin = 'selected="selected"'; }
                                                            elseif($role == '3') { $select_expert = 'selected="selected"'; }
                                                            elseif($role == '4') { $select_normal = 'selected="selected"'; }
                                                        ?>
                                                        <option value="" {{$select_all}}>All</option>
                                                        <option value="2" {{$select_admin}}>Admin</option>
                                                        <option value="3" {{$select_expert}}>User Expert</option>
                                                        <option value="4" {{$select_normal}}>User Normal</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="{{ route('users/list') }}" >
                                                        <button type="button" class="btn bg-gradient-success"><i class="fa-solid fa-rotate"></i></button>
                                                    </a>
                                                    <button type="submit" class="btn bg-gradient-info"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                    </div>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">ID</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Full Name</th>
                                                <th width="10%">Status</th>
                                                <th width="15%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($users as $usr)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $usr->role->name }}</td>
                                                    <td>{{ $usr->email }}</td>
                                                    <td>{{ $usr->profile->name }}</td>
                                                    <td><p style="color:{{ $usr->status->color }}"><b>{{ $usr->status->name }}</b></p></td>
                                                    <td>
                                                        <center>
                                                            <form action="{{ route('users/delete',$usr->id) }}" method="POST">
                                                                <a href="{{ route('users/view',$usr->id) }}" >
                                                                    <button type="button" class="btn bg-gradient-info btn-sm" title='View'><i class="fa-solid fa-magnifying-glass"></i></button>
                                                                </a>

                                                                <a href="{{ route('users/edit',$usr->id) }}" >
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