<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubActivityController;
use App\Models\SubActivity;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('project', ProjectController::class);
Route::resource('activity', ActivityController::class);
Route::resource('sub_activity', SubActivityController::class);
Route::get('/getSubActivity/{id}', [SubActivityController::class, 'getSubActivity']);
Route::get('/getActivity', [ActivityController::class, 'getActivity']);
Route::get('/getProjects', [ProjectController::class, 'getProjects']);
Route::post('/project_update/{id}', [ProjectController::class, 'update']);
Route::post('/activity_update/{id}', [ActivityController::class, 'update']);
Route::post('/sub_activity_update/{id}', [SubActivityController::class, 'update']);
