<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CategoryController;

Route::prefix('v1')->group(function () {

    //Category
    Route::apiResource('categories', CategoryController::class);

    //Company
    Route::apiResource('companies', CompanyController::class);

});

