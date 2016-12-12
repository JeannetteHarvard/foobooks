<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('book.create');
    }

    /**
     * Responds to requests to PUT /books
     */
     /**
 * Store a newly created resource in storage.
 *
 *@param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {
      # Validate
      $this->validate($request, [
        'title' => 'required|min:3|alpha_num',
      ]);

      # If there were errors, Laravel will redirect the user back to the page that submitted this request
      # If there were no errors, the process does continues

      # -- BAD DATA WONT PASS THSI POINT -----

        // $data = $_POST['title']; old way
        // $data = $request->except(['subject','reviews']);
        $title = $request->input('title');

        // return 'Process adding new book '. $title;
        return \Redirect::to('/books/create')->with(['request' => $request]);
    }

} # end of class
