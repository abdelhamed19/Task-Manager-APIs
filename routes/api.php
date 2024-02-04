<?php

use App\Http\Controllers\{AuthController,ProjectController,TaskController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("register",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"login"]);

Route::middleware("auth:sanctum")->group(function ()
{
    Route::post("logout",[AuthController::class,"logout"]);
    Route::apiResource("tasks",TaskController::class);
    Route::apiResource("projects",ProjectController::class);
    Route::post("add-member/{project}",[\App\Http\Controllers\MembersController::class,"addMembers"]);
    Route::delete("delete-member/{project}",[\App\Http\Controllers\MembersController::class,"deleteMember"]);
});
