<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


# DWA Class Routes

// Route::get('/books', 'BookController@index')->name('books.index');
// Route::get('/books/create', 'BookController@create')->name('books.create');
// Route::post('/books', 'BookController@store')->name('books.store');
// Route::get('/books/{book}', 'BookController@show')->name('books.show');
// Route::get('/books/{book}/edit', 'BookController@edit')->name('books.edit');
// Route::put('/books/{book}', 'BookController@update')->name('books.update');
// Route::delete('/books/{book}', 'BookController@destroy')->name('books.destroy');

Route::resource('/books', 'BookController');

## DWA Practice
// Route::get('/practice', function() {
//
//     echo 'Hello from the practice route...';
//     #echo App::environment();
//
// })->name('practice');

/**
* A quick and dirty way to set up a whole bunch of practice routes
* that I'll use in lecture.
*/
Route::get('/practice', 'PracticeController@index')->name('practice.index');
for($i = 0; $i < 100; $i++) {
    Route::get('/practice/'.$i, 'PracticeController@example'.$i)->name('practice.example'.$i);
}
