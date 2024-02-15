<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return BookResource::collection(Book::with('ratings')->paginate(10));
    }

    /**
     * Display a user data with DTO.
     */
    public function userData() {
        $user = User::find(1);

        // Create a DTO object and populate it with user data
        $userDataDTO = new UserDTO($user);

        dd($userDataDTO->userEmail());

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $book = Book::create([
        'user_id' => $request->user_id,
        'title' => $request->title,
        'description' => $request->description,
      ]);


      return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
      return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
      // check if currently authenticated user is the owner of the book
      if ($request->user()->id !== $book->user_id) {
        return response()->json(['error' => 'You can only edit your own books.'], 403);
      }

      $book->update($request->only(['title', 'description']));

      return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
      $book->delete();

      return response()->json(null, 204);
    }
}
