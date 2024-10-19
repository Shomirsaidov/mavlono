<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoemController;
use App\Http\Controllers\PoetController;
use App\Http\Controllers\MailController;


Route::get('/', [PoemController::class, 'recent'])->name('poems.recent');

Route::get('poems/{poem}', [PoemController::class, 'show'])->name('poems.show');
Route::get('poets/{poet}', [PoetController::class, 'show'])->name('poets.show');
Route::get('poets/{poet}/bio', [PoetController::class, 'bio'])->name('poets.bio');
Route::get('poets/{poet}/recent', [PoetController::class, 'showRecent'])->name('poets.recent');
Route::get('readers/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('readers.profile');


Route::get('/write', [PoemController::class, 'createForm'])->middleware('checkAuth');
Route::get('/edit/{poem_id}', [PoemController::class, 'editForm'])->middleware('checkAuth');
Route::get('/add-poet', function() {
    return view('create-poet');
});


Route::get('/login-again', function() {
    return view('auth.login');
});
Route::get('/register-again', function() {
    return view('auth.register');
});


Route::post('poems', [PoemController::class, 'create'])->name('poems.create');
Route::post('delete-poem', [PoemController::class, 'delete'])->name('poems.delete');
Route::post('edit-poem', [PoemController::class, 'edit'])->name('poems.edit');
Route::post('poets', [PoetController::class, 'create'])->name('poets.create');
Route::get('/vocabulary/{poem_id}', [PoemController::class, 'full_vocab'])->name('poem.full_vocabulary');


Route::post('/like', [PoemController::class, 'like'])->name('addLike')->middleware('checkAuth');
Route::post('/comment', [PoemController::class, 'comment'])->name('addcomment')->middleware('checkAuth');
Route::post('/follow', [PoemController::class, 'subscribe'])->name('subscribe')->middleware('checkAuth');
Route::post('/reco-mail', [MailController::class, 'sendRandomSimilar'])->name('reco-mail')->middleware('checkAuth');


Auth::routes();
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->middleware('checkAuth');

Route::get('/home', [App\Http\Controllers\UserController::class, 'selfUser'])->name('home');
Route::get('/search', [App\Http\Controllers\PoemController::class, 'search'])->name('search');

Route::get('/ai', [App\Http\Controllers\AiController::class, 'chatPage']);
Route::post('/ai/send', [App\Http\Controllers\AiController::class, 'sendMessage']);
