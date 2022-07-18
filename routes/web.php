<?php
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Category and Subcategory Routes
Route::get('category-subcategory/list', [CategoryController::class, 'index'])->name('category-subcategory.list');
Route::get('category-subcategory/create', [CategoryController::class, 'create'])->name('category-subcategory.create');
Route::post('category-subcategory/save', [CategoryController::class, 'store'])->name('category-subcategory.store');
Route::get('category-subcategory/edit/{category_id}', [CategoryController::class, 'edit'])->name('category-subcategory.edit');
Route::post('category-subcategory/save-nested-categories', [CategoryController::class, 'saveNestedCategories'])->name('category-subcategory.save-nested-categories');
Route::get('category-subcategory/remove/{category_id}', [CategoryController::class, 'destroy'])->name('category-subcategory.remove');
