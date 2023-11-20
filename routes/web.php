<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\KindController;
use App\Http\Controllers\HomeController;

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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get( '/kinds/create', [KindController::class, 'showCreateForm'])->name('kinds.create');
    Route::post('/kinds/create', [KindController::class, 'create']);

    Route::get('/kinds={kind_id}/books', [BookController::class, 'index'])->name('books.index');

    Route::get( '/kinds={kind_id}/books/create', [BookController::class, 'showCreateForm'])->name('books.create');
    Route::post('/kinds={kind_id}/books/create', [BookController::class, 'create']);

    Route::get( '/relay={id}', [BookController::class, 'showRelayForm'])->name('books.relay');
    Route::post('/relay={id}', [BookController::class, 'relay']);

    Route::get( '/kinds={kind_id}/books={book_id}/edit', [BookController::class, 'showEditForm'])->name('books.edit');
    Route::post('/kinds={kind_id}/books={book_id}/edit', [BookController::class, 'edit']);

    Route::get( '/', [HomeController::class, 'index'])->name('home');
});

    require __DIR__.'/auth.php';