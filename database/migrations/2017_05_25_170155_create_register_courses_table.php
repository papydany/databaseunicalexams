<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->integer('programme_id');
            $table->integer('department_id');
            $table->integer('faculty_id');
            $table->integer('fos_id');
            $table->integer('level_id');
            $table->integer('semester_id');
            $table->string('reg_course_title');
            $table->string('reg_course_code');
            $table->string('reg_course_unit');
            $table->string('reg_course_status');
            $table->string('session');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_courses');
    }
}
