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

    @foreach($tags_for_checkbox as $tag_id => $tag_name)
        <input
            type='checkbox'
            value='{{ $tag_id }}'
            name='tags[]'
            {{ (in_array($tag_name, $tags_for_this_book)) ? 'CHECKED' : '' }}
        >
        {{ $tag_name }} <br>
    @endforeach 

    <input type='submit' value='Add new book'>



  </form>

@endsection
