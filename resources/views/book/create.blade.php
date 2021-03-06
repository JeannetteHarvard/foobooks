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

    <div class='form-group'>
       <label>* Title:</label>
        <input
            type='text'
            id='title'
            name='title'
            value='{{ old('title','Green Eggs and Ham') }}'
        >
        <div class='error'>{{ $errors->first('title') }}</div>
    </div>

    <input type='submit' value='Add new book'>



  </form>

@endsection
