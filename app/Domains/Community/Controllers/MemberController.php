<?php

namespace App\Domains\Community\Controllers;

use App\Domains\ProjectManagement\Models\Project;
use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class MemberController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['name'])
            ->paginate(10);

        return Inertia::render('Members/Index', [
            'members' => $users,
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
