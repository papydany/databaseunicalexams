<!DOCTYPE html>
<html lang="en">

<head>

    @include('partial._admin_header')

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->

    @include('partial._examsofficer_nav')

    <div id="page-wrapper">

        <div class="container-fluid">
            @include('partial._message')
            @yield('content')

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
@include('partial._admin_script')
 @yield('script')
</body>

</html>