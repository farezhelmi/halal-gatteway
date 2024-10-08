<?php
use App\Models\Usr\Users;
use App\Models\Sys\Settings;
use App\Http\Controllers\AccessController;
(new AccessController)->permission();

$settings = Settings::where('id', '=', 1)->first();
$path_avatar = 'images/avatar/img.jpg';
if(Auth::User()->profile->path_avatar != null) {
    $path_avatar = Auth::User()->profile->path_avatar;
}

$favicon_path = 'images/favicon/favicon.ico';
if($settings->favicon_path != null) {
    $favicon_path = $settings->favicon_path;
}

$logo_path = 'images/logo/logo.png';
if($settings->logo_path != null) {
    $logo_path = $settings->logo_path;
}
?>

@if (!Auth::check())
  <script>window.location = "{{ route('login') }}";</script> 
@endif

<!-- First Login ************************************************************************************** -->
@if(Auth::User()->first_login == null)
  @if(Route::getCurrentRoute()->getName() != 'user/complete-details')
    <script>window.location = "{{ route('user/complete-details',Auth::id()) }}";</script>
  @endif
@endif
<!-- End First Login ********************************************************************************** -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="{{ secure_asset($favicon_path) }}" type="image/ico" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Halal Gatteway</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ secure_asset('AdminLTE-3.1.0/plugins/ekko-lightbox/ekko-lightbox.css') }}">

    <!-- SweetAlert Style -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('sweetalert-1.1.3/css/sweetalert.min.css') }}">

    <!-- validate-password-requirements Style -->
    <link rel="stylesheet" href="{{ secure_asset('validate-password-requirements/css/jquery.passwordRequirements.css') }}" />

    <!-- fontawesome-free-6.4.2-web -->
    <link href="{{ secure_asset('fontawesome-free-6.4.2-web/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('fontawesome-free-6.4.2-web/css/brands.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('fontawesome-free-6.4.2-web/css/solid.css') }}" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->


    <style>
      /* .select2-selection__rendered {
        line-height: 30px !important;
      } */
      .select2-container .select2-selection--single {
      height: 39px !important;
      }
      .select2-selection__arrow {
       height: 35px !important;
      }

      .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border: 1px solid #007bff;
        color: #fff;
      }
    </style>

  </head>
  
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ secure_asset($logo_path) }}" alt="AdminLTELogo" height="60" width="60">
      </div>

      @include('layouts.header', ['path_avatar' => $path_avatar])

      <aside class="main-sidebar sidebar-dark-success elevation-4">
        <a href="{{ route('/') }}" class="brand-link">
          <img src="{{ secure_asset($logo_path) }}" class="brand-image" style="opacity: .8">
          <span class="brand-text font-weight-light">Halal Gatteway</span>
        </a>

        <div class="sidebar">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ secure_asset($path_avatar) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">{{ Auth::User()->username }}</a>
              <p style="color:grey; font-size:12px;">{{ Auth::User()->role->name }}</p>
            </div>
          </div>

          <!-- Sidebar Menu -->
          @include('layouts.sidebar')
          <!-- /.sidebar-menu -->
          
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- page content -->
      <div class="content-wrapper">
        <section class="content">
          <div class="container-fluid">
            <br>
            @yield('content')
          </div>
        </section>
      </div>
      <!-- /page content -->

      <!-- footer content -->
      @include('layouts.footer')
      <!-- /footer content -->
    </div>

    <!-- jQuery -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/sparklines/sparkline.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/dist/js/adminlte.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Ekko Lightbox -->
    <script src="{{ secure_asset('AdminLTE-3.1.0/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>

    <!-- SweetAlert Style -->
    <script src="{{ secure_asset('sweetalert-1.1.3/js/sweetalert.min.js') }}"></script>

    <!-- Page specific script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
          {
            ranges   : {
              'Today'       : [moment(), moment()],
              'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month'  : [moment().startOf('month'), moment().endOf('month')],
              'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
          },
          function (start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
          format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
          $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function(){
          $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

      })
    </script>

    <script>
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
    </script>

    <script>
      $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
          event.preventDefault();
          $(this).ekkoLightbox({
            alwaysShowClose: true
          });
        });
      })
    </script>

    <script>
      $(document).ready(function() {
        $('.product-image-thumb').on('click', function () {
          var $image_element = $(this).find('img')
          $('.product-image').prop('src', $image_element.attr('src'))
          $('.product-image-thumb.active').removeClass('active')
          $(this).addClass('active')
        })
      })
    </script>

  </body>
</html>
