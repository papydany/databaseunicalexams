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
Route::get('/', 'HomeController@index');
Route::get('changepassword', 'HomeController@changepassword');
Route::post('changepassword', 'HomeController@post_changepassword');
// support
Route::get('support', ['uses' =>'SupportController@index','middleware' => 'roles','roles'=>'support']);
Route::get('create_pin', ['uses' =>'SupportController@get_create_pin','middleware' => 'roles','roles'=>'support']);
Route::post('create_pin', ['uses' =>'SupportController@post_create_pin','middleware' => 'roles','roles'=>'support']);
Route::get('view_unused_pin', ['uses' =>'SupportController@view_unused_pin','middleware' => 'roles','roles'=>'support']);
Route::get('view_used_pin', ['uses' =>'SupportController@view_used_pin','middleware' => 'roles','roles'=>'support']);
Route::get('export_pin', ['uses' =>'SupportController@export_pin','middleware' => 'roles','roles'=>'support']);
/* ===============================================admin====================================================*/
Route::get('admin', ['uses' =>'HomeController@index','middleware' => 'roles','roles'=>['admin','support']]);
// faculty
Route::get('new_faculty', ['uses' =>'HomeController@new_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('new_faculty', ['uses' =>'HomeController@post_new_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_faculty', ['uses' =>'HomeController@view_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('edit_faculty/{id}', ['uses' =>'HomeController@edit_faculty','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('post_edit_faculty', ['uses' =>'HomeController@post_edit_faculty','middleware' => 'roles','roles'=>['admin','support']]);
//----------------------------------------------------------------------------------------------------------------
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
Route::get('/edit_right/{id}/{e}', ['uses' =>'HomeController@edit_right','middleware' => 'roles','roles'=>['admin','support']]);
//----------------------------------------------------------------------------------------------------------------
// predegree  create officer 
Route::get('pds_new_desk_officer', ['uses' =>'HomeController@pds_new_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('pds_new_desk_officer', ['uses' =>'HomeController@pds_post_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('pds_view_desk_officer', ['uses' =>'HomeController@pds_view_desk_officer','middleware' => 'roles','roles'=>['admin','support']]);

// predegree create course
Route::get('pds_create_course', ['uses' =>'HomeController@pds_create_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('pds_create_course', ['uses' =>'HomeController@pds_post_create_course','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('pds_view_course', ['uses' =>'HomeController@pds_view_course','middleware' => 'roles','roles'=>['admin','support']]);
// create course unit
Route::get('create_course_unit', ['uses' =>'HomeController@create_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('create_course_unit', ['uses' =>'HomeController@post_create_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('create_course_unit_special', ['uses' =>'HomeController@create_course_unit_special','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('create_course_unit_special', ['uses' =>'HomeController@post_create_course_unit_special','middleware' => 'roles','roles'=>['admin','support']]);
Route::get('view_course_unit', ['uses' =>'HomeController@view_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
Route::post('view_course_unit', ['uses' =>'HomeController@post_view_course_unit','middleware' => 'roles','roles'=>['admin','support']]);
//================================================Desk Officer ================================================
Route::get('Deskofficer', ['uses' =>'DeskController@index','middleware' => 'roles','roles'=>'Deskofficer']);
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
Route::post('assign_course', ['uses' =>'DeskController@post_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('view_assign_course', ['uses' =>'DeskController@view_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_assign_course', ['uses' =>'DeskController@get_view_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('print_assign_course', ['uses' =>'DeskController@print_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('print_assign_course', ['uses' =>'DeskController@get_print_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('remove_assign_course/{id}', ['uses' =>'DeskController@remove_assign_course','middleware' => 'roles','roles'=>'Deskofficer']);
// register courses
Route::get('register_course', ['uses' =>'DeskController@register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('register_course', ['uses' =>'DeskController@get_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('reg_course', ['uses' =>'DeskController@post_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::get('view_register_course', ['uses' =>'DeskController@view_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('view_register_course', ['uses' =>'DeskController@post_view_register_course','middleware' => 'roles','roles'=>'Deskofficer']);
// edit courses
Route::get('edit_course/{id}', ['uses' =>'DeskController@edit_course','middleware' => 'roles','roles'=>'Deskofficer']);
Route::post('edit_course/{id}', ['uses' =>'DeskController@post_edit_course','middleware' => 'roles','roles'=>'Deskofficer']);

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

//=============================================== Exams Officer ===============================================

Route::get('examsofficer',  ['uses' =>'ExamofficerController@index','middleware' => 'roles','roles'=>'examsofficer']);
Route::get('getlevel/{id}',  ['uses' =>'ExamofficerController@getlevel','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::get('getsemester/{id}',  ['uses' =>'ExamofficerController@getsemester','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('eo_assign_courses',  ['uses' =>'ExamofficerController@eo_assign_courses','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);

Route::get('eo_result_c', ['uses' =>'ExamofficerController@eo_result_c','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('eo_insert_result', ['uses' =>'ExamofficerController@eo_insert_result','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('v_result', ['uses' =>'ExamofficerController@post_v_result','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);

Route::get('v_result', ['uses' =>'ExamofficerController@v_result','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('d_result', ['uses' =>'ExamofficerController@display_result','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);

Route::get('lecturer',  ['uses' =>'ExamofficerController@index','middleware' => 'roles','roles'=>'lecturer']);
// registere student
Route::get('r_student', ['uses' =>'ExamofficerController@r_student','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('r_student', ['uses' =>'ExamofficerController@post_r_student','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
Route::post('d_student', ['uses' =>'ExamofficerController@d_student','middleware' => 'roles','roles'=>['examsofficer','lecturer']]);
//=========================================PDS===================================================
Route::get('pds',  ['uses' =>'PdsController@index','middleware' => 'roles','roles'=>'pds']);
Route::get('pds_student',  ['uses' =>'PdsController@pds_student','middleware' => 'roles','roles'=>'pds']);
Route::get('pds_student1',  ['uses' =>'PdsController@pds_get_student','middleware' => 'roles','roles'=>'pds']);
Route::post('pds_result',  ['uses' =>'PdsController@pds_result','middleware' => 'roles','roles'=>'pds']);
Route::get('pds_enter_result',  ['uses' =>'PdsController@pds_enter_result','middleware' => 'roles','roles'=>'pds']);
Route::get('pds_enter_result1',  ['uses' =>'PdsController@pds_get_result','middleware' => 'roles','roles'=>'pds']);
Route::post('pds_enter_result1',  ['uses' =>'PdsController@pds_post_result','middleware' => 'roles','roles'=>'pds']);
Route::get('pds_view_result',  ['uses' =>'PdsController@pds_view_result','middleware' => 'roles','roles'=>'pds']);
Route::post('pds_view_result',  ['uses' =>'PdsController@pds_display_result','middleware' => 'roles','roles'=>'pds']);
Route::get('pds_view_course_result',  ['uses' =>'PdsController@pds_view_course_result','middleware' => 'roles','roles'=>'pds']);
Route::post('pds_view_course_result',  ['uses' =>'PdsController@pds_display_course_result','middleware' => 'roles','roles'=>'pds']);
Route::get('pds_view_final_result',  ['uses' =>'PdsController@pds_view_final_result','middleware' => 'roles','roles'=>'pds']);
Route::post('pds_view_final_result',  ['uses' =>'PdsController@pds_display_final_result','middleware' => 'roles','roles'=>'pds']);
Auth::routes();


