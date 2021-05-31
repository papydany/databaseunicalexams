<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('optimize');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:

Route::get('/', 'HomeController@index');
Route::get('changepassword', 'HomeController@changepassword');
Route::post('changepassword', 'HomeController@post_changepassword');
Route::post('updatedepartment', 'HomeController@updatedepartment');
Route::post('updatedepartment2', 'GeneralController@updatedepartment');
Route::get('getFosPara/{id}','DeskController@getFosPara');
Route::get('changeemail', 'HomeController@changeemail');
Route::post('changeemail', 'HomeController@post_changeemail');
Route::get('password_reset', 'Auth\ForgotPasswordController@password_reset');
Route::post('password_reset', 'Auth\ForgotPasswordController@post_password_reset');
Route::get('password_reset/{token}', 'Auth\ForgotPasswordController@password_reset_token');
Route::post('password_reset_token', 'Auth\ForgotPasswordController@post_password_reset_token');
Route::get('getsemester/{id}','ExamofficerController@getsemester');

Route::get('getlevel/{id}','ExamofficerController@getlevel');
Route::get('getlevel/{id}','ExamofficerController@getlevel');
Route::get('username/{id}', 'HomeController@username');
Route::get('/depart/{id}', 'HomeController@getDepartment');
Route::get('/fos/{id}', 'HomeController@getFos');
Route::get('sfos/{id}', 'HomeController@Sfos');
Route::get('sfos', 'HomeController@Sfos');


