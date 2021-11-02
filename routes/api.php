<?php

use App\Http\Controllers\newcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post("addFavourite/{barrier_id}/{category_id}", [CategoriesController::class, 'addFavourite']);
    Route::get("showFavourites/{barrier_id}", [CategoriesController::class, 'showFavourites']);
    Route::delete("deleteFavourite/{barrier_id}/{category_id}", [CategoriesController::class, 'deleteFavourite']);
    Route::post("addBooking/{barrier_id}/{category_id}", [CategoriesController::class, 'addBooking']);
    Route::get("showBookings/{barrier_id}", [CategoriesController::class, 'showBookings']);
    Route::delete("deleteBooking/{barrier_id}/{category_id}", [CategoriesController::class, 'deleteBooking']);

});








Route::post("loging/{typeOfUser}", [AuthController::class, 'loging']);
Route::post("singing/{typeOfUser}", [AuthController::class, 'singing']);

//mainpage
Route::get("showing/{category}/{typeOfFashion}", [CategoriesController::class, 'showing']);





//Dashboard
Route::get("categories", [DashboardController::class, 'showing']);
Route::get("categoryById/{id}", [DashboardController::class, 'categoryById']);
Route::post("storeCategories", [DashboardController::class, 'storing']);
Route::delete("deleteCategories/{id}", [DashboardController::class, 'deleting']);
Route::get("search/{name}", [DashboardController::class, 'search']);
Route::get("numOf/{type}", [DashboardController::class, 'numOf']);
Route::post("updateCategory/{id}", [DashboardController::class, 'updating']);
