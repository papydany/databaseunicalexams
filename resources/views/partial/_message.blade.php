@if(Session::has('success'))
<div class="row">
    <div class=" col-sm-10 col-sm-offset-1 alert alert-success" role="alert" >
        <strong>Success: </strong>{{Session::get('success')}}    <i class="fa fa-fw fa-check-circle fa-lg" style="color:green"></i> 
    </div>
</div>
    @endif

    @if(Session::has('warning'))
    <div class="row">
    <div class=" col-sm-10 col-sm-offset-1 alert alert-warning" role="alert" >
      {{Session::get('warning')}}
    </div>
</div>
    @endif
  @if(Session::has('danger'))
    <div class="row">
    <div class=" col-sm-10 col-sm-offset-1 alert alert-danger" role="alert" >
      {{Session::get('danger')}}
    </div>
</div>
    @endif


@if(count($errors) > 0)
<div class="row">
    <div class="col-sm-10 col-sm-offset-1 alert alert-danger" role="alert" >

        <strong>Error <i class="fa fa-times" aria-hidden="true"></i></strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
        </ul>
    </div>
    </div>

    @endif