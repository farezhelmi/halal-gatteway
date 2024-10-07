<?php
use App\Models\Usr\Users;
use App\Models\Sys\Settings;

$users = Users::where('id', '=', Auth::id())->first();
$settings = Settings::where('id', '=', 1)->first();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('gentelella-master/production/images/favicon.ico') }}" type="image/ico" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('gentelella-master/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('gentelella-master/vendors/nprogress/nprogress.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('gentelella-master/build/css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center">
              <h1 class="error-number">500</h1>
              <h2>Internal Server Error</h2>
              <p>We track these errors automatically, but if the problem persists feel free to contact us. In the meantime, try refreshing. <a href="#">Report this?</a>
              </p>
              <p>Log ID : {{ $id }}</p>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('gentelella-master/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
   <script src="{{ asset('gentelella-master/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('gentelella-master/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('gentelella-master/vendors/nprogress/nprogress.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('gentelella-master/build/js/custom.min.js') }}"></script>
  </body>
</html>