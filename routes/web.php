<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryContoller;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrendingController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SingleNewsController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\Employee\RoleController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/single-news/{id}', [SingleNewsController::class, 'showSingleNews'])->name('singleNews');
    Route::get('/trending', [TrendingController::class, 'showSingleNews'])->name('trending');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->withoutMiddleware([VerifyCsrfToken::class]);
    Route::post('/commentRelpies', [CommentReplyController::class, 'store'])->name('commentReply.store');
    Route::get('/categories', [CategoryContoller::class, 'categoryPageLimit'])->name('categories');
    Route::get('/category-All/{id}', [CategoryContoller::class, 'categoryPageAll'])->name('categoryAll');
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contactUs');
    Route::post('/contact-us', [ContactUsController::class, 'ContactUs'])->name('contactUsSend');
    Route::post('/search', [SearchController::class, 'search'])->name('search');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('roles', RoleController::class);

require __DIR__ . '/auth.php';
require __DIR__ . '/employee.php';
