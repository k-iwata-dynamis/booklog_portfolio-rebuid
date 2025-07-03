<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookMark;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BookMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            
        'title' => 'required|string|max:255',
        'author' => 'nullable|string|max:255',
        'genre' => 'nullable|string|max:255',
        'price' => 'nullable|integer',
        'review_average' => 'nullable|numeric',
        'review_count' => 'nullable|integer|min:0',
        'image_url' => 'nullable|string',
        'book_url' => 'nullable|string',
        'rakuten_book_id' => 'nullable|string',
        'type' => ['required', Rule::in(['to_read','to_buy'])],
        ]);

        BookMark::create([
            'user_id' => Auth()->id(),
            'title' =>  $validated['title'],
            'author' => $validated['author'] ?? null,
            'genre' => $validated['genre'] ?? null,
            'price' => $validated['price'] ?? null,
            'review_average' => $validated['review_average'] ?? null,
            'review_count' => $validated['review_count'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'book_url' => $validated['book_url'] ?? null,
            'rakuten_book_id' => $validated['rakuten_book_id'] ?? null,
            'type' => $validated['type']


        ]);

        return redirect()->back()->with('success','後で読むに追加しました');
    }

    /**
     * Display the specified resource.
     */
    public function showToList(){
        $bookmarks = BookMark::where('user_id',Auth::id())
                            ->where('type','to_read')
                            ->get();

        return view('book.showBookList',compact('bookmarks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookMark = BookMark::where('user_id',auth()->id())->findOrFail($id);
        $bookMark ->delete();

        return redirect('/showBookList');
    }
}
