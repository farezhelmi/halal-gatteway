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
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-olive">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa-solid fa-list"></i>&emsp;<b>List of Training</b></h3>
                            <div class="card-tools">
                                <a href="{{ route('trainings/create') }}" >
                                    <button type="button" class="btn bg-gradient-success" title="Add New Training"><i class="fa fa-plus"></i> <b>Add New Training</b></button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No.</th>
                                                <th>Trainer Name</th>
                                                <th>Title.</th>
                                                <th>Training Date</th>
                                                <th>Training Type</th>
                                                <th>QR Code</th>
                                                <th>View Attendance</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($trainings as $training)
                                                <tr>
                                                    <td><center>{{ $i++ }}</center></td>
                                                    <td>{{ $training->trainer->name }}</td>
                                                    <td>{{ $training->title }}</td>
                                                    <td>{{ $training->training_date }}</td>
                                                    <td>{{ $training->training->name }}</td>
                                                    <td>
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
                                                    </td>
                                                    <td><a href="{{ route('attendance/list-attendance', $training->id) }}" class="btn btn-info btn-sm">
                                                            View Attendance
                                                        </a></td>
                                                    <td><p style="color:{{ $training->status->color }}"><b>{{ $training->status->name }}</b></p></td>
                                                    <td>
                                                        <center>
                                                            <form action="{{ route('trainings/delete',$training->id) }}" method="POST">
                                                                <a href="{{ route('trainings/view',$training->id) }}" >
                                                                    <button type="button" class="btn bg-gradient-info btn-sm" title='View'><i class="fa-solid fa-magnifying-glass"></i></button>
                                                                </a>

                                                                <a href="{{ route('trainings/edit',$training->id) }}" >
                                                                    <button type="button" class="btn bg-gradient-primary btn-sm" title='Edit'><i class="fa fa-edit"></i></button>
                                                                </a>

                                                                @csrf
                                                                <button type="submit" class="btn bg-gradient-danger btn-sm show_confirm" title='Delete'>
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printQRCode(trainingId) {
        var modal = document.getElementById('qrCodeModal' + trainingId);
        var printContents = modal.querySelector('.modal-body').innerHTML;

        // Get additional details like logo, training title, and date
        var trainingTitle = "{{ $training->title }}";
        var trainingDate = "{{ \Carbon\Carbon::parse($training->training_date)->format('F j, Y') }}";
        var logoUrl = "{{ asset('images/logo/logo.png') }}";

        // Open a new tab
        var newTab = window.open('', '_blank');

        // Write the content into the new tab
        newTab.document.write('<html><head><title>Print QR Code</title>');
            
        // Add custom styles for borders and design
        newTab.document.write('<style>');
        newTab.document.write('body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }');
        newTab.document.write('.container { border: 2px solid #333; padding: 20px; width: 60%; margin: auto; border-radius: 10px; }');
        newTab.document.write('.header { margin-bottom: 20px; }');
        newTab.document.write('.header img { width: 100px; height: auto; }');
        newTab.document.write('.header h3 { margin: 10px 0; }');
        newTab.document.write('.qr-code { border: 1px solid #ccc; padding: 10px; display: inline-block; }');
        newTab.document.write('</style>');
            
        newTab.document.write('</head><body>');

        // Insert logo, title, date, and QR code inside a container
        newTab.document.write('<div class="container">');
        newTab.document.write('<div class="header">');
        newTab.document.write('<img src="' + logoUrl + '" alt="Logo"/><br>'); // Logo
        newTab.document.write('<h3>' + trainingTitle + '</h3>'); // Training Title
        newTab.document.write('<p>Date: ' + trainingDate + '</p>'); // Training Date
        newTab.document.write('</div>');

        // Insert the QR code with a border
        newTab.document.write('<div class="qr-code">');
        newTab.document.write(printContents);
        newTab.document.write('</div>');

        newTab.document.write('</div>'); // Close container

        newTab.document.write('</body></html>');

        // Close the document to finish writing and load the contents
        newTab.document.close();

        // Wait for the new tab to fully load, then trigger print and close the tab
        newTab.onload = function () {
            newTab.focus();
            newTab.print();
            newTab.onafterprint = function () {
                newTab.close();
            };
        };
    }   
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.show_confirm').click(function(event) {
                event.preventDefault();
                var form = $(this).parents('form');

                swal({
                    title: "Are you sure?",
                    text: "If you delete this data, it will be gone forever.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection