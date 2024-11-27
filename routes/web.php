<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Manic Weebs Endpoints' => app()->version()];
});

// require __DIR__.'/auth.php';
