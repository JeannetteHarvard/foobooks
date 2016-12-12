<!DOCTYPE html>
<html>


    <section>
        <h1>Passing $book object from Controller to View</h1>
    </section>

    @foreach($books as $book)
        <h3>{{ $book->title }}</h3>
    @endforeach

</body>
</html>
