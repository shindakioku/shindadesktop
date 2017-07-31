<?php

// Main
Route::get('/main/version', 'MainController@version');

// Anime
Route::get('/anime/', 'AnimeController@all');

// Only names with id
Route::get('/get-anime', 'AnimeController@forShinda');

Route::get('/anime/{id}', 'AnimeController@byId');

// Companies
Route::get('/company/{id}', 'AnimeController@companyById');

Route::get('/company/{id}/anime', 'AnimeController@animeById'); // id - company

// Sound tracks
Route::get('/soundtracks/{id}', 'AnimeController@tracksById'); // id - anime

// Music
Route::get('/music', 'MusicController@all');

// Only names with id
Route::get('/get-music', 'MusicController@forShinda');

Route::get('/music/{id}', 'MusicController@byId');

// Groups
Route::get('/group/{id}', 'MusicController@groupById');

Route::get('/group/{id}/music', 'MusicController@musicById'); // id - music

// User
Route::post('/auth', 'UserController@auth');

Route::post('/user/add-favorite', 'UserController@addFavorite');

Route::get('/user/{id}/favorite-anime', 'UserController@favoriteAnime');

Route::get('/user/{id}/favorite-music', 'UserController@favoriteMusic');

Route::get('/user/{id}/has-favorite/{entity}/{entity_id}', 'UserController@hasFavorite');
