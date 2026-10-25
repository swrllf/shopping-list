<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Привет, мир!';
});

Route::get('/hello/{name}', function (string $name) {
    return "Привет, {$name}!";
});

Route::get('/about', function () {
    return 'Мария, Бис-24-2'; // Замените на свои данные
});
