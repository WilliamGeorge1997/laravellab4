<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

//List all users
Route::get('users', [UserController::class, 'index']) ->name('users.index');

//Create user
Route::get('users/create', [UserController::class, 'create']) ->name('users.create');
Route::post('users', [UserController::class, 'store']) ->name('users.store');

//Show user

Route::get('users/{user}', [UserController::class, 'show']) ->name('users.show') ->where('user', '[0-9]+');

//Update user
Route::get('users/{user}/edit', [UserController::class,'edit']) ->name('users.edit');
Route::put('users/{user}', [UserController::class,'update']) ->name('users.update');

//Delete user
Route::delete('users/{user}', [UserController::class,'destroy']) ->name('users.destroy');




//List all posts
Route::get('posts', [postController::class, 'index']) ->name('posts.index');

//Create post
Route::get('posts/create', [postController::class, 'create'])->middleware('auth') ->name('posts.create');
Route::post('posts', [postController::class, 'store']) ->name('posts.store');

//Show post

Route::get('posts/{post}', [postController::class, 'show']) ->name('posts.show');

//Update post
Route::get('posts/{post}/edit', [postController::class,'edit'])->middleware('auth')->name('posts.edit');
Route::put('posts/{post}', [postController::class,'update']) ->name('posts.update');

//Delete post
Route::delete('posts/{post}', [postController::class,'destroy']) ->name('posts.destroy');




Route::fallback(function(){
    return redirect('/');
});

require __DIR__.'/auth.php';
