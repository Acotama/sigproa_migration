<!DOCTYPE html>
<html>
@include('layout.htmlheader')

<style>
  .loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    position: fixed;
    top:40%;
    left: 0;
    right: 0;
    margin: auto;
    z-index: 99999;
  }
</style>

<body class="hold-transition skin-blue sidebar-mini hide">
<div id = "loader" class="loader" style="display: none"></div>
<div class="wrapper">

  @include('layout.mainheader')

  <!-- Left side column. contains the logo and sidebar -->
  @include('layout.lsidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="change">
    <!-- Content Header (Page header) -->
    <!--section class="content-header">
      <h1>
        Dashboard
        <small>Version 2.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section-->

    <!-- Main content -->
    <section class="container-fluid">
      <br>
      <!-- Info boxes -->
      @yield('body')
      <!-- /.row -->

      @include('layout.modal.largemodal')
      @include('layout.modal.simplemodal')
      @include('layout.modal.deletemodal')
      @include('layout.modal.widemodal')
      @include('layout.modal.widemodalPry')
      <!-- /.row -->

      <!-- Main row -->

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('layout.footer')
  <!-- Control Sidebar -->
  @include('layout.rsidebar')

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
@include('layout.htmlfooter')
</body>
</html>
