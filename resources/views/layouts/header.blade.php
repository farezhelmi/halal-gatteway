<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <?php $notifications = App\Models\Sys\Notifications::where([['user_id', '=', Auth::id()],['is_read','=',0]])->orderBy('id', 'DESC')->get(); ?>
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ count($notifications) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ count($notifications) }} Notifications</span>
                <div class="dropdown-divider"></div>

                <?php $loop_notification = 1; ?>
                @foreach ($notifications as $notis)
                    <?php
                        $time_description = null;
                        $time_lps = strtotime($notis->created_at);
                        $cur_time   = time();
                        $time_elapsed   = $cur_time - $time_lps;
                        $seconds    = $time_elapsed ;
                        $minutes    = round($time_elapsed / 60 );
                        $hours      = round($time_elapsed / 3600);
                        $days       = round($time_elapsed / 86400 );
                        $weeks      = round($time_elapsed / 604800);
                        $months     = round($time_elapsed / 2600640 );
                        $years      = round($time_elapsed / 31207680 );

                        // Seconds
                        if($seconds <= 60){
                            $time_description = "just now";
                        }
                        //Minutes
                        else if($minutes <=60){
                            if($minutes==1){
                                $time_description = "1 mnt lps";
                            }
                            else{
                                $time_description = "$minutes mnt lps";
                            }
                        }
                        //Hours
                        else if($hours <=24){
                            if($hours==1){
                                $time_description = "1 jam lps";
                            }else{
                                $time_description = "$hours jam lps";
                            }
                        }
                        //Days
                        else if($days <= 7){
                            if($days==1){
                                $time_description = "smlm";
                            }else{
                                $time_description = "$days hari lps";
                            }
                        }
                        //Weeks
                        else if($weeks <= 4.3){
                            if($weeks==1){
                                $time_description = "1 mggu lps";
                            }else{
                                $time_description = "$weeks mggu lps";
                            }
                        }
                        //Months
                        else if($months <=12){
                            if($months==1){
                                $time_description = "a bln lps";
                            }else{
                                $time_description = "$months bln lps";
                            }
                        }
                        //Years
                        else{
                            if($years==1){
                                $time_description = "1 thn lps";
                            }else{
                                $time_description = "$years thn lps";
                            }
                        }
                    ?>
                    @if($loop_notification < 8)
                        <a href="{{ route('users/read-notification',$notis->id) }}" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> {{ $notis->title }}
                            <span class="float-right text-muted text-sm">{{ $time_description }}</span>
                        </a>
                    @endif
                    <?php $loop_notification = $loop_notification + 1; ?>
                @endforeach

                <div class="dropdown-divider"></div>
                <a href="{{ route('users/list-notification') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa-solid fa-user-shield fa-lg"></i>
                {{ Auth::User()->username }}
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-outline-secondary btn-block" data-toggle="modal" data-target=".bs-profile-modal-xl"><i class="fa-solid fa-user-pen"></i> PROFILE</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-outline-secondary btn-block" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out pull-right"></i> {{ __('LOGOUT') }}
                        </a>
                        <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<div class="modal fade bs-profile-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-default">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-user-shield fa-lg"></i>&emsp;<b>Profile Information</b></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-success">
                            <div class="card-body">
                                <?php
                                    $path_avatar = 'images/avatar/img.jpg';
                                    if(Auth::User()->profile->path_avatar != null) {
                                        $path_avatar = Auth::User()->profile->path_avatar;
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
                                    <div class="col-md-9">{{ Auth::User()->role->name }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3"><b>Email</b><span style="float: right;"><b>:</b></span></div>
                                    <div class="col-md-9">{{ Auth::User()->email }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3"><b>Full Name</b><span style="float: right;"><b>:</b></span></div>
                                    <div class="col-md-9">{{ Auth::User()->profile->name }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3"><b>{{ Auth::User()->profile->identification_type_id ? Auth::User()->profile->identification->name : null }}</b><span style="float: right;"><b>:</b></span></div>
                                    <div class="col-md-9">{{ Auth::User()->profile->identification_card }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3"><b>Home Phone</b><span style="float: right;"><b>:</b></span></div>
                                    <div class="col-md-9">{{ Auth::User()->profile->phone_home }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3"><b>Mobile Phone</b><span style="float: right;"><b>:</b></span></div>
                                    <div class="col-md-9">{{ Auth::User()->profile->phone_mobile }}</div>
                                </div>
                                <hr>
                                <p style="font-size:14px">Last login at : {{ Auth::User()->login_last ? date('d/m/Y H:i:s', strtotime(Auth::User()->login_last)) : '-'; }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="width:120px" class="close" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-arrow-left"></i>&emsp;<b>Back</b></button>
                <a href="{{ route('users/edit', Auth::User()->id) }}" >
                    <button type="submit" class="btn btn-success" style="width:120px"><b>Update</b>&emsp;<i class="fa-solid fa-pen-to-square"></i></button>
                </a>
            </div>
        </div>
    </div>
</div>