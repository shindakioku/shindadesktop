@extends('master')

@section('title', 'Серии к '.$title)

@section('content')

    <form action="{{ action('AdminAnimeController@seriesSave', ['id' => $anime_id]) }}"
          method="post">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

        <input type="hidden" name="anime_title" value="{{ $title }}">

        <input type="text" name="series_link" placeholder="Link on source" value=""> <br><br>

        @forelse($series as $k => $v)
            <input type="text" name="series[{{ $v->id }}]" value="{{ $v->link_on_video }}"> <br><br>
        @empty
        @endforelse

        <input type="submit" value="go">
    </form>