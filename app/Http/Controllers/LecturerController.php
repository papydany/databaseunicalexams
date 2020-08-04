<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Faculty;
use App\Department;
use App\Programme;
use App\Fos;
use App\Level;
use App\Semester;
use App\StudentResult;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Course;
use App\RegisterCourse;
use App\AssignCourse;
use Illuminate\Support\Facades\Session;

class LecturerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
     
  return view('lecturer.index');
    }
}
