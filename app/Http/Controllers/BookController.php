<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Book;
use App\Tag;
use App\Author;

class BookController extends Controller
{

    /**
    * Responds to requests to GET /books
    */
    public function index()
    {
        #echo \App::environment();
        // return 'Display all the books from BookController';
        $books = Book::all();
        return view('book.index')->with('books',$books);
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
      // if(!Auth::check() ) {
      //     Session::flash('flash_message','You have to be logged in to create a new book');
      //     return redirect('/');
      // }
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
        'published'     => 'required|min:4|numeric',
        'cover'         => 'required|url',
        'purchase_link' => 'required|url',
      ]);

      # If there were errors, Laravel will redirect the user back to the page that submitted this request
      # If there were no errors, the process does continues

      # -- BAD DATA WONT PASS THSI POINT -----

        // $data = $_POST['title']; old way
        // $data = $request->except(['subject','reviews']);
        $title = $request->input('title');

        $book = new Book();
        $book->title = $request->title;
        $book->published = $request->published;
        $book->cover = $request->cover;
        $book->purchase_link = $request->purchase_link;
        $book->save();

        // return 'Process adding new book '. $title;
        return \Redirect::to('/books/create')->with(['request' => $request]);
    }

    public function edit($id = null) {

        # Get this book and eager load its tags
        $book = Book::with('tags')->find($id);

        # Get all the possible tags so we can include them with checkboxes in the view
        $tags_for_checkbox = Tag::getTagsForCheckboxes();

        # Create a simple array of just the tag names for tags associated with this book;
        # will be used in the view to decide which tags should be checked off
        $tags_for_this_book = [];
        foreach($book->tags as $tag) {
            $tags_for_this_book[] = $tag->name;
        }
        # Results in an array like this: $tags_for_this_book['novel','fiction','classic'];

      # Get all the authors
      $authors = Author::orderBy('last_name', 'ASC')->get();

      # Organize the authors into an array where the key = author id and value = author name
      $authors_for_dropdown = [];
      foreach($authors as $author) {
          $authors_for_dropdown[$author->id] = $author->last_name.', '.$author->first_name;
      }


      # Make sure $authors_for_dropdown is passed to the view
      return view('book.edit')
          ->with([
              'book' => $book,
              'authors_for_dropdown' => $authors_for_dropdown,
              'tags_for_checkbox' => $tags_for_checkbox,
              'tags_for_this_book' => $tags_for_this_book,
          ]);
        }

public function update(Request $request, $id) {

    # [...Validation removed for brevity...]

    # Find and update book
    $book = Book::find($request->id);
    $book->title = $request->title;
    $book->cover = $request->cover;
    $book->published = $request->published;
    $book->purchase_link = $request->purchase_link;
    $book->save();

    # If there were tags selected...
    if($request->tags) {
        $tags = $request->tags;
    }
    # If there were no tags selected (i.e. no tags in the request)
    # default to an empty array of tags
    else {
        $tags = [];
    }

    # Above if/else could be condensed down to this: $tags = ($request->tags) ?: [];

    # Sync tags
    $book->tags()->sync($tags);
    $book->save();

    # [... Finish removed for brevity ..]

}


} # end of class
