<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Info;

class GeneralController extends Controller
{
    public function home()
    {
        $projects = Project::orderBy('created_at','desc')->get();
        $info = Info::first();

        return Inertia::render('Main' , compact('projects', 'info'));
    }

    public function project(Request $request) {
        $project = Project::find($request->id);
        return $project;
    }
}
