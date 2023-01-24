<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;

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


Route::prefix('ingredientes')->group(function () {
    Route::controller(IngredientController::class)->group(function () {
        Route::get('/', 'index')->name('ingredients.index');
        Route::post('salvar', 'store')->name('ingredients.store');
        Route::put('{id}/atualizar', 'update')->name('ingredients.update');
        Route::delete('{id}/remover', 'destroy')->name('ingredients.destroy');
    });
});
