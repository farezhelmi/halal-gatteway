@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item">List of user</li>
                        <li class="breadcrumb-item active">{{ $user->username }}</li>
                    </ol>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <h5><i class="fa-solid fa-user-shield fa-lg"></i>&emsp;<b>Profile Information</b></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-success">
                                <div class="card-body">
                                    <?php
                                        $path_avatar = 'images/avatar/img.jpg';
                                        if($user->profile->path_avatar != null) {
                                            $path_avatar = $user->profile->path_avatar;
                                        }
                                    ?>
                                    <center><img class="img-responsive avatar-view" src="{{ asset($path_avatar) }}" width="240px" height="240px"></center>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-success">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3"><b>Role</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $user->role->name }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Email</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $user->email }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Full Name</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $user->profile->name }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>{{ $user->profile->identification_type_id ? $user->profile->identification->name : null }}</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $user->profile->identification_card }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Home Phone</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $user->profile->home_mobile }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Mobile Phone</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $user->profile->phone_mobile }}</div>
                                    </div>
                                    <hr>
                                    <p style="font-size:14px">Last login at : {{ $user->login_last ? date('d/m/Y H:i:s', strtotime($user->login_last)) : '-'; }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url()->previous() }}" >
                            <button type="button" class="btn bg-gradient-primary" style="width:120px"><i class="fa-solid fa-arrow-left"></i> <b>Back</b></button>
                        </a>
                        <a href="{{ route('users/edit',$user->id) }}" >
                            <button type="button" class="btn bg-gradient-success" style="width:120px"><b>Update</b> <i class="fa-solid fa-pen-to-square"></i></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection