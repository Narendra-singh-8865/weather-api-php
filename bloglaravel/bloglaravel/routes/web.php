<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\categorydata;
use App\Http\Controllers\blog_titledata;
use App\Http\Controllers\descriptionapi;
use App\Http\Controllers\SendEmail;
use App\Http\Controllers\ContactController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/homeurl', [CategoryData::class, 'homeurl']);
Route::get('/blogapi', [blog_titledata::class, 'blog_api']);
Route::get("/descriptionapi", [descriptionapi::class, 'apicallfunction']);

Route::post('/api', [SendEmail::class, 'sendMail']);
Route::post('/SendEmail', [ContactController::class, 'send']);
