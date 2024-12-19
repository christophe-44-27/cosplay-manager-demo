<?php

namespace App\Domains\ProjectManagement\Controllers;

use App\Domains\Community\Models\Group;
use App\Domains\Core\Models\Category;
use App\Domains\ProjectManagement\Models\Project;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters(['is_published', 'is_finished', 'is_private'])
            ->where('user_id', '=', auth()->user()->id)
            ->paginate(10);

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        $groups = Group::query()->where('user_id', '=', auth()->user()->id)->get();
        $categories = Category::query()->orderBy('name', 'ASC')->get();

        return Inertia::render('Projects/Create', [
            'groups' => $groups,
            'categories' => $categories,
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function edit(Project $project): Response
    {
        $groups = Group::query()->where('user_id', '=', auth()->user()->id)->get();
        $categories = Category::query()->orderBy('name', 'ASC')->get();

        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'groups' => $groups,
            'categories' => $categories,
        ]);
    }

    /**
     * @param Project $project
     * @return Response
     */
    public function show(Project $project): Response
    {
        return Inertia::render('Projects/Show', [
            'project' => $project,
        ]);
    }
}
