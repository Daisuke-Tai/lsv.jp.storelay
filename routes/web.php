<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\KindController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/Dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get( '/kinds/create', [KindController::class, 'showCreateForm'])->name('kinds.create');
    Route::post('/kinds/create', [KindController::class, 'create']);

    Route::get('/kinds={kind_id}/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/id={id}/books', [BookController::class, 'index2'])->name('books.index2');

    Route::get( '/kinds={kind_id}/books/create', [BookController::class, 'showCreateForm'])->name('books.create');
    Route::post('/kinds={kind_id}/books/create', [BookController::class, 'create']);

    Route::get( '/relay={id}', [BookController::class, 'showRelayForm'])->name('books.relay');
    Route::post('/relay={id}', [BookController::class, 'relay']);

    Route::get( '/kinds={kind_id}/books={tema_id}/edit', [BookController::class, 'showEditForm'])->name('books.edit');
    Route::post('/kinds={kind_id}/books={tema_id}/edit', [BookController::class, 'edit']);

    Route::post('/like/{id}', [LikeController::class,'store']);
    Route::post('/hate/{id}', [LikeController::class,'store2']);

    Route::get( '/home', [HomeController::class, 'index'])->name('home');
});

require __DIR__.'/auth.php';