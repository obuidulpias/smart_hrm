<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Library\CostCenterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);

// Route::controller(AuthController::class)->group(function(){
//     Route::get('user', 'userDetails');
//     Route::get('logout', 'logout');
// })->middleware('auth:api');

Route::group(['middleware' => 'api'], function (){
    Route::get('user', [AuthController::class, 'userDetails']);
    Route::get('library/company-list', [CostCenterController::class, 'companyList']);
    Route::post('library/company-add', [CostCenterController::class, 'companyInsert']);
    Route::post('library/company-edit/{id}', [CostCenterController::class, 'companyUpdate']);
    Route::get('library/company-delete/{id}', [CostCenterController::class, 'companyDelete']);
});
