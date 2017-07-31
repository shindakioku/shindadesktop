@extends('master')

@section('title', 'Изменить группу' . $group->name)

@section('content')

    <form action="{{ action('AdminMusicController@updateGroup', ['name' => $group->name]) }}" method="post">
        <input type="text" value="{{ $group->id }}"><br><br>
        <input type="text" name="name" value="{{ $group->name }}"><br><br>
        <textarea name="description">{{ $group->description }}</textarea><br><br>
        <input type="text" name="people" value="{{ $group->people }}"><br><br>
        <input type="text" name="date" value="{{ $group->date }}"><br><br>
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="submit" value="go">
    </form>