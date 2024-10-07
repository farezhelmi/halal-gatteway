@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('flash-message')
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="fa-solid fa-house"></i></a></li>
                        <li class="breadcrumb-item">RBAC</li>
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-olive">
                        <div class="card-header">
                            <h3 class="card-title">List of menu</h3>
                            <div class="card-tools">
                                <a href="{{ route('menu/create') }}" >
                                    <button type="button" class="btn btn-success" title="Add New Menu"><i class="fa-solid fa-folder-plus fa-lg"></i>&emsp;<b>Add New Menu</b></button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($menu_parents as $parent)
                                        <div class="card card-info collapsed-card">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <b>{{ $parent->sort; }}.</b>&nbsp;
                                                    <i class="fa {{ $parent->icon; }}"></i> <b>{{ $parent->title; }}</b>
                                                    <?php
                                                        if($parent->status_id == 1) {
                                                            echo '<span class="badge badge-success">'.$parent->status->name.'</span>';
                                                        }

                                                        if($parent->status_id == 2) {
                                                            echo '<span class="badge badge-secondary">'.$parent->status->name.'</span>';
                                                        }
                                                    ?>
                                                    @if($parent->url != '/' && $parent->url != '#')
                                                        <a style="color: white; font-size:14px;" href="{{ route($parent->url,[$parent->parameter]) }}">{{ route($parent->url,[$parent->parameter]) }}</a>
                                                    @endif
                                                </h3>

                                                <div class="card-tools">
                                                    <a href="{{ route('menu/edit-parent',$parent->id) }}" >
                                                        <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                                    </a>
                                                    <a href="{{ route('menu/delete-parent',$parent->id) }}" >
                                                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="navcontainer">
                                            <ul class="to_do" style="padding-left: 50px;">
                                                <?php $menu_1childs = App\Models\Sys\Menu1Childs::where([ ['status_id', '!=', 0], ['parent_id', '=', $parent->id]])->orderBy('sort', 'ASC')->get(); ?>
                                                @foreach($menu_1childs as $child1)
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card card-outline">
                                                                    <div class="card-header">
                                                                        <h3 class="card-title">
                                                                            {{ $child1->sort; }}.&nbsp;
                                                                            {{ $child1->title; }}
                                                                            <?php
                                                                                if($child1->status_id == 1) {
                                                                                    echo '<span class="badge badge-success">'.$child1->status->name.'</span>';
                                                                                }

                                                                                if($child1->status_id == 2) {
                                                                                    echo '<span class="badge badge-secondary">'.$child1->status->name.'</span>';
                                                                                }
                                                                            ?>
                                                                            &emsp;
                                                                            @if($child1->url != '/' && $child1->url != '#')
                                                                                <a style="color: #1999fc;" href="{{ route($child1->url,[$child1->parameter]) }}">{{ route($child1->url,[$child1->parameter]) }}</a>
                                                                            @endif
                                                                        </h3>

                                                                        <div class="card-tools">
                                                                            <a href="{{ route('menu/edit-child1',$child1->id) }}" >
                                                                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                                                            </a>
                                                                            <a href="{{ route('menu/delete-child1',$child1->id) }}" >
                                                                                <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </li>
                                                    <ul class="to_do" style="padding-left: 50px;">
                                                        <?php $menu_2childs = App\Models\Sys\Menu2Childs::where([ ['status_id', '!=', 0], ['parent_id', '=', $parent->id], ['child1_id', '=', $child1->id]])->orderBy('sort', 'ASC')->get(); ?>
                                                        @foreach($menu_2childs as $child2)
                                                            <li>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card card-outline">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">
                                                                                    {{ $child2->sort; }}.&nbsp;
                                                                                    {{ $child2->title; }}
                                                                                    <?php
                                                                                        if($child2->status_id == 1) {
                                                                                            echo '<span class="badge badge-success">'.$child2->status->name.'</span>';
                                                                                        }

                                                                                        if($child2->status_id == 2) {
                                                                                            echo '<span class="badge badge-secondary">'.$child2->status->name.'</span>';
                                                                                        }
                                                                                    ?>
                                                                                    &emsp;
                                                                                    @if($child2->url != '/')
                                                                                        <a style="color: #1999fc;" href="{{ route($child2->url,[$child2->parameter]) }}">{{ route($child2->url,[$child2->parameter]) }}</a>
                                                                                    @endif
                                                                                </h3>

                                                                                <div class="card-tools">
                                                                                    <a href="{{ route('menu/edit-child2',$child2->id) }}" >
                                                                                        <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                                                                    </a>
                                                                                    <a href="{{ route('menu/delete-child2',$child2->id) }}" >
                                                                                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        ul {
            list-style-type: none;
        }
    </style>

@endsection