<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Employee\AdminEmployeeController;
use App\Http\Controllers\Employee\RoleController;
use App\Http\Controllers\Employee\AdminArticleImagesController;
use App\Http\Controllers\Employee\AdminArticleController;
use App\Http\Controllers\Employee\AdminCategoryController;

/*
|--------------------------------------------------------------------------
| web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('employee')->name('employee.')->group(function () {
    Route::middleware('auth:employee')->group(function () {
        Route::get('/dashboard', function () {
            return view('Employee.dashboard');
        })->name('dashboard');
        Route::resources([
            'categories' => AdminCategoryController::class,
            'articles' => AdminArticleController::class,
            'roles' => RoleController::class,
            'employees' => AdminEmployeeController::class,
            'article-images' => AdminArticleImagesController::class,
        ]);
    });

    require __DIR__ . '/employee-auth.php';

    // Route::group(['middleware' => ['role:admin']], function () {
    //     Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // });

});



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
