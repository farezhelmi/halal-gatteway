@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item">Training</li>
                        <li class="breadcrumb-item">List Attendance</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-olive">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa-solid fa-list"></i>&emsp;<b>Attendance for Training: {{ $training->title }}</b></h3>
                            <div class="card-tools">
                                <a href="{{ route('certificates.bulk', ['trainingId' => $training->id]) }}" class="btn bg-gradient-primary">
                                    <i class="fa-solid fa-file"></i> Bulk Certificate
                                </a>
                                <a href="{{ route('attendance.printPDF', ['trainingId' => $training->id]) }}" class="btn bg-gradient-danger">
                                    <i class="fa-solid fa-file-pdf"></i> Print Attendance
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <b>Training Type : {{ $training->training->name }}</b>
                            <hr>
                            <b>Attendance : {{ count($attendances) }}</b>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th>Name</th>
                                                <th>Army ID.</th>
                                                <th>Identification No.</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Phone No.</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($attendances as $attendance)
                                                <tr>
                                                    <td><center>{{ $i++ }}</center></td>
                                                    <td>{{ $attendance->name }}</td>
                                                    <td>{{ $attendance->army_id }}</td>
                                                    <td>{{ $attendance->identification_no }}</td>
                                                    <td>{{ $attendance->email }}</td>
                                                    <td>{{ $attendance->gender }}</td>
                                                    <td>{{ $attendance->phone_no }}</td>
                                                    <td>
                                                        <a href="{{ route('attendance.generateCertificate', ['training_id' => $training->id, 'attendance_id' => $attendance->id]) }}" class="btn btn-primary">
                                                            Generate Certificate
                                                        </a>
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="modal-footer">
                                <a href="{{ route('certificates.bulk', ['trainingId' => $training->id]) }}" class="btn bg-gradient-primary">
                                    <i class="fa-solid fa-file"></i> Bulk Certificate
                                </a>
                                <button type="submit" class="btn bg-gradient-success" style="width:120px"><b>Save</b> <i class="fa-solid fa-floppy-disk"></i></button>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection