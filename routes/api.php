<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstatisticasController;
use App\Http\Controllers\ListaController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::get('check', [AuthController::class, 'check']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'lista'

], function ($router) {

    Route::post('create', [ListaController::class, 'create']);
    Route::post('getMyList', [ListaController::class, 'getMyList']);
    Route::post('getMyListWithItems', [ListaController::class, 'getMyListWithItems']);
    Route::post('update', [ListaController::class, 'update']);
    Route::post('checkList', [ListaController::class, 'updateCheckedLista']);
    Route::post('delete', [ListaController::class, 'delete']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'stats'

], function ($router) {

    Route::post('itens', [EstatisticasController::class, 'getUserTotalItens']);
    Route::post('value-list', [EstatisticasController::class, 'getUserTotalSpentByList']);
    Route::post('value-item', [EstatisticasController::class, 'getUserTotalSpentItem']);
  
});