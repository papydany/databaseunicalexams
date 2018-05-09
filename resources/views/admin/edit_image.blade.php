@extends('layouts.admin')
@section('title','Edit Image')
@section('content')
<div class="row">
  <div class="col-lg-12">
     <ol class="breadcrumb">
      <li class="active">
        <i class="fa fa-dashboard"></i> Dashboard
      </li>
      </ol>
  </div>
</div>
 <div class="row" style="min-height: 520px;">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Edit Images</div>
                <div class="panel-body">
                           <div class="page-content">
                    <div class="col-sm-12" style="padding: 0;">
                        <form class="form-horizontal" role="form" method="POST" action="{{url('edit_image')}}""  enctype="multipart/form-data" data-parsley-validate">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$u->id}}">

                             <div class="col-sm-4">
                              <label for="entry_month" class=" control-label">Passport ( <span class="text-danger">Max size 200 * 200)</span></label>
                            <input type="file" name="image_url" class="form-control">
                             
                            </div>
                            <div class="col-sm-4">
                                <br/>
                                <input type="submit" name="" value="Update" class="btn btn-warning">
                            </div>
                        </form>
  </div> 
                </div> 
                    </div>
                </div>
            </div>
        </div>

 @endsection                           