<?php

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', function(){
    return redirect('dashboard');
});


Route::get('/send_email', [App\Http\Controllers\Dashboard\ParentController::class, 'sendEmail']);
