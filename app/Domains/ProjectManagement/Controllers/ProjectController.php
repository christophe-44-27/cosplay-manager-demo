<?php

namespace App\Domains\ProjectManagement\Controllers;

use App\Domains\ProjectManagement\Models\Project;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $projects = Project::where('user_id', '=', auth()->user()->id)
            ->paginate(10);

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }
}
