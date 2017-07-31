@extends('master')

@section('title', 'Добавить аниме')

@section('content')

    <form action="{{ action('AdminAnimeController@save') }}" method="post">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="text" name="title" placeholder="Title"><br><br>
        <input type="text" name="image_url" placeholder="Image url"><br><br>
        <input type="text" name="date" placeholder="Date"><br><br>
        <input type="text" name="company_id" placeholder="Company id"><br><br>
        <textarea name="description"></textarea><br><br>
        <input type="text" name="shikimori" placeholder="Shikimori rating"><br><br>
        <input type="text" name="world-art" placeholder="World-art rating"><br><br>
        <input type="text" name="image_name" placeholder="Image name"><br><br>
        <input type="text" name="status" placeholder="Status: 0/1"><br><br>
        <input type="submit" value="go">
    </form>