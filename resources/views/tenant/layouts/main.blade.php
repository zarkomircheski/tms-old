<!doctype html>
<html>
<!-- head  -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    @include('tenant.section_includes.assets')
    @include('tenant.section_includes.script_libraries')
    @include('tenant.section_includes.scripts')

    <title>TMS-TENANT</title>
</head>
<!-- end head -->
<body>

<div id="wrapper">
    <!-- header content -->
@include('tenant.section_includes.header')
<!-- end header contnet -->

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid content_wrapper">
            <!-- main content -->
        @yield('content')
        <!-- end main content -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <!-- footer content -->
    <footer class="row">
        @include('tenant.section_includes.footer')
    </footer>
    <!-- end footer content -->
</div>

</body>
</html>
