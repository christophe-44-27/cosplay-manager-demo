<?php

namespace App\Http\Controllers;

use App\Domains\ProjectManagement\Models\Project;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $currentProjects = Project::where('user_id', '=', auth()->user()->id)
            ->where('is_finished', '=', false)
            ->limit(5)
            ->get();

        $finishedProjects = Project::where('user_id', '=', auth()->user()->id)
            ->where('is_finished', '=', true)
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'currentProjects' => $currentProjects,
            'finishedProjects' => $finishedProjects
        ]);
    }
}
