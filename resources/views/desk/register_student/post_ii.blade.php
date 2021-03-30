<!-- ======== =============== for student course reg ========================================-->
                        
{{! $course =DB::connection('mysql2')->table('course_regs')
                         ->where('studentreg_id',$v->id)
                         ->orderBy('course_code','ASC')
                         ->get()
                         }}
@if(isset($course))
@if(count($course) > 0)


                                <div id="myModal{{$v->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/entering_result') }}" data-parsley-validate>
                                        {{ csrf_field() }}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title text-center text-danger">{{strtoupper($v->surname." ".$v->firstname." ".$v->othername)}}</h4>
                                        <h4 class="modal-title text-center text-success">{{$v->matric_number}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 5px;">
                                        <div class="col-sm-1 text-center" >
                                         
                                        </div>
                                        <div class="col-sm-3 text-center" >Code</div>
                                        <div class="col-sm-2 text-center" >Unit</div>
                                        <div class="col-sm-2 text-center" >CA</div>
                                        <div class="col-sm-2 text-center" >Exams</div>
                                        <div class="col-sm-2 text-center" >Total</div>
                                         <input type="hidden" name="fos_id" value="{{$v->fos_id}}"/>
                                            <input type="hidden" name="user_id" value="{{$v->user_id}}"/>
                                            <input type="hidden" name="matric_number" value="{{$v->matric_number}}"/>
                                            <input type="hidden" name="session_id" value="{{$v->session}}"/>
                                            <input type="hidden" name="semester_id" value="{{$v->semester}}"/>
                                            <input type="hidden" name="level_id" value="{{$v->level_id}}"/>
                                            <input type="hidden" name="season" value="{{$v->season}}"/>
                                              <input type="hidden" name="entry_year" value="{{$v->entry_year}}"/>
                                            </div>
                                        @foreach($course as $vv)
<!-- ================================== for student result ========================================-->
                        {{! $result =DB::connection('mysql2')->table('student_results')
                         ->where('coursereg_id',$vv->id)
                         ->get()
                         }}        
                                            <div class="col-sm-offset-1 col-sm-10" style="margin-bottom: 9px;">
                                            <div class="col-sm-1" > <input type="checkbox" name="chk[]" value="{{$vv->id}}"/></div>
                                            <div class="col-sm-3 text-center text-success" > {{$vv->course_code}}</div>
                                            <div class="col-sm-2 text-center text-info" >{{$vv->course_unit}}</div>
                                          
                                            @if(count($result) > 0)
                                            @foreach($result as $rv)
                                              <div class="col-sm-2 text-center text-danger">
 <input type="text" class="form-control" name="ca[{{$rv->id}}]" onKeyUp="CA(this,'exam{{$rv->id}}','d{{$rv->id}}')" value="{{$rv->ca}}" id="ca{{$rv->id}}"/>
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="exam[{{$rv->id}}]"  onKeyUp="updA(this,'ca{{$rv->id}}','d{{$rv->id}}')" value="{{$rv->exam}}" id="exam{{$rv->id}}" />
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="total[{{$rv->id.'~'.$vv->id.'~'.$vv->course_id.'~'.$vv->course_unit}}]" value="{{$rv->total}}" id="d{{$rv->id}}" readonly />
</div>
                                            @endforeach
                                            @else
    <div class="col-sm-2 text-center text-danger">                                          
 <input type="text"  class="form-control" name="ca[{{$vv->id}}]" onKeyUp="CA(this,'exam{{$vv->id}}','d{{$vv->id}}')" value="" id="ca{{$vv->id}}"/>
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="exam[{{$vv->id}}]" onKeyUp="updA(this,'ca{{$vv->id}}','d{{$vv->id}}')" value="" id="exam{{$vv->id}}"/>
</div>
  <div class="col-sm-2 text-center text-danger">
 <input type="text"  class="form-control" name="total[{{$vv->id.'~'.$vv->course_id.'~'.$vv->course_unit}}]" value="" id="d{{$vv->id}}"  readonly/>
</div>
                                            @endif
                                               

                                                
                                                </div>
                                                <div class="clearfix"></div>


                                            @endforeach



                                    </div>
                                    <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger" name="delete" value="delete">Delete</button>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                        

                            </div>
                        </div>
                            @endif
                        @endif
</form>
                    @endforeach
                </table>
                 <!--<button type="submit" class="btn btn-danger">Submit</button>-->
                </form>
               
              