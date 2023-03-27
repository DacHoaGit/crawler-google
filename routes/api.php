<?php

use App\Http\Controllers\Admin\Charts\LogProxiesChartController;
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

Route::get('/get-links-by-status',[\App\Http\Controllers\ApiResultController::class,'getLinksByStatus']);
Route::get('/test',[\App\Http\Controllers\TestController::class,'index']);
Route::get('charts/line-chart', [LogProxiesChartController::class, 'data']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
