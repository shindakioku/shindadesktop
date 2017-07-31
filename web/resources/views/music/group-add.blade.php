@extends('master')

@section('title', 'Добавить группу')

@section('content')

    <form action="{{ action('AdminMusicController@createNewGroup') }}" method="post">
        <input type="text" name="name" placeholder="Name"><br><br>
        <textarea name="description"></textarea><br><br>
        <input type="text" name="people" placeholder="People"><br><br>
        <input type="text" name="date" placeholder="Date"><br><br>
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="submit" value="go">
    </form>