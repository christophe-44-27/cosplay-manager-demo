<?php

namespace App\Http\Controllers;

use App\Domains\ProjectManagement\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function __invoke(): Response
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
