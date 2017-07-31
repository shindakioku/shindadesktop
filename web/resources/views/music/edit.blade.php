@extends('master')

@section('title', 'Редактирование '.$music->title)

@section('content')
    <form action="{{ action('AdminMusicController@update', ['name' => $music->name]) }}"
          method="post">
        <input type="text" value="{{ $music->id }}"><br><br>
        <input type="text" name="name" value="{{ $music->name }}"><br><br>
        <input type="text" name="duration" value="{{ $music->duration }}"><br><br>
        <input type="text" name="source" value="{{ $music->link_on_source }}"><br><br>
        <input type="text" name="group_id" value="{{ $music->group_id }}"><br><br>
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="submit" value="go">
    </form>