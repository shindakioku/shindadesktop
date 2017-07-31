@extends('master')

@section('title', 'Создание компании')

@section('content')
    <form action="{{ action('AdminAnimeController@companyCreate') }}"
          method="post">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="text" name="name" placeholder="Name" value=""><br><br>
        <input type="text" name="date" placeholder="Date" value=""><br><br>
        <textarea name="description"></textarea><br><br>
        <input type="submit" value="go">
    </form>