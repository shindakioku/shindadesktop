@extends('master')

@section('title', 'Саундтреки к '.$title)

@section('content')
    <form action="{{ action('AdminAnimeController@soundSave', ['id' => $anime_id]) }}"
          method="post">
        <input type="text" name="music_new" placeholder="Id of music" value=""> <br><br>

        <input type="hidden" name="anime_title" value="{{ $title }}">

        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

        @forelse($music as $k => $v)
            <input type="text" name="music[{{ $v->id }}]" value="{{ $v->music_id }}"> <br><br>
        @empty
        @endforelse

        <input type="submit" value="go">
    </form>