// support
Route::get('student_pin', ['uses' =>'SupportController@student_pin','middleware' => 'roles','roles'=>['support','Deskofficer','admin']]);
Route::get('get_student_pin', ['uses' =>'SupportController@get_student_pin','middleware' => 'roles','roles'=>['support','Deskofficer','admin']]);
Route::get('get_student_with_entry_year', ['uses' =>'SupportController@get_student_with_entry_year','middleware' => 'roles','roles'=>'support']);
Route::get('create_pin', ['uses' =>'SupportController@get_create_pin','middleware' => 'roles','roles'=>'support']);
Route::post('create_pin', ['uses' =>'SupportController@post_create_pin','middleware' => 'roles','roles'=>'support']);
Route::get('view_unused_pin', ['uses' =>'SupportController@view_unused_pin','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_used_pin', ['uses' =>'SupportController@view_used_pin','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('get_used_pin', ['uses' =>'SupportController@post_used_pin','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('export_pin', ['uses' =>'SupportController@export_pin','middleware' => 'roles','roles'=>'support']);

Route::get('convert_pin', ['uses' =>'SupportController@convert_pin','middleware' => 'roles','roles'=>['admin','support']]);

Route::post('convert_pin', ['uses' =>'SupportController@post_convert_pin','middleware' => 'roles','roles'=>['admin','support']]);

//reset pin
Route::get('reset_pin', ['uses' =>'SupportController@reset_pin','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);

Route::post('reset_pin', ['uses' =>'SupportController@reset_pin','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
//=========================== update email account for lecturers =====================
Route::get('update_email/{id}', 'HomeController@update_email');
Route::post('update_email', 'HomeController@post_update_email');
//==========================================report ====================================

/*Route::get('getreport', ['uses' =>'DeskController@post_report','middleware' => 'roles','roles'=>['Deskofficer','examsofficer','HOD','admin','support']]);*/
/*===================================contact ===============================================*/
Route::get('get_serial_number', ['uses' =>'SupportController@post_serial_number','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('contactMail', ['uses' =>'HomeController@contactMail','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('replyemail', ['uses' =>'HomeController@replyemail','middleware' => 'roles','roles'=>['admin','support']]);
//=============================== transfer year ======================================
Route::get('transfer_officer', ['uses' =>'HomeController@transfer_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('transfer_officer', ['uses' =>'HomeController@post_transfer_officer','middleware' => 'roles','roles'=>['admin','support']]);

//====================== assign hod role========================================

Route::get('assign_hod_role', ['uses' =>'HomeController@assign_hod_role','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('get_lecturer_4_hod', ['uses' =>'HomeController@get_lecturer_4_hod','middleware' => 'roles','roles'=>['admin','support']]);

Route::post('assign_hod', ['uses' =>'HomeController@assign_hod','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_assign_hod', ['uses' =>'HomeController@view_assign_hod','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('remove_hod/{id}', ['uses' =>'HomeController@remove_hod','middleware' => 'roles','roles'=>['admin','support']]);
//=================================== assign exams officer role =======================================
Route::get('assign_exams_officer', ['uses' =>'HomeController@assign_exams_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('get_lecturer_4_exams_officer', ['uses' =>'HomeController@get_lecturer_4_exams_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('assign_exams_officer', ['uses' =>'HomeController@assign_exams_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_assign_exams_officer', ['uses' =>'HomeController@view_exams_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('remove_exams_officer/{id}', ['uses' =>'HomeController@remove_exams_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('detail_exams_officer/{id}', ['uses' =>'HomeController@detail_exams_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('remove_fos/{id}', ['uses' =>'HomeController@remove_fos','middleware' => 'roles','roles'=>['admin','support']]);

/*===================================student detail ===============================================*/
Route::get('admin_studentdetails', ['uses' =>'HomeController@admin_studentdetails','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
// edit images
Route::get('edit_image/{id}', ['uses' =>'HomeController@edit_image','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('edit_image', ['uses' =>'HomeController@post_edit_image','middleware' => 'roles','roles'=>['admin','support']]);

// edit matric number
Route::get('edit_matric_number/{id}', ['uses' =>'GeneralController@edit_matric_number','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('edit_matric_number', ['uses' =>'GeneralController@post_edit_matric_number','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);

// edit students profile
Route::get('edit_profile/{id}', ['uses' =>'GeneralController@edit_profile','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('edit_profile', ['uses' =>'GeneralController@post_edit_profile','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);




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
Route::post('assign_fosdesk', ['uses' =>'HomeController@assign_fosdesk','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('assign_fos', ['uses' =>'HomeController@assign_fos','middleware' => 'roles','roles'=>['admin','support']]);

Route::get('delete_fos/{id}/{yes?}', ['uses' =>'HomeController@delete_fos','middleware' => 'roles','roles'=>['admin','support']]);
//==================================== specialization ================================
Route::get('newSpecialization', ['uses' =>'HomeController@newSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('newSpecialization', ['uses' =>'HomeController@postSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('viewSpecialization', ['uses' =>'HomeController@viewSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('viewSpecialization', ['uses' =>'HomeController@postViewSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);

Route::get('editSpecialization/{id}', ['uses' =>'HomeController@editSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('editSpecialization', ['uses' =>'HomeController@updateSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('assignSpecialization', ['uses' =>'HomeController@postAssignSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('updateAssignSpecialization', ['uses' =>'HomeController@updateAssignSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('assignSpecialization', ['uses' =>'HomeController@assignSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('viewAssignSpecialization', ['uses' =>'HomeController@viewAssignSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('viewAssignSpecialization', ['uses' =>'HomeController@postViewAssignSpecialization','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);



//-------------------------------------------------------------------------------------------------------------------
//desk officer
Route::get('new_desk_officer', ['uses' =>'HomeController@new_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('new_desk_officer', ['uses' =>'HomeController@post_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_desk_officer', ['uses' =>'HomeController@view_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('suspend_desk_officer', ['uses' =>'HomeController@suspend_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);

Route::get('/edit_right/{id}/{e}', ['uses' =>'HomeController@edit_right','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('autocomplete_department',array('as'=>'autocomplete_department','uses'=>'HomeController@autocomplete_department'));

Route::get('/activate/{id}/{e}', ['uses' =>'HomeController@activate','middleware' => 'roles','roles'=>['admin','support']]);

Route::get('/suspend/{id}/{e?}', ['uses' =>'HomeController@suspend','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('/assign_deskofficer/{e}', ['uses' =>'HomeController@assign_deskofficer','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('assign_deskofficer', ['uses' =>'HomeController@post_assign_deskofficer','middleware' => 'roles','roles'=>['admin','support']]);

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
Route::get('create_course_unit_special', ['uses' =>'HomeController@create_course_unit_special','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('create_course_unit_special', ['uses' =>'HomeController@post_create_course_unit_special','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('view_course_unit', ['uses' =>'HomeController@view_course_unit','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('view_course_unit', ['uses' =>'HomeController@post_view_course_unit','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('adminreg_course', ['uses' =>'HomeController@adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('get_adminreg_course', ['uses' =>'HomeController@post_adminreg_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('delete_adminreg_course/{id}/{s}/{yes?}', ['uses' =>'HomeController@delete_adminreg_course','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('delete_adminreg_multiple_course', ['uses' =>'HomeController@delete_adminreg_multiple_course','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
// edit course registration 

Route::get('edit_adminreg_course/{id}/{s}', ['uses' =>'HomeController@edit_adminreg_course','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('edit_adminreg_course', ['uses' =>'HomeController@update_adminreg_course','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
// edit of registration
Route::get('deleteRegistration/{id}', ['uses' =>'HomeController@deleteRegistration','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
// edit_course_unit
Route::get('edit_course_unit/{id}', ['uses' =>'HomeController@edit_course_unit','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('update_course_unit', ['uses' =>'HomeController@update_course_unit','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);


//-----------       add course to students ---------------------------------
Route::get('add_adminreg_course/{id}/{s}/{yes?}', ['uses' =>'HomeController@add_adminreg_course','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
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
Route::get('assign_course', ['uses' =>'DeskController@assign_course','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::post('get_assign_course', ['uses' =>'DeskController@get_assign_course','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);

Route::get('assign_course_other', ['uses' =>'DeskController@assign_course_other','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::post('assign_course_other', ['uses' =>'DeskController@post_assign_course_other','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);

Route::get('getLecturer/{id}', ['uses' =>'DeskController@getLecturer','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);

Route::post('assign_course', ['uses' =>'DeskController@post_assign_course','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);

Route::post('assign_course_o', ['uses' =>'DeskController@post_assign_course_o','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::get('view_assign_course', ['uses' =>'DeskController@view_assign_course','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::post('view_assign_course', ['uses' =>'DeskController@get_view_assign_course','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::get('print_assign_course', ['uses' =>'DeskController@print_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('print_assign_course', ['uses' =>'DeskController@get_print_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('remove_assign_course/{id}', ['uses' =>'DeskController@remove_assign_course','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::post('delete_multiple_course', ['uses' =>'DeskController@delete_multiple_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('remove_multiple_assign_course', ['uses' =>'DeskController@remove_multiple_assign_course','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);

// register courses
Route::get('register_course', ['uses' =>'DeskController@register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('register_course', ['uses' =>'DeskController@get_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('reg_course', ['uses' =>'DeskController@post_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('view_register_course', ['uses' =>'DeskController@view_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_register_course', ['uses' =>'DeskController@post_view_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
//  registered course  
Route::get('registeredcourse', ['uses' =>'DeskController@registeredcourse','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('get_registeredcourse', ['uses' =>'DeskController@post_registeredcourse','middleware' => 'roles','roles'=>'Deskofficer']);

Route::post('delete_desk_multiple_course', ['uses' =>'DeskController@delete_desk_multiple_course','middleware' => 'roles','roles'=>'Deskofficer']);

// edit courses
Route::get('edit_course/{id}', ['uses' =>'DeskController@edit_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('edit_course/{id}', ['uses' =>'DeskController@post_edit_course','middleware' => 'roles','roles'=>'Deskofficer']);
// delete course
Route::get('delete_course/{id}', ['uses' =>'DeskController@delete_course','middleware' => 'roles','roles'=>'Deskofficer']);
// student
Route::get('view_student', ['uses' =>'DeskController@view_student','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_student', ['uses' =>'DeskController@post_view_student','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('register_student', ['uses' =>'DeskController@register_student','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('post_register_student/{fos_id?}/{level?}/{semester_id?}/{session?}/{season?}', ['uses' =>'DeskController@post_register_student','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('view_student_detail/{id}', ['uses' =>'DeskController@view_student_detail','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('register_student_ii', ['uses' =>'DeskController@register_student_ii','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('post_register_student_ii/{fos_id?}/{level?}/{session?}/{season?}', ['uses' =>'DeskController@post_register_student_ii','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('registered_student_detail/{user_id?}/{level?}/{session?}/{season?}', ['uses' =>'DeskController@registered_student_detail','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('registered_student_detail_update/{user_id?}/{level?}/{session?}/{season?}', ['uses' =>'DeskController@registered_student_detail_update','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('registered_student_detail_delete/{user_id?}/{level?}/{session?}/{season?}', ['uses' =>'DeskController@registered_student_detail_delete','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);

Route::post('update_entry_year', ['uses' =>'DeskController@update_entry_year','middleware' => 'roles','roles'=>['Deskofficer']]);
// registered result mode entering

//post result updated version

Route::post('postResult', ['uses' =>'DeskController@postResult','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);


Route::post('entering_result', ['uses' =>'DeskController@enter_result','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('register_student/{fos_id?}/{l_id?}/{semester_id?}/{session?}/{season?}', ['uses' =>'DeskController@get_register_student','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);

Route::post('more_result', ['uses' =>'DeskController@more_result','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('post_more_result', ['uses' =>'DeskController@post_more_result','middleware' => 'roles','roles'=>'Deskofficer']);

// entering result per course
Route::get('e_result', ['uses' =>'DeskController@e_result','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('e_result', ['uses' =>'DeskController@e_result_next','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('e_result_c', ['uses' =>'DeskController@e_result_c','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('insert_result', ['uses' =>'DeskController@insert_result','middleware' => 'roles','roles'=>'Deskofficer']);


// entering probation result per course
Route::get('enter_probation_result', ['uses' =>'DeskController@enter_probation_result','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('enter_probation_result1', ['uses' =>'DeskController@enter_probation_result_next','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::post('probation_entering_result', ['uses' =>'DeskController@probation_enter_result','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);
Route::get('get_register_probation_student/{programme_id?}/{fos_id?}/{l_id?}/{session?}/{season?}', ['uses' =>'DeskController@get_register_probation_student','middleware' => 'roles','roles'=>['Deskofficer','examsofficer']]);

//Route::post('insert_result', ['uses' =>'DeskController@insert_result','middleware' => 'roles','roles'=>'Deskofficer']);

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
Route::get('reports', ['uses' =>'DeskController@report','middleware' => 'roles','roles'=>['Deskofficer','examsofficer','HOD','admin','support']]);
Route::get('getreport', ['uses' =>'DeskController@post_report','middleware' => 'roles','roles'=>['Deskofficer','examsofficer','HOD','admin','support']]);
Route::get('departmentreport', ['uses' =>'DeskController@departmentreport','middleware' => 'roles','roles'=>['examsofficer','HOD']]);
//===================== courses with no result =================================
Route::get('course_with_no_result', ['uses' =>'HomeController@course_with_no_result','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('course_with_no_result', ['uses' =>'HomeController@post_course_with_no_result','middleware' => 'roles','roles'=>['admin','support']]);

//================== Exams Officer ===============================================



Route::get('getfos/{id}',  ['uses' =>'ExamofficerController@getfos_hod','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);


Route::post('eo_assign_courses',  ['uses' =>'ExamofficerController@eo_assign_courses','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('eo_result_c', ['uses' =>'ExamofficerController@eo_result_c','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('eo_insert_result', ['uses' =>'ExamofficerController@eo_insert_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('v_result', ['uses' =>'ExamofficerController@post_v_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('v_result', ['uses' =>'ExamofficerController@v_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('d_result', ['uses' =>'ExamofficerController@display_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);

Route::get('lecturer',  ['uses' =>'ExamofficerController@index','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
// delete result

Route::get('eo_delete_result',  ['uses' =>'ExamofficerController@eo_delete_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('eo_delete_result',  ['uses' =>'ExamofficerController@post_eo_delete_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('eo_delete_result_detail', ['uses' =>'ExamofficerController@eo_delete_result_detail','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::get('eo_delete_desk_result/{id}', ['uses' =>'ExamofficerController@eo_delete_desk_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::post('eo_delete_desk_multiple_result', ['uses' =>'ExamofficerController@eo_delete_desk_multiple_result','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);
Route::get('eo_delete_result_detail', ['uses' =>'ExamofficerController@eo_delete_result_detail','middleware' => 'roles','roles'=>['examsofficer','lecturer','HOD']]);


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
//========================== public result =======================================
Route::get('publish_result', ['uses' =>'HomeController@publish_result','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::get('get_publish_result', ['uses' =>'HomeController@post_publish_result','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);
Route::post('publish', ['uses' =>'HomeController@publish','middleware' => 'roles','roles'=>['admin','support','Deskofficer']]);

//=============================== update officer email ====================================
Route::get('update_officer_email', ['uses' =>'GeneralController@update_officer_email','middleware' => 'roles','roles'=>['admin','support']]);
//======================== student management=====================================
Route::get('studentManagement', ['uses' =>'DeskController@studentManagement','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::get('studentManagementAddCourses', ['uses' =>'DeskController@studentManagementAddCourses','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::get('getStudentManagementAddCourse', ['uses' =>'DeskController@getStudentManagementAddCourse','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
Route::post('postStudentManagementAddCourse', ['uses' =>'DeskController@postStudentManagementAddCourse','middleware' => 'roles','roles'=>['Deskofficer','admin','support']]);
//======================= transfer student==============================
Route::post('tranferStudents', ['uses' =>'HomeController@tranferStudents','middleware' => 'roles','roles'=>['admin','support']]);

Auth::routes();
Route::get('logout','Auth\LoginController@logout');


