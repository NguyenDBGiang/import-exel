<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/product-import', [\App\Http\Controllers\ProductController::class, 'import'])->name('product.import');