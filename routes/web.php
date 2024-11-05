<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function(){
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/post', [PostController::class, 'destroy'])->name('posts.destroy');  
});

