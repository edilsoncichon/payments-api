<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return [
        'version' => '1.0.1',
    ];
});