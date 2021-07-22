@extends('layouts.admin')
@section('title','student management')
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
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Student Management</div>
            <div class="panel-body">
            <ul>
                   <li style="padding: 5px">
                        <a href="{{url('studentManagementAddCourses')}}" target='blank'>Add Courses</a>
                    </li>
                    <li style="padding: 5px">
                        <a href="{{url('studentManagementAddRepeatCourses')}}" target='blank'>Add Repeat Courses</a>
                    </li>
                    <li style="padding: 5px">
                        <a href="{{url('studentManagementAddCarryOverCourses')}}" target='blank'>Add CarryOver Courses</a>
                    </li>
                    <li style="padding: 5px">
                        <a href="{{url('create_course_unit_special')}}" target='blank'>Set Course unit</a>
                    </li>
                   
                    <li style="padding: 5px">
                        <a href="{{url('view_course_unit')}}" target='blank'>View Set Course unit</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection