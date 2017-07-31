<?php

// Auth
Route::get('/', 'AuthController@view');

Route::post('/', 'AuthController@auth');

Route::group(
    ['middleware' => 'auth'], function () {
    // Music
    Route::get('/add-music', 'AdminMusicController@viewAdd');

    Route::post('/add-music', 'AdminMusicController@save');

    Route::get('/music/{name}', 'AdminMusicController@edit');

    Route::post('/music/{name}', 'AdminMusicController@update');

// Music groups
    Route::get('/music/new/group', 'AdminMusicController@newGroupView');

    Route::post('/music/new/group', 'AdminMusicController@createNewGroup');

    Route::get('/music/group/{name}', 'AdminMusicController@editGroup');

    Route::post('/music/group/{name}', 'AdminMusicController@updateGroup');

// Anime
    Route::get('/add-anime', 'AdminAnimeController@viewAdd');

    Route::post('/add-anime', 'AdminAnimeController@save');

    Route::get('/anime/{name}', 'AdminAnimeController@edit');

    Route::post('/anime/{name}', 'AdminAnimeController@update');

// Series
    Route::get('/anime/{name}/series', 'AdminAnimeController@seriesAddView');

    Route::post('/anime/{id}/series', 'AdminAnimeController@seriesSave');

// Sound Tracks
    Route::get('/anime/{name}/soundtracks', 'AdminAnimeController@soundAddView');

    Route::post('/anime/{name}/soundtracks', 'AdminAnimeController@soundSave');

// Companies
    Route::get('/anime/company/{name}', 'AdminAnimeController@companyView');

    Route::post('/anime/company/{name}', 'AdminAnimeController@companyUpdate');

    Route::get('/anime/new/company', 'AdminAnimeController@companyCreateView');

    Route::post('/anime/new/company', 'AdminAnimeController@companyCreate');
}
);

// 404
Route::get(
    '/404', function () {
    return view('404');
}
);