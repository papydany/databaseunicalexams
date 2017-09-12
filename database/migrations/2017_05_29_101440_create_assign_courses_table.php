<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registercourse_id');
            $table->integer('user_id');
            $table->integer('fos_id');
            $table->integer('level_id');
             $table->integer('department_id');
            $table->integer('faculty_id');
             $table->integer('semester_id');
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
        Schema::dropIfExists('assign_courses');
    }
}
