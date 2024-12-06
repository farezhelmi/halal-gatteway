@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item">List of trainer</li>
                        <li class="breadcrumb-item active">{{ $trainer->name }}</li>
                    </ol>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <h5><i class="fa-solid fa-user-shield fa-lg"></i>&emsp;<b>Trainer Information</b></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card card-success">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3"><b>Name</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $trainer->name }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>IC Number/Passport</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $trainer->identification_no }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Email</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $trainer->email }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Gender</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $trainer->gender }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Mobile Phone</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $trainer->phone_no }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Certificate</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">
                                            @if ($trainer->certificate)
                                                <a href="{{ asset($trainer->certificate) }}" target="_blank" class="btn btn-info btn-sm">View Certificate</a>
                                            @else
                                                No Certificate
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url()->previous() }}" >
                            <button type="button" class="btn bg-gradient-primary" style="width:120px"><i class="fa-solid fa-arrow-left"></i> <b>Back</b></button>
                        </a>
                        <a href="{{ route('trainers/edit',$trainer->id) }}" >
                            <button type="button" class="btn bg-gradient-success" style="width:120px"><b>Update</b> <i class="fa-solid fa-pen-to-square"></i></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection