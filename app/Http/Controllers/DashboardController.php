<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCourses = Course::count();
        $totalModules = Module::count();
        $totalContents = Content::count();  

        return view('dashboard', compact(
            'totalCourses', 
            'totalModules', 
            'totalContents'
        ));
    }

}
