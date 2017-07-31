@extends('master')

@section('title', 'Добавить песню')

@section('content')

    <form action="{{ action('AdminMusicController@save') }}" method="post">
        <input type="text" name="name" placeholder="Name"><br><br>
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="text" name="duration" placeholder="Duration"><br><br>
        <input type="text" name="source" placeholder="Link on soruce"><br><br>
        <input type="text" name="group_id" placeholder="Group id"><br><br>
        <input type="submit" value="go">
    </form>