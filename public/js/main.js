  
    $(document).ready(function(){


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



$("#department_id").change( function() {
 $("#myModal").modal(); 
var id =$(this).val();
  $.getJSON("/fos/"+id, function(data, status){   
  var $d = $("#fos_id"); 
  $d.empty();
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

  var dr =Number(data.duration) + 2;
  var dd =Number(data.duration);
  var pg =Number(data.programme_id);
$('#duration').val(dd);

  for (var i = 1; i <= dr; i++) {
    if(i < dd)
    {
      $l.append('<option value="' +i +'">' + i+ '00' +'</option>');
    }else if(i == dd)
    {
        $l.append('<option value="' +i +'~'+'f'+'">' + i+ '00 (Final)' +'</option>');
    }
    else if(i > dd)
    {
        $l.append('<option value="' +i +'~'+'s'+'">' + i+ '00 (Spill Over)' +'</option>');
    }
  }
$rt.append('<option value="' +0 +'"> --- Select --- </option>');
  if(pg == 3)
  {
     
     $rt.append('<option value="' +1 +'">Sessional Result</option>');
     $rt.append('<option value="' +2 +'">Omited Result </option>');
     $rt.append('<option value="' +3 +'"> Correctional Result </option>');
  }else if(pg == 2)
  {
  
     $rt.append('<option value="' +11 +'">Sessional Result</option>');
     $rt.append('<option value="' +12 +'">Resit Result </option>');
   
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
