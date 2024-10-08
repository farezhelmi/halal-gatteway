@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                <li class="breadcrumb-item">RBAC</li>
                <li class="breadcrumb-item">Roles</li>
                <li class="breadcrumb-item active">Add New Role</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa-solid fa-user-pen"></i>&emsp;<b>{{ $title }}</b>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ secure_url($route) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <p>Field with <font color="red">*</font> are required.</p>
                                <input type="hidden" name="id" id="id" value="{{ $role->id }}">

                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Name <font color="red">*</font></label>
                                    <div class="col-md-10">
                                        <input type="text" name="name" id="name" value="{{ $role->name }}" required="required" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Level <font color="red">*</font></label>
                                    <div class="col-md-1">
                                        <input type="number" name="level" id="level" value="{{ $role->level }}" required="required" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Route <font color="red">*</font></label>
                                    <div class="col-md-10">
                                        <select class="duallistbox" multiple="multiple" name="list_permission[]" id="list_permission" title="list_permission[]" required="required" size="10" style="height: 200px;">
                                            @foreach ($permissions as $key => $value)
                                                <?php 
                                                    $check = App\Models\Sys\RolePermissions::where([
                                                        ['role_id', '=', $role->id], ['permission_id', '=', $key]
                                                    ])->first(); 
                                                    
                                                    $select = '';
                                                    if($check != null) {
                                                        $select = 'selected="selected"';
                                                    }
                                                ?>
                                                <option value="{{ $key }}" {{ $select }}> 
                                                    {{ $value }} 
                                                </option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Status <font color="red">*</font></label>
                                    <div class="col-md-10">
                                        <select name="status_id" id="status_id" class="form-control">
                                            <option value="1" <?php if($role->status_id == "1") { echo 'selected="selected"';} ?>>Active</option>
                                            <option value="2" <?php if($role->status_id == "2") { echo 'selected="selected"';} ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ url()->previous() }}" >
                                <button type="button" class="btn bg-gradient-primary" style="width:120px"><i class="fa-solid fa-arrow-left"></i> <b>Back</b></button>
                            </a>
                            <button type="submit" class="btn bg-gradient-success" style="width:120px"><b>Save</b> <i class="fa-solid fa-floppy-disk"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection