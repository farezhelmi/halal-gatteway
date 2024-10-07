@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item">List of Training</li>
                        <li class="breadcrumb-item active">{{ $training->title }}</li>
                    </ol>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <h5><i class="fa-solid fa-user-shield fa-lg"></i>&emsp;<b>Training Information</b></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card card-success">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3"><b>Trainer Name</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $training->trainer->name }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Training Title</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $training->title }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Training Type</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $training->training->name }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>Date of Training</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">{{ $training->training_date }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3"><b>QR Code</b><span style="float: right;"><b>:</b></span></div>
                                        <div class="col-md-9">
                                            <!-- Trigger the modal with a link -->
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#qrCodeModal{{ $training->id }}">
                                                View QR Code
                                            </a>

                                            <!-- Modal for QR Code -->
                                            <div class="modal fade" id="qrCodeModal{{ $training->id }}" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel{{ $training->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="qrCodeModalLabel{{ $training->id }}">QR Code for {{ $training->title }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <!-- Display the QR code -->
                                                            <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(200)->generate(route('attendance/form', ['training_id' => $training->id, 'trainer_id' => $training->trainer_id]))) }}" alt="QR Code">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!-- Button to print the QR code -->
                                                            <button type="button" class="btn btn-primary" onclick="printQRCode({{ $training->id }})">Print QR Code</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                        <a href="{{ route('trainings/edit', $training->id) }}" >
                            <button type="button" class="btn bg-gradient-success" style="width:120px"><b>Update</b> <i class="fa-solid fa-pen-to-square"></i></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection