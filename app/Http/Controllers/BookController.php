<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BookController extends Controller
{

    /**
    * Responds to requests to GET /books
    */
    public function index()
    {
        #echo \App::environment();
        return 'Display all the books from BookController';
    }

    /**
     * Responds to requests to GET /books/{id}
     */
    public function show($title)
    {
        // return 'Display book: '.$title;
        return view('book.show')->with('title', $title);
    }

    /**
     * Responds to requests to GET /books/create
     */
    public function create()
    {
        return 'Display form to create a new book';
    }

    /**
     * Responds to requests to PUT /books
     */
    public function store()
    {
        return 'Process adding new book';
    }

} # end of class
