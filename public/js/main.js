  
    $(document).ready(function(){

$("#all_ids").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.ids').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$("#fos").change( function() {
  $("#myModal").modal();	
 var id =$(this).val();
 //$("#lga").hide();
    $.getJSON("/sfos/"+id, function(data, status){
     var $d = $("#sfos");
     
              $d.empty();
              $d.append('<option value="">Select </option>');
              if(data == '')
              {
                $d.append('<option value="0">No Specialization</option>');
              }else{
                $d.append('<option value="0">No Specialization for this level</option>');
                 $.each(data, function(index, value) {
              
                     $d.append('<option value="' +value.id +'">' + value.name + '</option>');
                   
                 });
                }
                
                 $("#myModal").modal("hide");
     });
 
 
 });

$("#faculty_id").change( function() {
 $("#myModal").modal();	
var id =$(this).val();
//$("#lga").hide();
   $.getJSON("/depart/"+id, function(data, status){
    var $d = $("#department_id");
             $d.empty();
               $d.append('<option value="">Select Department</option>');
                $.each(data, function(index, value) {
                    $d.append('<option value="' +value.id +'">' + value.department_name + '</option>');
                });
                $("#myModal").modal("hide");
    });


});

$("#faculty_id1").change( function() {
  $("#myModal").modal();	
 var id =$(this).val();
 //$("#lga").hide();
    $.getJSON("/depart/"+id, function(data, status){
     var $d = $("#department_id1");
              $d.empty();
                $d.append('<option value="">Select Department</option>');
                 $.each(data, function(index, value) {
                     $d.append('<option value="' +value.id +'">' + value.department_name + '</option>');
                 });
                 $("#myModal").modal("hide");
     });
 
 
 });

 $("#faculty_id2").change( function() {
  $("#myModal").modal();	
 var id =$(this).val();
 //$("#lga").hide();
    $.getJSON("/depart/"+id, function(data, status){
     var $d = $("#department_id2");
              $d.empty();
                $d.append('<option value="">Select Department</option>');
                 $.each(data, function(index, value) {
                     $d.append('<option value="' +value.id +'">' + value.department_name + '</option>');
                 });
                 $("#myModal").modal("hide");
     });
 
 
 });

$("#fac_id").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();
//$("#lga").hide();
   $.getJSON("/depart/"+id, function(data, status){
    var $d = $("#dept_id");
             $d.empty();
               $d.append('<option value="">Select Department</option>');
                $.each(data, function(index, value) {
                    $d.append('<option value="' +value.id +'">' + value.department_name + '</option>');
                });
                $("#myModal").modal("hide");
    });


});

$("#m_fac_id").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();
//$("#lga").hide();
   $.getJSON("/depart/"+id, function(data, status){
    var $d = $("#m_dept_id");
             $d.empty();
               $d.append('<option value="">Select Department</option>');
                $.each(data, function(index, value) {
                    $d.append('<option value="' +value.id +'">' + value.department_name + '</option>');
                });
                $("#myModal").modal("hide");
    });


});

$("#dept_id").change( function() {
 $("#myModal").modal(); 
var i =$(this).val();
//$("#lga").hide();
   $.getJSON("/username/"+i, function(data, status){
    var $d = $("#officer_id");
             $d.empty();
               $d.append('<option value="">Select Desk Officer</option>');
                $.each(data, function(index, value) {
                    $d.append('<option value="' +value.id +'">' + value.username + " - ("+ value.name+')</option>');
                });
                $("#myModal").modal("hide");
    });


});



$("#programme_id").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();
//$("#lga").hide();
   $.getJSON("/getlevel/"+id, function(data, status){
    var $l = $("#level_id");
             $l.empty();
               $l.append('<option value="">Select Level</option>');
                $.each(data, function(index, value) {
                    $l.append('<option value="'+ value.level_id +'">' + value.level_name + '</option>');
                });
              
    });

 $.getJSON("/getsemester/"+id, function(data, status){
    var $s = $("#semester_id");
             $s.empty();
               $s.append('<option value="">Select semester</option>');
                $.each(data, function(index, value) {
                    $s.append('<option value="' +value.semester_id +'">' + value.semester_name + '</option>');
                });
                $("#myModal").modal("hide");
    });
});

$("#p_id").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();
//$("#lga").hide();
   $.getJSON("/getfos/"+id, function(data, status){
    var $fos_id = $("#fos_id");
             $fos_id.empty();
               $fos_id.append('<option value="">Field Of Study</option>');
                $.each(data, function(index, value) {
                    $fos_id.append('<option value="'+ value.id +'">' + value.fos_name + '</option>');
                });
             $("#myModal").modal("hide"); 
    });


});


