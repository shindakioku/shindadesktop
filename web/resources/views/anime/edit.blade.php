@extends('master')

@section('title', 'Редактирование '.$anime->title)

@section('content')
    <form action="{{ action('AdminAnimeController@update', ['name' => $anime->title]) }}"
          method="post">
        <input type="text" value="{{ $anime->id }}"><br><br>
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="text" name="title" value="{{ $anime->title }}"><br><br>
        <input type="text" name="image_url" value="{{ $anime->image_url }}"><br><br>
        <input type="text" name="date" value="{{ $anime->date }}"><br><br>
        <input type="text" name="company_id" value="{{ $anime->company_id }}"><br><br>
        <textarea name="description">{{ $anime->description }}</textarea><br><br>
        <input type="text" name="shikimori" value="{{ $anime->shikimori_rating }}"><br><br>
        <input type="text" name="world-art" value="{{ $anime->worldart_rating }}"><br><br>
        <input type="text" name="image_name" value="{{ $anime->image_name }}"><br><br>
        <input type="text" name="status" value="{{ $anime->status }}"><br><br>
        <input type="submit" value="go">
    </form>