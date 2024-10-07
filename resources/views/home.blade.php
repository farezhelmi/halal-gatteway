@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
         @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house" style="color: #065101;"></i></a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-secondary">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Trainer</span>
                                <span class="info-box-number">0</span>
                            </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-secondary mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-user-tie"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Consultant</span>
                                <span class="info-box-number">0</span>
                            </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-secondary mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-users-between-lines"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Client</span>
                                <span class="info-box-number">0</span>
                            </div>

                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box bg-secondary mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total User</span>
                                <span class="info-box-number">0</span>
                            </div>

                    </div>

                </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-12">
                <div class="card col-md-12 bg-secondary">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Upcoming Training</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Taining Name</th>
                                        <th>Training type</th>
                                        <th>Total Participants</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Halal Certificate Course</td>
                                        <td>Halal Certificate</td>
                                        <td>30</td>
                                        <td>2024-11-02</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Halal Certificate Course</td>
                                        <td>Halal Certificate</td>
                                        <td>30</td>
                                        <td>2024-11-02</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Halal Certificate Course</td>
                                        <td>Halal Certificate</td>
                                        <td>30</td>
                                        <td>2024-11-02</td>
                                    </tr>              
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary float-right">View All Training</a>
                    </div>

                </div>
            </div></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
        </div>
    </div>
@endsection
