<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Carbon;
use App\Book;
use App\Author;

class PracticeController extends Controller
{
    //

    public function example3() {

      # Echo out what the mail => driver config is set to
      echo config('mail.driver');
      echo '<br>';
      # Dump *all* of the mail configs
      dump(config('mail'));
      echo '<br>';
      echo '<br>';
      echo '<br>';

      // echo 'Environment: '.\App::environment();
      if(\App::environment() == 'local'){
        echo "Environment is local!";
      } else {
        echo "Environment is NOT local!";
      }
      echo '<br>';
      echo'App debug: '.config('app.debug');
      echo '<br>';
      echo config('mail.driver');
    }

    public function example4() {
      $random = new \Rych\Random\Random();
      return $random->getRandomString(8);
    }

    public function example5(){
      # Use the QueryBuilder to get all the books
      $books = DB::table('books')->get();

      # Output the results
      foreach ($books as $book) {
      echo $book->title.'<br>';
      }

      echo "<h2>next</h2>";
      # Use the QueryBuilder to get all the books where author is like "%Scott%"
      $books = DB::table('books')->where('author', 'LIKE', '%Scott%')->get();

      # Output the results
      foreach($books as $book) {
          echo $book->title.'<br>';
      }
    }

    public function example6() {
      # Use the QueryBuilder to insert a new row into the books table
      # i.e. create a new book
      DB::table('books')->insert([
          'created_at' => Carbon\Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
          'title' => 'The Great Gatsby2',
          'author' => 'F. Scott Fitzgerald',
          'published' => 1925,
          'cover' => 'http://img2.imagesbn.com/p/9780743273565_p0_v4_s114x166.JPG',
          'purchase_link' => 'http://www.barnesandnoble.com/w/the-great-gatsby-francis-scott-fitzgerald/1116668135?ean=9780743273565',
      ]);
    }

    public function example7() {

        # Instantiate a new Book Model object
        $book = new Book();

        # Set the parameters
        # Note how each parameter corresponds to a field in the table
        $book->title = 'Harry Potter';
        $book->author = 'J.K. Rowling';
        $book->published = 1997;
        $book->cover = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_link = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';

        # Invoke the Eloquent save() method
        # This will generate a new row in the `books` table, with the above data
        $book->save();

        echo 'Added: '.$book->title;
    }

    public function example8() {
      $books = Book::all();

      # Make sure we have results before trying to print them...
      if(!$books->isEmpty()) {

          # Output the books
          foreach($books as $book) {
              echo $book->title.'<br>';
          }
      }
      else {
          echo 'No books found';
      }
    }

    public function example9() {
      # where() is the constraint method
      # first() is the fetch method
      $book = Book::where('author', 'LIKE', '%Scott%')->first();

      if($book) {
          return $book->title;
      }
      else {
          return 'Book not found.';
      }
          }

    public function example10() {

      # First get a book to update
      $book = Book::where('author', 'LIKE', '%Scott%')->first();

      # If we found the book, update it
      if($book) {

          # Give it a different title
          $book->title = 'The Really Great Gatsby';

          # Save the changes
          $book->save();

          echo "Update complete; check the database to see if your update worked...";
      }
      else {
          echo "Book not found, can't update.";
      }
    }

    public function example11() {
      # First get a book to delete
      $book = Book::where('author', 'LIKE', '%Scott%')->first();

      # If we found the book, delete it
      if($book) {

          # Goodbye!
          $book->delete();

          return "Deletion complete; check the database to see if it worked...";

      }
      else {
          return "Can't delete - Book not found.";
      }
    }

    public function example12() {
      $books = Book::all();
      // dump($books);
      // echo $books;

      # loop through the Collection and access just the data
      foreach($books as $book) {
          // echo $book['title']."<br>";
          echo $book->title."<br>";
      }
    }

    public function example13() {
      $books = Book::all();
      return view('book.index')->with('books', $books);
    }

    public function example14() {
      $books = Book::all();
      dump($books->toArray());
    }

    public function example15() {
      /*
      2 separate queries on the database:
      */
      $books = Book::orderBy('id','descending')->get();
      $first = Book::orderBy('id','descending')->first();
      dump($first);

    }

    public function example16() {

      /*
      1 query on the database, 1 query on the collection (better):
      */
      $books = Book::orderBy('id','descending')->get(); # Query DB
      $first_book = $books->first(); # Query Collection

      dump($first_book);

    }

    public function example17() {
      // Associate an author with a book
      // https://github.com/susanBuck/dwa15-fall2016-notes/blob/master/03_Laravel/26_Relationships_One_to_Many.md
      # To do this, we'll first create a new author:
      $author = new Author;
      $author->first_name = 'J.K';
      $author->last_name = 'Rowling';
      $author->bio_url = 'https://en.wikipedia.org/wiki/J._K._Rowling';
      $author->birth_year = '1965';
      $author->save();
      dump($author->toArray());

      # Then we'll create a new book and associate it with the author:
      $book = new Book;
      $book->title = "Harry Potter and the Philosopher's Stone";
      $book->published = 1997;
      $book->cover = 'http://prodimage.images-bn.com/pimages/9781582348254_p0_v1_s118x184.jpg';
      $book->purchase_link = 'http://www.barnesandnoble.com/w/harrius-potter-et-philosophi-lapis-j-k-rowling/1102662272?ean=9781582348254';
      $book->author()->associate($author); # <--- Associate the author with this book
      $book->save();
      dump($book->toArray());
    }

    public function example18() {

      # Get the first book as an example
      $book = Book::first();

      # Get the author from this book using the "author" dynamic property
      # "author" corresponds to the the relationship method defined in the Book model
      $author = $book->author;

      # Output
      dump($book->title.' was written by '.$author->first_name.' '.$author->last_name);
      dump($book->toArray());
      // dump($author);

    }

    public function example19() {
      $book = Book::where('title', '=', 'The Great Gatsby')->first();

      dump($book->title);

      foreach($book->tags as $tag) {
          dump($tag->name);
      }

    }

    public function example20() {
      $books = Book::with('tags')->get();

      foreach($books as $book) {
          dump($book->title.' is tagged with: ');
          foreach($book->tags as $tag) {
              dump($tag->name);
          }
      }      
    }
}
