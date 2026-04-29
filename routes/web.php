<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductPriceTierController;
use App\Http\Controllers\Admin\OptionGroupController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\OptionDependencyController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('products', ProductController::class);

    Route::resource('product-price-tiers', ProductPriceTierController::class);

    Route::resource('option-groups', OptionGroupController::class);

    Route::resource('product-options', ProductOptionController::class);

    Route::resource('option-dependencies', OptionDependencyController::class);
});
