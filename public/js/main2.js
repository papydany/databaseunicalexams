
$(document).ready(function(){
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
   //====================================

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

   $("#department_id").change( function() {
    $("#myModal").modal(); 
   var id =$(this).val();
     $.getJSON("/fos/"+id, function(data, status){   
     var $d = $("#fos"); 
     $d.empty();
     $d.append('<option value=""> ---- Select ----</option>');
       $.each(data, function(index, value) {
                       $d.append('<option value="' +value.id +'">' + value.fos_name + '</option>');
                   });
                   $("#myModal").modal("hide");
                      });
   
   
   });
});