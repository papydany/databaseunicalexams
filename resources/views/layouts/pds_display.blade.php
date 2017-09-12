<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
 <html lang="en"> 
<head>
 <link href="{{URL::to('cpanel/css/bootstrap.min.css')}}" rel="stylesheet" media="all">
   
</head> 
<style type="text/css">
@media print {

.w2{width: 500px;float: left;clear:all;}


</style>
<body class="home-page">

    <div class="row" style="margin-right: 0px; margin-left: 0px;">
    <div class="col-xs-12" style="padding-top: 10px;padding-bottom:10px;">
    <div class="col-sm-2 w text-center"><img id="logo" src="{{asset('logo.png')}}" alt="Logo">
    </div>
<div class="col-sm-8 w2 text-center">
    <h4><b>UNIVERSITY OF CALABAR CALABAR</b></h4>
    <p>DIRECTORATE OF PRE-DEGREE PROGRAMME</p>
    <?php $next = $ss+1; ?>
  <p class="text-danger">{{$ss.' / '.$next}} ACADEMIC SESSION</p>
   @if(isset($sm)) 
    <p>@if($sm==1)
   FIRST SEMESTER
    @elseif($sm== 2)
sECOND SEMESTER
    @endif</p>
    @endif

  </div>
  </div>
  
 @yield('content')
 
 </div><!--//wrapper-->
    
 
   

 </body>


</html>             
