<?php

/**
 * main page
 */
Route::get('/', 'IndexController@index');

/**
 * compiler route
 */
Route::get('/compile', 'IndexController@compile');

/**
 * add/update markers
 */
Route::post('/api/marker', 'ApiController@marker');

/**
 * retrieve all markers
 */
Route::get('/api/markers', 'ApiController@markers');

/**
 * remove a marker
 */
Route::post('/api/remove', 'ApiController@remove');

/**
 * get starter data
 */
Route::get('/api/start', 'ApiController@start');

/**
 * authenticate a user
 */
Route::post('/api/auth', 'ApiController@auth');

/**
 * register a report for a marker
 */
Route::post('/api/report', 'ApiController@report');

/**
 * register a sight for a marker
 */
Route::post('/api/sight', 'ApiController@sight');

/**
 * get one "my locations"
 */
Route::post('/api/location', 'ApiController@location');

/**
 * remove one "my location"
 */
Route::post('/api/remove-location', 'ApiController@removeLocation');