@extends('master')

@section('title', 'Редактирование '. $company->name)

@section('content')
    <form action="{{ action('AdminAnimeController@companyUpdate', ['name' => $company->title]) }}"
          method="post">
        <input type="text" value="{{ $company->id }}"><br><br>
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="text" name="name" value="{{ $company->name }}"><br><br>
        <input type="text" name="date" value="{{ $company->date }}"><br><br>
        <textarea name="description">{{ $company->description }}</textarea><br><br>
        <input type="submit" value="go">
    </form>