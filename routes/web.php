<?php

use App\Mail\Invitation;
use App\Models\Invites;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('register', function () {
    $user = User::query()->create([
        'name' => request()->name,
        'email' => request()->email,
        'password' => bcrypt(request()->password)
    ]);

    return $user;
})->name('register');

Route::post('invite', function(){
    Mail::to(request()->email)->send(new Invitation());
    Invites::create(['email' => request()->email]);
});


