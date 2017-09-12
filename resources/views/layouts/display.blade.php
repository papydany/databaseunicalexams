<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>@yield('title')</title>

<!-- Bootstrap Core CSS -->
<link href="{{URL::to('panel/css/bootstrap.min.css')}}" rel="stylesheet">

</head>
<style type="text/css">
@media print {
  .www{width: 500;float: left;}
	.ww{width: 500;float: right;}
}


.row {
    margin-right:0px;
    margin-left: 0px;
    margin-top: 5px;
}
</style>
<body>

@yield('content')

</body>

</html>