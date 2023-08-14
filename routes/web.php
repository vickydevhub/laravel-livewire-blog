<?php

use App\Http\Livewire\Post;
use App\Http\Livewire\Authentication;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/',function(){
    return view('welcome');
 });

 Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

 Route::get('/posts', Post::class)->name('posts')->middleware('auth');

 Route::get('/auth', Authentication::class)->name('auth');