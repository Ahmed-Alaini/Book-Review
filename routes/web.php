<?php
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

Route::get('/', function () {

    return redirect()->route('books.index');
});

Route::resource('books',BookController::class );