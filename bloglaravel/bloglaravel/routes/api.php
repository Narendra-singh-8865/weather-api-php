<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmail;

Route::post('/SendEmail', [SendEmail::class, 'sendMail']);
