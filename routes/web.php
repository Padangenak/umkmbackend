<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('user')->middleware('userblock')->group(function(){
        Route::get('/current-user', [UserController::class, 'current'])->name('current');
        Route::get('/add-user', [UserController::class, 'add'])->middleware('flash')->name('addUser');
        Route::post('/add-user/loading', [UserController::class, 'addUser'])->name('addUserLoading');
        Route::post('/current-user/{user}/loading', [UserController::class, 'currentActive'])->name('currentLoading');
    });
        Route::prefix('profile')->group(function(){
        Route::get('/im', [ProfileController::class, 'im'])->middleware('flash')->name('im');
        Route::post('/im/change', [ProfileController::class, 'imChange'])->name('imChange');
    });
    Route::prefix('product')->group(function(){
        Route::get('current', [ProductController::class,'current'])->name('currentProduct');
        Route::get('add', [ProductController::class,'add'])->middleware('flash')->name('addProduct');
        Route::post('/current-product/{product}/loading', [ProductController::class, 'currentActive'])->name('activeProductLoading');
        Route::post('/add/loading', [ProductController::class, 'addLoading'])->name('productAddLoading');
        Route::post('/{id}/delete', [ProductController::class, 'productDelete'])->name('productDelete');
        Route::prefix('/{id}/edit')->group(function(){
            Route::get('/', [ProductController::class,'editProduct'])->middleware('flash')->name('editProduct');
            Route::post('/loading', [ProductController::class,'editProductId'])->name('editProductId');
            Route::get('/attachmentproduct/{variantId}', [ProductController::class,'attachmentproduct'])->middleware('flash')->name('attachmentproduct');
            Route::post('/attachmentproduct/{variantId}/delete', [ProductController::class,'variantDelete'])->name('variantDelete');
            Route::post('/attachmentproduct/variantAdd', [ProductController::class,'variantAdd'])->name('variantAdd');
            Route::post('/attachmentproduct/{variantId}/loading', [ProductController::class,'attachmentUpload'])->name('attachmentUpload');
            Route::post('/attachmentproduct/{variantId}/delete/loading', [ProductController::class,'imageDelete'])->name('imageDelete');
            Route::post('/newVariant/loading', [ProductController::class,'newVariant'])->name('newVariant');
        });

        // Route::post('add/{id}/attachmentproduct/{number}/loading', [ProductController::class,'attachmentproduct'])->name('attachmentproduct');
        // Route::post('/add/loading/{id}', [ProductController::class, 'addAttachment'])->name('productAddLoading');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
