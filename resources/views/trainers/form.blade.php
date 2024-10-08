@extends('layouts.master')
@section('content')
    <div class="row">   
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                <li class="breadcrumb-item">List of Trainer</li>
                <li class="breadcrumb-item active">Form Registration</li>
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
                                <div class="col-md-9">
                                    <?php $trainerID = $trainer->id; if($trainer->id == null) { $trainerID = 0; } ?>
                                    <input type="hidden" id="id" name="id" value="{{ $trainerID }}">
                                    <input type="hidden" id="url_previous" name="url_previous" value="{{ url()->previous() }}">

                                    <div class="card card-success">
                                        <div class="card-body">
                                            <p>Fields marked <font color="red">*</font> are Mandatory.</p>
                                            <hr>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Full Name <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <input type="text" id="profile_name" name="name" value="{{ $trainer->name }}" required="required" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Identification Type ID <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <select id="profile_identification_type_id" name="profile_identification_type_id" class="select2 form-control" required="required">
                                                        <option value="" > - Please Select - </option>
                                                        @foreach ($identification as $key => $value)
                                                            <?php
                                                                $select = '';
                                                                if($route == 'trainers/update') {
                                                                    if($key == $trainer->identification_type_id) {
                                                                        $select = 'selected="selected"';
                                                                    }
                                                                }
                                                            ?>
                                                            <option value="{{$key}}" {{$select}}>{{$value}}</option>
                                                        @endforeach               
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">New I/C Number / Passport <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <input type="text" id="identification_no" name="identification_no" value="{{ $trainer->identification_no }}" class="form-control" required="required" onchange="identificationCardChecking(this.value)">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Email <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <input type="email" id="email" name="email" value="{{ $trainer->email }}" onchange="emailChecking(this.value)" required="required" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Gender <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <select id="gender" name="gender" class="select2 form-control" required="required">
                                                        <option value="" > - Please Select - </option>
                                                        <option value="Male" {{ $trainer->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ $trainer->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Mobile Phone <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <input type="number" id="phone_mobile" name="phone_mobile" value="{{ $trainer->phone_no }}" required="required" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Status <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <select id="status_id" name="status_id" class="select2 form-control">
                                                        <option value="1" <?php if($trainer->status_id == "1") { echo 'selected="selected"';} ?>>Active</option>
                                                        <option value="2" <?php if($trainer->status_id == "2") { echo 'selected="selected"';} ?>>Not Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group-row "> -->
                                                <label class="control-label">Certificate <font color="red">*</font></label>
                                                <!-- <div class="col-md-6"> -->
                                                    <input type="file" id="certificate" name="certificate" accept=".jpg, .jpeg, .png, .pdf" onchange="ValidateSingleInput(this);">
                                                    @if($trainer->certificate)
                                                        <a href="{{ Storage::url($trainer->certificate) }}" target="_blank">View Current Certificate</a>
                                                    @endif
                                                <!-- </div> -->
                                            <!-- </div> -->
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

    <style>
        .wrong .fa-check {
            display: none;
        }

        .good .fa-close {
            display: none;
        }
    </style>

<script>
        var _validFileExtensions = [".jpg", ".jpeg", ".png", ".pdf"];    
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
                        swal("Please upload documents in jpg, jpeg, png or pdf format only.", "", "warning");
                        oInput.value = "";
                        return false;
                    }
                }
            }
            return true;
        }

        function emailChecking(val) {
            var id = document.getElementById("id").value;
            var val = val;
            $.ajax({
                type:"GET",
                url:"/trainers/emailchecking/"+id+"/"+val,
                success:function(response){
                    if(response.result == 1) {
                        $('#email').val(response.email_old);
                        swal({
                            title: "Sorry!",
                            text: "This email has been registered in the system. Please use another email.",
                            type: "warning",
                        });
                    }
                }
            });
        }

        function identificationCardChecking(val) {
            var id = document.getElementById("id").value;
            var val = val;
            $.ajax({
                type:"GET",
                url:"/trainers/identificationcardchecking/"+id+"/"+val,
                success:function(response){
                    if(response.result == 1) {
                        $('#profile_identification_card').val(response.identification_card_old);
                        swal({
                            title: "Sorry!",
                            text: "This New I/C Number / Passport has been registered in the system. Please use another New I/C Number / Passport.",
                            type: "warning",
                        });
                    }
                }
            });
        }
</script>

@endsection