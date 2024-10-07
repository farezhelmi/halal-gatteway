@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"  id="formModal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form action="{{ route('setting/update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <div class="modal-header">
                                <h3><b>Customize Theme</b></h3>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <p>Field with <font color="red">*</font> are required.</p>
                                <input type="hidden" id="id" name="id" value="{{$setting->id}}">
                                <br>
                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Title <font color="red">*</font></label>
                                    <div class="col-md-10">
                                        <input type="text" id="title" name="title" value="{{ $setting->title }}" required="required" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Title Favicon<font color="red">*</font></label>
                                    <div class="col-md-10">
                                        <input type="text" id="title_favicon" name="title_favicon" value="{{ $setting->title_favicon }}" required="required" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Favicon <font color="red">*</font></label>
                                    <div class="col-md-10">
                                        <?php
                                            $favicon_path = 'gentelella-master/production/images/favicon.ico';
                                            if($setting->favicon_path != null) {
                                                $favicon_path = $setting->favicon_path;
                                            }
                                        ?>
                                        <img class="img-responsive avatar-view" src="{{ asset($favicon_path) }}" width="50px" height="50px">
                                        <br><br>
                                        <input type="file" id="favicon_path" name="favicon_path" accept=".jpg, .jpeg, .png" onchange="ValidateSingleInput(this);">
                                        <br>
                                        <span>Recommended image sizes for favicon : Width(100px) x Height(100px)</span>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row ">
                                    <label class="control-label col-md-2">Logo <font color="red">*</font></label>
                                    <div class="col-md-10">
                                        <?php
                                            $logo_path = 'gentelella-master/production/images/favicon.ico';
                                            if($setting->logo_path != null) {
                                                $logo_path = $setting->logo_path;
                                            }
                                        ?>
                                        <img class="img-responsive avatar-view" src="{{ asset($logo_path) }}" width="210px" height="50px">
                                        <br><br>
                                        <input type="file" id="logo_path" name="logo_path" accept=".jpg, .jpeg, .png" onchange="ValidateSingleInput(this);">
                                        <br>
                                        <span>Recommended image sizes for logo : Width(700px) x Height(200px)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('/') }}" >
                                    <button type="button" class="btn btn-secondary" style="width:120px"><i class="fa fa-close"></i> Close</button>
                                </a>
                                <button type="submit" class="btn btn-success" style="width:120px"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(window).on('load', function() {
            // $('#formModal').modal('show');
            $('#formModal').modal({backdrop: 'static', keyboard: false}, 'show');
        });

        var _validFileExtensions = [".jpg", ".jpeg", ".png"];    
        function ValidateSingleInput(oInput) {
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }
                    
                    if (!blnValid) {
                        swal("Please upload documents in jpg, jpeg or png format only.", "", "warning");
                        oInput.value = "";
                        return false;
                    }
                }
            }
            return true;
        }
    </script>
@endsection