  
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


});
