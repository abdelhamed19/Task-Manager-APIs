<?php

namespace App\Http\Controllers;

use App\Helpers\BaseResponse;
use App\Http\Requests\{StoreProjectRequest,UpdateProjectRequest};
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class,"project");
    }

    public function index()
    {
        $projects=Project::all();
        return BaseResponse::makeResponse(ProjectResource::collection($projects),200,"success");
    }
    public function show(Project $project)
    {
        return BaseResponse::makeResponse(new ProjectResource($project),200,"success");
    }
    public function store(StoreProjectRequest $request)
    {
        $validated=$request->validated();
        $project=Auth::user()->projects()->create($validated);
        return BaseResponse::makeResponse(new ProjectResource($project),201,"success");
    }
    public function update(UpdateProjectRequest $request,Project $project)
    {
        $validated=$request->validated();
        $project->update($validated);
        return BaseResponse::makeResponse(new ProjectResource($project),200,"success");
    }
    public function destroy(Project $project)
    {
        $project->delete();
        return BaseResponse::makeResponse(null,204,"success");
    }
}