$("#department_id").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();
  $.getJSON("/fos/"+id, function(data, status){   
  var $d = $("#fos_id"); 
  $d.empty();
  $d.append('<option value=""> ---- Select ----</option>');
    $.each(data, function(index, value) {
                    $d.append('<option value="' +value.id +'">' + value.fos_name + '</option>');
                });
                $("#myModal").modal("hide");
                   });


});

$("#department_id2").change( function() {
  $("#myModal").modal(); 
 var id =$(this).val();
   $.getJSON("/fos/"+id, function(data, status){   
   var $d = $("#fos_id2"); 
   $d.empty();
   $d.append('<option value=""> ---- Select ----</option>');
     $.each(data, function(index, value) {
                     $d.append('<option value="' +value.id +'">' + value.fos_name + '</option>');
                 });
                 $("#myModal").modal("hide");
                    });
 
 
 });

$("#department").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();
  $.getJSON("/getLecturer/"+id, function(data, status){   
  var $d = $("#Lecturer"); 
  $d.empty();
     $d.append('<option value=" ">  -- select -- </option>');
    $.each(data, function(index, value) {
                    $d.append('<option value="' +value.id +'">' + value.title +" &nbsp;&nbsp;"+ value.name +'</option>');
                });
                $("#myModal").modal("hide");
                   });


});
$("#semester").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();

  $.getJSON("/modern/"+id, function(data, status){   
  var $d = $("#course"); 
  $d.empty();
    $.each(data, function(index, value) {
                    $d.append('<option value="' +value.id +'">' + value.code+ '</option>');
                });
                $("#myModal").modal("hide");
                   });


});

$("#fos_id").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();

  $.getJSON("/getFosPara/"+id, function(data, status){   
  var $l = $("#level_id"); 
  var $rt = $("#result_type"); 
  $l.empty();
  $rt.empty();
// fos id for medicine
var fosIDMEDICINE =786;
  var dr =Number(data.duration) + 2;
  var dd =Number(data.duration);
  var pg =Number(data.programme_id);
$('#duration').val(dd);

  for (var i = 1; i <= dr; i++) {
    if(i < dd)
    {
      if(id == fosIDMEDICINE && i > 2)
      {
        var part =i -2;
      $l.append('<option value="' +i +'">' + 'PART'+ part +'</option>');
      }else{
      $l.append('<option value="' +i +'">' + i+ '00' +'</option>');
    }
    }else if(i == dd)
    {
      if(id == fosIDMEDICINE && i > 2)
      {
        var part =i -2;
      $l.append('<option value="' +i +'">' + 'PART'+ part +'</option>');
      }else{
        $l.append('<option value="' +i +'~'+'f'+'">' + i+ '00 (Final)' +'</option>');
      }
    }
    else if(i > dd)
    {
      if(id != fosIDMEDICINE)
      {
        $l.append('<option value="' +i +'~'+'s'+'">' + i+ '00 (Spill Over)' +'</option>');
      }
    }
  }
$rt.append('<option value="' +0 +'"> --- Select --- </option>');
if(pg == 3 && id== fosIDMEDICINE)
{ 
  $rt.append('<option value="' +1 +'">Sessional Result</option>');
  $rt.append('<option value="' +5 +'">Resit Result </option>');
  $rt.append('<option value="' +6 +'">Select Individual Result </option>');
 
}
else if(pg == 3)
  {
     
     $rt.append('<option value="' +1 +'">Sessional Result</option>');
     $rt.append('<option value="' +2 +'">Omited Result </option>');
     $rt.append('<option value="' +3 +'">Probational Result </option>');
     $rt.append('<option value="' +4 +'">Correctional Result </option>');
     $rt.append('<option value="' +5 +'">Long Vacation Result </option>');
     $rt.append('<option value="' +6 +'">Select Individual Result </option>');
     $rt.append('<option value="' +7 +'">Mid-Year Summer Result </option>');

  }else if(pg == 2)
  {
  
     $rt.append('<option value="' +11 +'">Sessional Result</option>');
     $rt.append('<option value="' +12 +'">Resit Result </option>');
     $rt.append('<option value="' +13 +'">Correctional Result </option>');
   
  }
              
                   }
                   );

 

     $("#myModal").modal("hide");


});




$('#updatedepartment').click(function(event){ 
event.preventDefault();


$("#myModal").modal(); 
  
 $.post("updatedepartment",
    { 
      faculty_id:$('#faculty_id').val(),
      user_id:$('input[name=user_id]').val(),
      department_id:$('#department_id').val(),
      fos_id:$('#fos_id').val(),
     _token: $('input[name=_token]').val()
    },
    function(data, status){
if(status == 'success')
{
 window.location.reload();      
}

});

 $("#myModal").modal("hide");      
  });
});
