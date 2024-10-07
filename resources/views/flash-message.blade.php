@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fa fa-check"></i> SUCCESS</h5>
        {{ $message }}
    </div>
@endif 
    
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> FAIL</h4>
        {{ $message }}
    </div>
@endif
     
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> WARNING</h4>
        {{ $message }}
    </div>
@endif
     
@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> INFO</h4>
        {{ $message }}
    </div>
@endif
    
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> FAIL</h4>
        <strong>Please check the form below for errors</strong>
    </div>
@endif

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    $(".alert").delay(4000).slideUp(600, function() {
        $(this).alert('close');
    });
</script>