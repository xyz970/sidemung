<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PengaduanController;
use App\Http\Middleware\ApiCheckMiddleware;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * Login
 * @POST
 * 
 * - phone
 * - password
 */
Route::post('login',[AuthController::class, 'login']);


/**
 * Register
 *  @POST
 * 
 * - nik
 * - name
 * - email
 * - phone
 * - password
 */
Route::post('register',[AuthController::class, 'register']);

/**
 * Logout
 *  @GET
 */
Route::get('logout',[AuthController::class, 'logout'])->middleware(ApiCheckMiddleware::class);

Route::get('check',[AuthController::class, 'check'])->middleware(ApiCheckMiddleware::class);


Route::get('pengaduan',[PengaduanController::class, 'index'])->middleware(ApiCheckMiddleware::class);;


Route::post('pengaduan/insert',[PengaduanController::class, 'insert']);



Route::delete('pengaduan/delete/{id}',[PengaduanController::class, 'delete']);