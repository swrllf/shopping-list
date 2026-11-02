<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';

use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\ItemController;

Route::middleware('auth')->group(function () {
    
    Route::delete('/lists/{shoppingList}', [ShoppingListController::class, 'destroy'])->name('lists.destroy');
    Route::get('/lists', [ShoppingListController::class, 'index'])->name('lists.index');
    Route::post('/lists', [ShoppingListController::class, 'store'])->name('lists.store');
    Route::get('/lists/{shoppingList}', [ShoppingListController::class, 'show'])->name('lists.show');
    
    Route::post('/lists/{shoppingList}/items', [ItemController::class, 'store'])->name('items.store');
    Route::patch('/items/{item}/toggle', [ItemController::class, 'toggle'])->name('items.toggle');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // Ссылка-приглашение (доступна только авторизованным)
    Route::get('/lists/join/{token}', [ShoppingListController::class, 'join'])->name('lists.join');
});
