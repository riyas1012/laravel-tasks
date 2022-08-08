<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api_header_verification'], function () {
    Route::get('/test-api', function (Request $request) {
        return response(['status' =>  true, 'reason' => 'valid user'], 401);
    });

    Route::get('/tasks',[TaskController::class,'index'])->name('task.list');
    Route::get('/tasks/{task_id}',[TaskController::class,'show'])->name('task.show');
    Route::post('/tasks',[TaskController::class,'store'])->name('task.store');
    Route::post('/tasks/{task_id}',[TaskController::class,'update'])->name('task.update');
    Route::delete('/tasks/{task_id}',[TaskController::class,'destroy'])->name('task.destroy');
});
