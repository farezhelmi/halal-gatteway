@extends('layouts.master')
@section('content')

    <div class="row">   
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                <li class="breadcrumb-item">List of Training</li>
                <li class="breadcrumb-item active">Form Registration</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa-regular fa-clipboard"></i>&emsp;<b>{{ $title }}</b>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ secure_url($route) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <?php $trainingID = $training->id; if($training->id == null) { $trainingID = 0; } ?>
                                    <input type="hidden" id="id" name="id" value="{{ $trainingID }}">
                                    <input type="hidden" id="url_previous" name="url_previous" value="{{ url()->previous() }}">

                                    <div class="card card-success">
                                        <div class="card-body">
                                            <p>Fields marked <font color="red">*</font> are Mandatory.</p>
                                            <hr>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Select Trainer <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <select name="trainer_id" class="form-control" required>
                                                        <option value="" > - Please Select - </option>
                                                        @foreach($trainers as $trainer)
                                                            <option value="{{ $trainer->id }}" {{ $trainer->id == $training->trainer_id ? 'selected' : '' }}>
                                                                {{ $trainer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Title <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <input type="text" name="title" id="title" class="form-control" value="{{ $training->title }}" oninput="this.value = this.value.toUpperCase()" required>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Training Date <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <input type="date" name="training_date" id="training_date" class="form-control" value="{{ $training->training_date }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Training Type <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <select id="training_type_id" name="training_type_id" class="select2 form-control" required="required">
                                                        <option value="" > - Please Select - </option>
                                                        @foreach($training_types as $trainingType)
                                                            <option value="{{ $trainingType->id }}" {{ $trainingType->id == $training->training_type_id ? 'selected' : '' }}>
                                                                {{ $trainingType->name }}
                                                            </option>
                                                        @endforeach             
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="control-label col-md-3">Status <font color="red">*</font></label>
                                                <div class="col-md-9">
                                                    <select id="status_id" name="status_id" class="select2 form-control">
                                                        <option value="1" <?php if($training->status_id == "1") { echo 'selected="selected"';} ?>>Active</option>
                                                        <option value="2" <?php if($training->status_id == "2") { echo 'selected="selected"';} ?>>Not Active</option>
                                                    </select>
                                                </div>
                                            </div>
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