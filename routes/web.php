<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Requests\Users\UpdateProfileRequest;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use Laravel\Socialite\Facades\Socialite;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('users/profile', [UserController::class, 'edit'])->name('users.edit-profile');
Route::put('users/profile', [UserController::class, 'update'])->name('users.update-profile');
Route::resource('posts', PostController::class);



// Google Login
Route::get('auth/google/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

// Github Login
Route::get('auth/github/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('auth/github/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGithubCallback']);


// Line Login
Route::get('auth/line/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirectToLine'])->name('login.line');
Route::get('auth/line/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleLineCallback']);

//New Password for New User
Route::get('/newPassword', [App\Http\Controllers\HomeController::class, 'showNewPasswordGet'])->name('newPasswordGet')->middleware('IsUser');
Route::post('/newPassword', [App\Http\Controllers\HomeController::class, 'NewPasswordPost'])->name('newPasswordPost')->middleware('IsUser');

// Change Password
Route::get('/changePassword', [App\Http\Controllers\HomeController::class, 'showchangePasswordGet'])->name('changePasswordGet');
Route::post('/changePassword', [App\Http\Controllers\HomeController::class, 'changePasswordPost'])->name('changePasswordPost');

