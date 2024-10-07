@foreach ($roles as $role)
<div class="modal fade bs-view-modal-{{ $role->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Role Information</h4>
            </div>
            <div class="modal-body">
                <div class="x_content">
                    <div class="form-group row ">
                        <label class="control-label col-md-2">Name <font color="red">*</font></label>
                        <div class="col-md-10">
                        <input type="text" value="{{ $role->name }}" disabled="disabled" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="control-label col-md-2">Permission <font color="red">*</font></label>
                        <div class="col-md-10">
                            <?php 
                                $rolePermissions = App\Models\Sys\RolePermissions::where('role_id', '=', $role->id)->get(); 
                                foreach ($rolePermissions as $key => $value) {
                                    echo '<span class="btn btn-info btn-sm text-left">'.$value->permission->name.'</span>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="control-label col-md-2">Status <font color="red">*</font></label>
                        <div class="col-md-10">
                            <select value="{{ $role->status_id }}" class="form-control" disabled="disabled">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach