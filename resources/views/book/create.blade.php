@extends('layouts.master')

@section('title', 'Add a new book')

@section('content')
  <h1>Add a New Book</h1>

  <form method='POST' action='/books/create'>

    {{ csrf_field() }}

    @if($errors->get('title'))
        <ul>
            @foreach($errors->get('title') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    Title: <input type='text' name='title' value="{{ old('title') }}">

    

    <input type='submit' value='Add new book'>

  </form>

@endsection
