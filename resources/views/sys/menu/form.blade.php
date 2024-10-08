@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item">RBAC</li>
                        <li class="breadcrumb-item">MENU</li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </div>
            </div>

            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ secure_url($route) }}" method="POST" class="form-horizontal">
                        @csrf
                        <p>Field with <font color="red">*</font> are required.</p>
                        <input type="hidden" id="id" name="id" value="{{$model->id}}">
                        <input type="hidden" id="action" name="action" value="{{$action}}">

                        <div class="form-group row ">
                            <label class="control-label col-md-1">Parent <font color="red">*</font></label>
                            <div class="col-md-11">
                                <select id="parent" name="parent" class="form-control select2" required="required" style="width: 100%;">
                                    <option value="">Please Select</option>
                                    <option value="ROOT" {{$root}}>ROOT</option>
                                    @foreach ($parents as $parent)
                                        <?php 
                                            $select1 = '';
                                            if($route == 'menu/update' && $root == '' && $action == 'edit-child1') {
                                                if($model->parent_id == $parent->id) {
                                                    $select1 = 'selected="selected"';
                                                }
                                            }
                                        ?>
                                        <option value="parent-{{ $parent->id }}" {{$select1}}>-- {{ $parent->sort.'. '.$parent->title }}</option>
                                        <?php $child1s = App\Models\Sys\Menu1Childs::where([['parent_id', '=', $parent->id],['status_id', '=', 1]])->orderBy('sort', 'ASC')->get(); ?>
                                        @if(count($child1s) > 0)
                                            @foreach ($child1s as $child1)
                                                <?php 
                                                    $select2 = '';
                                                    if($route == 'menu/update' && $root == '' && $action == 'edit-child2') {
                                                        if($model->child1_id == $child1->id) {
                                                            $select2 = 'selected="selected"';
                                                        }
                                                    }
                                                ?>
                                                <option value="child1-{{ $child1->id }}" {{$select2}}>------ {{ $child1->title }}</option>
                                            @endforeach 
                                        @endif
                                    @endforeach  
                                </select>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-1">Icon <font color="red">*</font></label>
                            <div class="col-md-4">
                                <input type="text" id="icon" name="icon" value="{{$model->icon}}" required="required" class="form-control">
                            </div>
                            <div class="col-md-7">
                                Example : fa-solid fa-angle-right fa-2xs /  fa-solid fa-angles-right fa-2xs<br>
                                <span>
                                    <i class="fa fa-info-circle"></i>
                                    &nbsp;For more icons please see 
                                    <a href="https://fontawesome.com/search?o=r&m=free" target="_blank">https://fontawesome.com/search?o=r&m=free</a>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-1">Title <font color="red">*</font></label>
                            <div class="col-md-11">
                                <input type="text" id="title" name="title" value="{{$model->title}}" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-1">Url <font color="red">*</font></label>
                            <div class="col-md-11">
                                <input type="text" id="url" name="url" value="{{$model->url}}" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-1">Parameter</label>
                            <div class="col-md-11">
                                <input type="text" id="parameter" name="parameter" value="{{$model->parameter}}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-1">Sorting <font color="red">*</font></label>
                            <div class="col-md-11">
                                <input type="number" id="sort" name="sort" value="{{$model->sort}}" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-1">Roles <font color="red">*</font></label>
                            <div class="col-md-11">
                                <select id="roles" name="roles[]" class="form-control select2" multiple="multiple" required="required" style="width: 100%;">
                                    @foreach ($roles as $key => $value)
                                        <?php 
                                            $select = '';
                                            if($action == 'edit-parent') {
                                                $menuRoles = App\Models\Sys\MenuRoles::where('menu_parent_id', '=', $model->id)->orderBy('id', 'ASC')->pluck('role_id', 'id');
                                                foreach ($menuRoles as $p_id => $p_roleID) {
                                                    if($p_roleID == $key) {
                                                        $select = 'selected="selected"';
                                                    }
                                                }
                                            }
                                            elseif($action == 'edit-child1') {
                                                $menuRoles = App\Models\Sys\MenuRoles::where('menu_1child_id', '=', $model->id)->orderBy('id', 'ASC')->pluck('role_id', 'id');
                                                foreach ($menuRoles as $p_id => $p_roleID) {
                                                    if($p_roleID == $key) {
                                                        $select = 'selected="selected"';
                                                    }
                                                }
                                            }
                                            elseif($action == 'edit-child2') {
                                                $menuRoles = App\Models\Sys\MenuRoles::where('menu_2child_id', '=', $model->id)->orderBy('id', 'ASC')->pluck('role_id', 'id');
                                                foreach ($menuRoles as $p_id => $p_roleID) {
                                                    if($p_roleID == $key) {
                                                        $select = 'selected="selected"';
                                                    }
                                                }
                                            }
                                        ?>
                                        <option value="{{$key}}" {{$select}}>{{$value}}</option>
                                    @endforeach               
                                </select>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="control-label col-md-1">Status <font color="red">*</font></label>
                            <div class="col-md-11">
                                <select id="status_id" name="status_id" class="form-control">
                                    <option value="1" <?php if($model->status_id == "1") { echo 'selected="selected"';} ?>>Active</option>
                                    <option value="2" <?php if($model->status_id == "2") { echo 'selected="selected"';} ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('menu/index') }}" >
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