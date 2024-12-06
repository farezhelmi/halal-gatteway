@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item">Trainers</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-olive">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa-solid fa-list"></i>&emsp;<b>List of Trainer</b></h3>
                            <div class="card-tools">
                                <a href="{{ route('trainers/create') }}" >
                                    <button type="button" class="btn bg-gradient-success" title="Add New Trainer"><i class="fa fa-plus"></i> <b>Add New Trainer</b></button>
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
                                                <th>Name</th>
                                                <th>Identification No.</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Phone No.</th>
                                                <th>Certificate</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($trainers as $trainer)
                                                <tr>
                                                    <td><center>{{ $i++ }}</center></td>
                                                    <td>{{ $trainer->name }}</td>
                                                    <td>{{ $trainer->identification_no }}</td>
                                                    <td>{{ $trainer->email }}</td>
                                                    <td>{{ $trainer->gender }}</td>
                                                    <td>{{ $trainer->phone_no }}</td>
                                                    <td>
                                                        @if ($trainer->certificate)
                                                            <a href="{{ secure_asset($trainer->certificate) }}" target="_blank" class="btn btn-info btn-sm">View Certificate</a>
                                                        @else
                                                            No Certificate
                                                        @endif
                                                    </td>
                                                    <td><p style="color:{{ $trainer->status->color }}"><b>{{ $trainer->status->name }}</b></p></td>
                                                    <td>
                                                        <center>
                                                            <form action="{{ secure_url('trainers/delete',$trainer->id) }}" method="POST">
                                                                <a href="{{ route('trainers/view',$trainer->id) }}" >
                                                                    <button type="button" class="btn bg-gradient-info btn-sm" title='View'><i class="fa-solid fa-magnifying-glass"></i></button>
                                                                </a>

                                                                <a href="{{ route('trainers/edit',$trainer->id) }}" >
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