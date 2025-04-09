<?php
use App\Http\Controllers\Product_masterController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\Mail_userController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\INDcontroller;
use App\Http\Controllers\We5day;
use App\Http\Controllers\NewsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group(['prefix' => 'auth'], function () use ($router) {

    $router->post('login', [AuthController::class, 'login'])->name('auth.login');

    $router->post('refresh_token', [AuthController::class, 'refresh'])->name('auth.refresh');

    $router->post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    $router->post('register', [AuthController::class, 'register'])->name('auth.register');

    $router->post('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgotPassword');
});

Route::apiResource('contact_us', ContactUsController::class);
Route::apiResource('product', Product_masterController::class);

Route::post('send-otp', [OtpController::class, 'sendOtp']); 
Route::post('verify-otp', [OtpController::class, 'verifyOtp']);

//Route::post('getWeather', [WeatherController::class, 'getWeather']);

Route::get('/state', [IndController::class, 'state']);
Route::post('/city', [IndController::class, 'city']);
Route::post('/getWeathers', [IndController::class, 'getWeathers']);

Route::get('/news', [NewsController::class, 'index']);

Route::get('/rajasthan', [NewsController::class, 'rj']);
Route::get('/news', [NewsController::class, 'index'])->name('news');

Route::post('/mail', [Mail_userController::class, 'sendEmail']);


//Route::get('/weathersday', [We5day::class, 'getWeatherser']);


Route::get('/status', function () {
    return response()->json(['status' => 'API is running!','version' => '1.26']);
});


 