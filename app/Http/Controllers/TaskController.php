<?php

namespace App\Http\Controllers;

use App\Helpers\BaseResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\{StoreTaskRequest, UpdateTaskRequest};
use App\Http\Resources\{TaskCollection, TaskResource};
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $task=Task::filter($request->query())->latest()->paginate();
        return BaseResponse::makeResponse(TaskResource::collection($task),200,"success");
    }
    public function show(Task $task)
    {
        return BaseResponse::makeResponse(new TaskResource($task),200,"success");
    }
    public function store(StoreTaskRequest $request)
    {
        $valiated=$request->validated();
        $task=Auth::user()->tasks()->create($valiated);
        return BaseResponse::makeResponse(new TaskResource($task),201,"success");
    }
    public function update(UpdateTaskRequest $request,Task $task)
    {
        $valiated=$request->validated();
        $task->update($valiated);
        return BaseResponse::makeResponse(new TaskResource($task),200,"success");
    }
    public function destroy(Task $task)
    {
        $task->delete();
        return BaseResponse::makeResponse(null,200,"success");
    }
}
