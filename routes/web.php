<?php


Route::get('/', function () {
    return view('welcome');
});


Route::get('/series', 'SerieController@index');
Route::post('/series/guardar', 'SerieController@store');
Route::post('/series/{id}', 'SerieController@destroy');