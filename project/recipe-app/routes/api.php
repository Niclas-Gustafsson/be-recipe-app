<?php

use \App\Http\Controllers\API\AuthController;
use \App\Http\Controllers\API\UserListController;
use \App\Http\Controllers\API\RecipeListController;
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

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/user/{id}', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //Get all lists created by logged in user
    Route::get('/lists/{userId}', [UserListController::class, 'index']);
    //Get list user clicked on.
    Route::get('/list/{listId}', [RecipeListController::class, 'getList']);
    Route::get('/list/delete/{id}', [UserListController::class, 'deleteList']);

    //Delete selected recipe from list
    Route::post('/remove-recipe/{id}', [RecipeListController::class, 'removeRecipe']);

    Route::post('/create-list/{id}', [UserListController::class, 'createList']);


    Route::post('/add-recipe/{listId}', [RecipeListController::class, 'addRecipe']);
});


//Route::get('/users', [AuthController::class, 'index']);
Route::post('/register', [AuthController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);
