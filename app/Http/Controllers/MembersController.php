<?php

namespace App\Http\Controllers;

use App\Helpers\BaseResponse;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
{
    public function addMembers(Project $project,Request $request)
    {
        $user=Auth::user();
        if ($user->memberships->contains($project))
        {
            $id=User::where("email",$request->email)->pluck('id')->first();
            $project->members()->attach([$id]);
            return BaseResponse::makeResponse(new ProjectResource($project),201,"success");
        }
        return BaseResponse::makeResponse(null,404,"error");
    }
    public function deleteMember(Project $project, Request $request)
    {
        $user=Auth::user();
        if ($user->memberships->contains($project))
        {
            $id=User::where("email",$request->email)->pluck('id')->first();
            $project->members()->detach([$id]);
            return BaseResponse::makeResponse(null,200,"success");
        }
        return BaseResponse::makeResponse(null,404,"error");
    }
}
