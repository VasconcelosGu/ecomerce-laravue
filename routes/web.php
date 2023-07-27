<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// })->name("home");

// Route::get('/produto', function(){
//     return view('produto');
// })->name("produto");

// Route::get('/admin', function(){
//     return view('admin-home');
// })->name("admin");

// Route::get('/adicionar-produto', function(){
//     return view('admin-adicionar-produto');
// })->name("adicionar-produto");


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produto/{product:slug}', [ProductController::class, 'show'])->name('product');


// Admin
Route::get('/admin/produtos', [AdminController::class, 'index'])->name('admin.products');
Route::get('/admin/produtos/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/produtos', [AdminController::class, 'store'])->name('admin.store');

Route::get('/admin/produtos/{product}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/produtos/{product}', [AdminController::class, 'update'])->name('admin.update');


Route::get('/admin/produtos/{product}/delete', [AdminController::class, 'destroy'])->name('admin.destroy');


Route::get('/admin/produtos/{product}/delete-image', [AdminController::class, 'destroyImage'])->name('admin.destroyImage');
