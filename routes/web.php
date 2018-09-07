<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});


//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
Route::get('/', 'HomeController@index');
Route::get('changepassword', 'HomeController@changepassword');
Route::post('changepassword', 'HomeController@post_changepassword');
Route::post('updatedepartment', 'HomeController@updatedepartment');
Route::get('getFosPara/{id}','DeskController@getFosPara');

// support
Route::get('student_pin', ['uses' =>'SupportController@student_pin','middleware' => 'roles','roles'=>'support']);
Route::get('get_student_pin', ['uses' =>'SupportController@get_student_pin','middleware' => 'roles','roles'=>'support']);
Route::get('get_student_with_entry_year', ['uses' =>'SupportController@get_student_with_entry_year','middleware' => 'roles','roles'=>'support']);
Route::get('create_pin', ['uses' =>'SupportController@get_create_pin','middleware' => 'roles','roles'=>'support']);
Route::post('create_pin', ['uses' =>'SupportController@post_create_pin','middleware' => 'roles','roles'=>'support']);
Route::get('view_unused_pin', ['uses' =>'SupportController@view_unused_pin','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_used_pin', ['uses' =>'SupportController@view_used_pin','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('get_used_pin', ['uses' =>'SupportController@post_used_pin','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('export_pin', ['uses' =>'SupportController@export_pin','middleware' => 'roles','roles'=>'support']);

Route::get('convert_pin', ['uses' =>'SupportController@convert_pin','middleware' => 'roles','roles'=>'support']);

Route::post('convert_pin', ['uses' =>'SupportController@post_convert_pin','middleware' => 'roles','roles'=>'support']);
/*===================================contact ===============================================*/
Route::get('get_serial_number', ['uses' =>'SupportController@post_serial_number','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('contactMail', ['uses' =>'HomeController@contactMail','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('replyemail', ['uses' =>'HomeController@replyemail','middleware' => 'roles','roles'=>['admin','support']]);

//====================== assign hod role========================================
Route::get('assign_hod_role', ['uses' =>'HomeController@assign_hod_role','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('get_lecturer_4_hod', ['uses' =>'HomeController@get_lecturer_4_hod','middleware' => 'roles','roles'=>['admin','support']]);

Route::post('assign_hod', ['uses' =>'HomeController@assign_hod','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_assign_hod', ['uses' =>'HomeController@view_assign_hod','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('remove_hod/{id}', ['uses' =>'HomeController@remove_hod','middleware' => 'roles','roles'=>['admin','support']]);
/*===================================student detail ===============================================*/
Route::get('admin_studentdetails', ['uses' =>'HomeController@admin_studentdetails','middleware' => 'roles','roles'=>['admin','support']]);
// edit images
Route::get('edit_image/{id}', ['uses' =>'HomeController@edit_image','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('edit_image', ['uses' =>'HomeController@post_edit_image','middleware' => 'roles','roles'=>['admin','support']]);
/* ===============================================admin====================================================*/
//get number of registered Students
Route::get('admin_getRegStudents', ['uses' =>'HomeController@admin_getRegStudents','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('admin_getRegStudents', ['uses' =>'HomeController@post_getRegStudents','middleware' => 'roles','roles'=>['admin','support']]);
//get registered Students
Route::get('admin_courseRegStudents', ['uses' =>'HomeController@admin_courseRegStudents','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('admin_courseRegStudents', ['uses' =>'HomeController@post_courseRegStudents','middleware' => 'roles','roles'=>['admin','support']]);

//delete  registered Students
Route::get('delete_courseRegStudents/{id}', ['uses' =>'HomeController@delete_courseRegStudents','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('delete_multiple_courseRegStudents', ['uses' =>'HomeController@delete_multiple_courseRegStudents','middleware' => 'roles','roles'=>['admin','support']]);
// view student
Route::get('admin_viewStudents', ['uses' =>'HomeController@admin_viewStudents','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('admin_viewStudents', ['uses' =>'HomeController@post_viewStudents','middleware' => 'roles','roles'=>['admin','support']]);
// faculty
Route::get('new_faculty', ['uses' =>'HomeController@new_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('new_faculty', ['uses' =>'HomeController@post_new_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_faculty', ['uses' =>'HomeController@view_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('edit_faculty/{id}', ['uses' =>'HomeController@edit_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('post_edit_faculty', ['uses' =>'HomeController@post_edit_faculty','middleware' => 'roles','roles'=>['admin','support']]);
//---------------------------------------------------------------------------------------------------
// department
Route::get('new_department', ['uses' =>'HomeController@new_department','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('new_department', ['uses' =>'HomeController@post_new_department','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_department', ['uses' =>'HomeController@view_department','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('view_department', ['uses' =>'HomeController@post_view_department','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('edit_department/{id}', ['uses' =>'HomeController@edit_department','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('post_edit_department', ['uses' =>'HomeController@post_edit_department','middleware' => 'roles','roles'=>['admin','support']]);
//-----------------------------------------------------------------------------------------------------------------
//programme
Route::get('new_programme', ['uses' =>'HomeController@new_programme','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('new_programme', ['uses' =>'HomeController@post_new_programme','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_programme', ['uses' =>'HomeController@view_programme','middleware' => 'roles','roles'=>['admin','support']]);

//-------------------------------------------------------------------------------------------------------------------
//fos
Route::get('new_fos', ['uses' =>'HomeController@new_fos','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('new_fos', ['uses' =>'HomeController@post_new_fos','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_fos', ['uses' =>'HomeController@view_fos','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('view_fos', ['uses' =>'HomeController@post_view_fos','middleware' => 'roles','roles'=>['admin','support']]);

Route::get('edit_fos/{id}', ['uses' =>'HomeController@edit_fos','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('edit_fos', ['uses' =>'HomeController@post_edit_fos','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('assign_fos', ['uses' =>'HomeController@post_assign_fos','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('assign_fos', ['uses' =>'HomeController@assign_fos','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('assign_fosdesk', ['uses' =>'HomeController@assign_fosdesk','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('/depart/{id}', ['uses' =>'HomeController@getDepartment','middleware' => 'roles','roles'=>['admin','support']]);
//-------------------------------------------------------------------------------------------------------------------
//desk officer
Route::get('new_desk_officer', ['uses' =>'HomeController@new_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('new_desk_officer', ['uses' =>'HomeController@post_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_desk_officer', ['uses' =>'HomeController@view_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('/fos/{id}', ['uses' =>'HomeController@getFos','middleware' => 'roles','roles'=>['admin','support']]);

Route::get('/edit_right/{id}/{e}', ['uses' =>'HomeController@edit_right','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('autocomplete_department',array('as'=>'autocomplete_department','uses'=>'HomeController@autocomplete_department'));

//----------------------------------------------------------------------------------------------------------------
// predegree  create officer 
Route::get('pds_new_desk_officer', ['uses' =>'HomeController@pds_new_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('pds_new_desk_officer', ['uses' =>'HomeController@pds_post_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('pds_view_desk_officer', ['uses' =>'HomeController@pds_view_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);

// predegree create course
Route::get('pds_create_course', ['uses' =>'HomeController@pds_create_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('pds_create_course', ['uses' =>'HomeController@pds_post_create_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('pds_view_course', ['uses' =>'HomeController@pds_view_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('modern_view_course', ['uses' =>'HomeController@modern_view_course','middleware' => 'roles','roles'=>['admin','support']]);
// create course unit
Route::get('create_course_unit', ['uses' =>'HomeController@create_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('create_course_unit', ['uses' =>'HomeController@post_create_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('create_course_unit_special', ['uses' =>'HomeController@create_course_unit_special','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('create_course_unit_special', ['uses' =>'HomeController@post_create_course_unit_special','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_course_unit', ['uses' =>'HomeController@view_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('view_course_unit', ['uses' =>'HomeController@post_view_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('adminreg_course', ['uses' =>'HomeController@adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('get_adminreg_course', ['uses' =>'HomeController@post_adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('delete_adminreg_course/{id}/{s}/{yes?}', ['uses' =>'HomeController@delete_adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('delete_adminreg_multiple_course', ['uses' =>'HomeController@delete_adminreg_multiple_course','middleware' => 'roles','roles'=>['admin','support']]);
// edit course registration 
Route::get('edit_adminreg_course/{id}/{s}', ['uses' =>'HomeController@edit_adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('edit_adminreg_course', ['uses' =>'HomeController@update_adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
// edit of registration
Route::get('deleteRegistration/{id}', ['uses' =>'HomeController@deleteRegistration','middleware' => 'roles','roles'=>['admin','support']]);

//-----------       add course to students ---------------------------------
Route::get('add_adminreg_course/{id}/{s}/{yes?}', ['uses' =>'HomeController@add_adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
//================================================Desk Officer =================

// lecturer
Route::get('new_lecturer', ['uses' =>'DeskController@new_lecturer','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('new_lecturer', ['uses' =>'DeskController@post_new_lecturer','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('edit_lecturer/{id}', ['uses' =>'DeskController@edit_lecturer','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('edit_lecturer/{id}', ['uses' =>'DeskController@post_edit_lecturer','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('view_lecturer', ['uses' =>'DeskController@view_lecturer','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('print_lecturer', ['uses' =>'DeskController@print_lecturer','middleware' => 'roles','roles'=>'Deskofficer']);
// create course
Route::get('new_course', ['uses' =>'DeskController@new_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('new_course', ['uses' =>'DeskController@post_new_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('view_course', ['uses' =>'DeskController@view_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_course', ['uses' =>'DeskController@get_view_course','middleware' => 'roles','roles'=>'Deskofficer']);
// assign courses
Route::get('assign_course', ['uses' =>'DeskController@assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('get_assign_course', ['uses' =>'DeskController@get_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);

Route::get('assign_course_other', ['uses' =>'DeskController@assign_course_other','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('assign_course_other', ['uses' =>'DeskController@post_assign_course_other','middleware' => 'roles','roles'=>'Deskofficer']);

Route::get('getLecturer/{id}', ['uses' =>'DeskController@getLecturer','middleware' => 'roles','roles'=>'Deskofficer']);

Route::post('assign_course', ['uses' =>'DeskController@post_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);

Route::post('assign_course_o', ['uses' =>'DeskController@post_assign_course_o','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('view_assign_course', ['uses' =>'DeskController@view_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_assign_course', ['uses' =>'DeskController@get_view_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('print_assign_course', ['uses' =>'DeskController@print_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('print_assign_course', ['uses' =>'DeskController@get_print_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('remove_assign_course/{id}', ['uses' =>'DeskController@remove_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('delete_multiple_course', ['uses' =>'DeskController@delete_multiple_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('remove_multiple_assign_course', ['uses' =>'DeskController@remove_multiple_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);

// register courses
Route::get('register_course', ['uses' =>'DeskController@register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('register_course', ['uses' =>'DeskController@get_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('reg_course', ['uses' =>'DeskController@post_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('view_register_course', ['uses' =>'DeskController@view_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_register_course', ['uses' =>'DeskController@post_view_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
// delete registered course  
Route::get('delete_register_course', ['uses' =>'DeskController@delete_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('delete_register_course', ['uses' =>'DeskController@post_delete_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('delete_desk_course/{id}/{s}', ['uses' =>'DeskController@delete_desk_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('delete_desk_multiple_course', ['uses' =>'DeskController@delete_desk_multiple_course','middleware' => 'roles','roles'=>'Deskofficer']);

// edit courses
Route::get('edit_course/{id}', ['uses' =>'DeskController@edit_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('edit_course/{id}', ['uses' =>'DeskController@post_edit_course','middleware' => 'roles','roles'=>'Deskofficer']);
// delete course
Route::get('delete_course/{id}', ['uses' =>'DeskController@delete_course','middleware' => 'roles','roles'=>'Deskofficer']);
// student
Route::get('view_student', ['uses' =>'DeskController@view_student','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_student', ['uses' =>'DeskController@post_view_student','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('register_student', ['uses' =>'DeskController@register_student','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('register_student', ['uses' =>'DeskController@post_register_student','middleware' => 'roles','roles'=>'Deskofficer']);
// registered result mode entering

Route::post('entering_result', ['uses' =>'DeskController@enter_result','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('register_student/{fos_id?}/{l_id?}/{semester_id?}/{session?}/{season?}', ['uses' =>'DeskController@get_register_student','middleware' => 'roles','roles'=>'Deskofficer']);

Route::post('more_result', ['uses' =>'DeskController@more_result','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('post_more_result', ['uses' =>'DeskController@post_more_result','middleware' => 'roles','roles'=>'Deskofficer']);
// entering result per course
Route::get('e_result', ['uses' =>'DeskController@e_result','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('e_result', ['uses' =>'DeskController@e_result_next','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('e_result_c', ['uses' =>'DeskController@e_result_c','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('insert_result', ['uses' =>'DeskController@insert_result','middleware' => 'roles','roles'=>'Deskofficer']);

// view result
Route::post('view_result', ['uses' =>'DeskController@post_view_result','middleware' => 'roles','roles'=>['Deskofficer']]);
Route::post('view_result_detail', ['uses' =>'DeskController@view_result_detail','middleware' => 'roles','roles'=>['Deskofficer']]);
Route::get('view_result', ['uses' =>'DeskController@view_result','middleware' => 'roles','roles'=>['Deskofficer']]);

// delete result
Route::post('delete_result', ['uses' =>'DeskController@post_delete_result','middleware' => 'roles','roles'=>['Deskofficer']]);
Route::post('delete_result_detail', ['uses' =>'DeskController@delete_result_detail','middleware' => 'roles','roles'=>['Deskofficer']]);
Route::get('delete_result_detail', ['uses' =>'DeskController@delete_result_detail','middleware' => 'roles','roles'=>['Deskofficer']]);
Route::get('delete_result', ['uses' =>'DeskController@delete_result','middleware' => 'roles','roles'=>['Deskofficer']]);
Route::get('delete_desk_result/{id}', ['uses' =>'DeskController@delete_desk_result','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('delete_desk_multiple_result', ['uses' =>'DeskController@delete_desk_multiple_result','middleware' => 'roles','roles'=>'Deskofficer']);
// report  
Route::get('report', ['uses' =>'DeskController@report','middleware' => 'roles','roles'=>['Deskofficer','examsofficer','HOD']]);
Route::get('getreport', ['uses' =>'DeskController@post_report','middleware' => 'roles','roles'=>['Deskofficer','examsofficer','HOD']]);
Route::get('departmentreport', ['uses' =>'DeskController@departmentreport','middleware' => 'roles','roles'=>['examsofficer','HOD']]);

//================== Exams Officer ===============================================


Route::get('getlevel/{id}',  ['uses' =>'ExamofficerController@getlevel','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('getfos/{id}',  ['uses' =>'ExamofficerController@getfos_hod','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('getsemester/{id}',  ['uses' =>'ExamofficerController@getsemester','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('eo_assign_courses',  ['uses' =>'ExamofficerController@eo_assign_courses','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('eo_result_c', ['uses' =>'ExamofficerController@eo_result_c','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('eo_insert_result', ['uses' =>'ExamofficerController@eo_insert_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('v_result', ['uses' =>'ExamofficerController@post_v_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('v_result', ['uses' =>'ExamofficerController@v_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('d_result', ['uses' =>'ExamofficerController@display_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('lecturer',  ['uses' =>'ExamofficerController@index','middleware' => 'roles','roles'=>['lecturer','HOD']]);
// registere student
Route::get('r_student', ['uses' =>'ExamofficerController@r_student','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('r_student', ['uses' =>'ExamofficerController@post_r_student','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('d_student', ['uses' =>'ExamofficerController@d_student','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
//=========================================PDS===================================================
Route::get('/modern/{id}', ['uses' =>'PdsController@getModern','middleware' => 'roles','roles'=>['science','modern_language']]);
Route::get('pds_student',  ['uses' =>'PdsController@pds_student','middleware' => 'roles','roles'=>['science','modern_language']]);
Route::post('pds_student1',  ['uses' =>'PdsController@pds_get_student','middleware' => 'roles','roles'=>['science','modern_language']]);
Route::post('pds_result',  ['uses' =>'PdsController@pds_result','middleware' => 'roles','roles'=>'science']);
Route::get('pds_enter_result',  ['uses' =>'PdsController@pds_enter_result','middleware' => 'roles','roles'=>['science','modern_language']]);
Route::get('pds_enter_result1',  ['uses' =>'PdsController@pds_get_result','middleware' => 'roles','roles'=>['science','modern_language']]);
Route::post('pds_enter_result1',  ['uses' =>'PdsController@pds_post_result','middleware' => 'roles','roles'=>['science','modern_language']]);
Route::get('pds_view_result',  ['uses' =>'PdsController@pds_view_result','middleware' => 'roles','roles'=>'science']);
Route::post('pds_view_result',  ['uses' =>'PdsController@pds_display_result','middleware' => 'roles','roles'=>'science']);
Route::get('pds_view_course_result',  ['uses' =>'PdsController@pds_view_course_result','middleware' => 'roles','roles'=>'science']);
Route::post('pds_view_course_result',  ['uses' =>'PdsController@pds_display_course_result','middleware' => 'roles','roles'=>'science']);
Route::get('pds_view_final_result',  ['uses' =>'PdsController@pds_view_final_result','middleware' => 'roles','roles'=>'science']);
Route::post('pds_view_final_result',  ['uses' =>'PdsController@pds_display_final_result','middleware' => 'roles','roles'=>'science']);
Auth::routes();
Route::get('logout','Auth\LoginController@logout');


