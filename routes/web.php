<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome', [
        'products' => Product::paginate(15)
    ]);
})->name('welcome');

Route::post('/product-import', [\App\Http\Controllers\ProductController::class, 'import'])->name('product.import');