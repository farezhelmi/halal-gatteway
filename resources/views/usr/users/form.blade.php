@extends('layouts.master')
@section('content')
    <div class="row">   
        <div class="col-md-12">
            @if($user->role_id <= 2)
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                    <li class="breadcrumb-item">List of user</li>
                    <li class="breadcrumb-item active">Form Registration</li>
                </ol>
            @else
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                    <li class="breadcrumb-item active">Update User Information</li>
                </ol>
            @endif
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
                            <div class="col-md-3">
                                <div class="card card-success">
                                    <div class="card-body">
                                        <?php
                                            $path_avatar = '/images/avatar/img.jpg';
                                            if($userProfile->path_avatar != null) {
                                                $path_avatar = $userProfile->path_avatar;
                                            }
                                        ?>
                                        <center><img class="img-responsive avatar-view" src="{{ asset($path_avatar) }}" width="200px" height="200px"></center>
                                        <br><br>
                                        <input type="file" id="path_avatar" name="path_avatar" accept=".jpg, .jpeg, .png" onchange="ValidateSingleInput(this);"><br>
                                        <font color="gray" size="2px">Recommended size for avatars : <br>Width (600px) x Height (620px)</font>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <?php $userID = $user->id; if($user->id == null) { $userID = 0; } ?>
                                <input type="hidden" id="id" name="id" value="{{ $userID }}">
                                <input type="hidden" id="url_previous" name="url_previous" value="{{ url()->previous() }}">

                                <div class="card card-success">
                                    <div class="card-body">
                                        <p>Fields marked <font color="red">*</font> are Mandatory.</p>
                                        <hr>
                                        <div class="form-group row ">
                                            <label class="control-label col-md-3">Role <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <select id="role_id" name="role_id" class="select2 form-control" required="required" >
                                                    <option value="">Please Select</option>
                                                    @foreach ($roles as $key => $role)
                                                        <?php
                                                            $select = '';
                                                            if($route == 'users/update') {
                                                                if($role->id == $user->role_id) {
                                                                    $select = 'selected="selected"';
                                                                }
                                                            }
                                                        ?>
                                                        <option value="{{$role->id}}" {{$select}}>{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="control-label col-md-3">Email <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <input type="email" id="email" name="email" value="{{ $user->email }}" onchange="emailChecking(this.value)" required="required" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="control-label col-md-3">Password <?php if($route == 'users/store' || $route == 'registration/store-details') { echo '<font color="red">*</font>'; } ?></label>
                                            <div class="col-md-9">
                                                <input type="password" id="password" name="password" class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" autocomplete="on" <?php if($route == 'users/store') { echo 'required'; } ?> />
                                                <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()" >
                                                    <i id="slash" class="fa fa-eye-slash"></i>
                                                    <i id="eye" class="fa fa-eye"></i>
                                                </span>
                                                <!-- <div class="valid-feedback">GOOD</div> -->
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9">
                                                <div class="alert px-4 py-3 mb-0 d-none" role="alert" data-mdb-color="warning" id="password-alert">
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="requirements leng" style="font-size: 12px;">
                                                            <i class="fa fa-check text-success me-2"></i>
                                                            <i class="fa fa-close text-danger me-3"></i>
                                                            Your password must have at least 8 characters
                                                        </li>
                                                        <li class="requirements big-letter" style="font-size: 12px;">
                                                            <i class="fa fa-check text-success me-2"></i>
                                                            <i class="fa fa-close text-danger me-3"></i>
                                                            Your password must have at least 1 capital letters
                                                        </li>
                                                        <li class="requirements num" style="font-size: 12px;">
                                                            <i class="fa fa-check text-success me-2"></i>
                                                            <i class="fa fa-close text-danger me-3"></i>
                                                            Your password must have at least 1 number
                                                        </li>
                                                        <li class="requirements special-char" style="font-size: 12px;">
                                                            <i class="fa fa-check text-success me-2"></i>
                                                            <i class="fa fa-close text-danger me-3"></i>
                                                            Your password must have at least 1 special character
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="control-label col-md-3">Verify Password <?php if($route == 'users/store' || $route == 'registration/store-details') { echo '<font color="red">*</font>'; } ?></label>
                                            <div class="col-md-9">
                                                <input type="password" id="password_verify" name="password_verify" class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" autocomplete="on" <?php if($route == 'users/store') { echo 'required'; } ?> />
                                                <span style="position: absolute;right:15px;top:7px;" onclick="hideshow_verify()" >
                                                    <i id="slash_verify" class="fa fa-eye-slash"></i>
                                                    <i id="eye_verify" class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        <div class="form-group row ">
                                            <label class="control-label col-md-3">Full Name <font color="red">*</font></label>
                                            <div class="col-md-9">
                                                <input type="text" id="profile_name" name="profile_name" value="{{ $userProfile->name }}" required="required" class="form-control" oninput="this.value = this.value.toUpperCase()">
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
                                                            if($route == 'users/update') {
                                                                if($key == $userProfile->identification_type_id) {
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
                                                <input type="text" id="profile_identification_card" name="profile_identification_card" value="{{ $userProfile->identification_card }}" class="form-control" required="required" onchange="identificationCardChecking(this.value)">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row ">
                                            <label class="control-label col-md-3">Home Phone</label>
                                            <div class="col-md-9">
                                                <input type="number" id="home_mobile" name="home_mobile" value="{{ $userProfile->home_mobile }}" class="form-control">
                                            </div>
                                        </div> -->
                                        <div class="form-group row ">
                                            <label class="control-label col-md-3">Mobile Phone</label>
                                            <div class="col-md-9">
                                                <input type="number" id="phone_mobile" name="phone_mobile" value="{{ $userProfile->phone_mobile }}" class="form-control">
                                            </div>
                                        </div>
                                        @if($user->role_id <= 2)
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Status <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <select id="status_id" name="status_id" class="select2 form-control">
                                                        <option value="1" <?php if($user->status_id == "1") { echo 'selected="selected"';} ?>>Active</option>
                                                        <option value="2" <?php if($user->status_id == "2") { echo 'selected="selected"';} ?>>Not Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" id="status_id" name="status_id" value="{{ $user->status_id }}">
                                        @endif
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
                url:"/users/emailchecking/"+id+"/"+val,
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
                url:"/users/identificationcardchecking/"+id+"/"+val,
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

    <script>
        slash.style.display = "none";

        function hideshow(){
            var password = document.getElementById("password");
            var slash = document.getElementById("slash");
            var eye = document.getElementById("eye");
            
            if(password.type === 'password'){
                password.type = "text";
                slash.style.display = "block";
                eye.style.display = "none";
            }
            else{
                password.type = "password";
                slash.style.display = "none";
                eye.style.display = "block";
            }
        }

        addEventListener("DOMContentLoaded", (event) => {
            const password = document.getElementById("password");
            const passwordAlert = document.getElementById("password-alert");
            const requirements = document.querySelectorAll(".requirements");
            let lengBoolean, bigLetterBoolean, numBoolean, specialCharBoolean;
            let leng = document.querySelector(".leng");
            let bigLetter = document.querySelector(".big-letter");
            let num = document.querySelector(".num");
            let specialChar = document.querySelector(".special-char");
            const specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
            const numbers = "0123456789";

            requirements.forEach((element) => element.classList.add("wrong"));

            password.addEventListener("focus", () => {
                passwordAlert.classList.remove("d-none");
                if (!password.classList.contains("is-valid")) {
                    password.classList.add("is-invalid");
                }
            });

            password.addEventListener("input", () => {
                let value = password.value;
                if (value.length < 8) {
                    lengBoolean = false;
                } else if (value.length > 7) {
                    lengBoolean = true;
                }

                if (value.toLowerCase() == value) {
                    bigLetterBoolean = false;
                } else {
                    bigLetterBoolean = true;
                }

                numBoolean = false;
                for (let i = 0; i < value.length; i++) {
                    for (let j = 0; j < numbers.length; j++) {
                        if (value[i] == numbers[j]) {
                            numBoolean = true;
                        }
                    }
                }

                specialCharBoolean = false;
                for (let i = 0; i < value.length; i++) {
                    for (let j = 0; j < specialChars.length; j++) {
                        if (value[i] == specialChars[j]) {
                            specialCharBoolean = true;
                        }
                    }
                }

                if (lengBoolean == true && bigLetterBoolean == true && numBoolean == true && specialCharBoolean == true) {
                    password.classList.remove("is-invalid");
                    password.classList.add("is-valid");

                    requirements.forEach((element) => {
                        element.classList.remove("wrong");
                        element.classList.add("good");
                    });
                    // passwordAlert.classList.remove("alert-default");
                    // passwordAlert.classList.add("alert-success");
                } else {
                    password.classList.remove("is-valid");
                    password.classList.add("is-invalid");

                    // passwordAlert.classList.add("alert-default");
                    // passwordAlert.classList.remove("alert-success");

                    if (lengBoolean == false) {
                        leng.classList.add("wrong");
                        leng.classList.remove("good");
                    } else {
                        leng.classList.add("good");
                        leng.classList.remove("wrong");
                    }

                    if (bigLetterBoolean == false) {
                        bigLetter.classList.add("wrong");
                        bigLetter.classList.remove("good");
                    } else {
                        bigLetter.classList.add("good");
                        bigLetter.classList.remove("wrong");
                    }

                    if (numBoolean == false) {
                        num.classList.add("wrong");
                        num.classList.remove("good");
                    } else {
                        num.classList.add("good");
                        num.classList.remove("wrong");
                    }

                    if (specialCharBoolean == false) {
                        specialChar.classList.add("wrong");
                        specialChar.classList.remove("good");
                    } else {
                        specialChar.classList.add("good");
                        specialChar.classList.remove("wrong");
                    }
                }
            });

            password.addEventListener("blur", () => {
                passwordAlert.classList.add("d-none");
            });
        });
    </script>

    <script>
        slash_verify.style.display = "none";

        function hideshow_verify(){
            var password = document.getElementById("password_verify");
            var slash = document.getElementById("slash_verify");
            var eye = document.getElementById("eye_verify");
            
            if(password.type === 'password'){
                password.type = "text";
                slash.style.display = "block";
                eye.style.display = "none";
            }
            else{
                password.type = "password";
                slash.style.display = "none";
                eye.style.display = "block";
            }
        }
    </script>

    <script>
        var password = document.getElementById("password")
        , password_verify = document.getElementById("password_verify");

        function validatePassword(){
        if(password.value != password_verify.value) {
            password_verify.setCustomValidity("Passwords Don't Match");
        } else {
            password_verify.setCustomValidity('');
        }
        }

        password.onchange = validatePassword;
        password_verify.onkeyup = validatePassword;
    </script>
@endsection