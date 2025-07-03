<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookMark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookInfo= Book::where('user_id',Auth::id())
        ->orderBy('finished_day','desc')
        ->get();
        
        $bookmarks= BookMark::where('user_id',Auth::id())
                            ->where('type','to_read')
                            ->get();



        return view('book.showBookList', compact('bookInfo','bookmarks'));


        
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
{
    $title = $request->input('title');
    $author = $request->input('author');
    $thumbnail = $request->input('thumbnail');

    return view('book.createBookList', compact('title', 'author', 'thumbnail'));
}

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required|string|max:255',
            'author' =>'nullable|string|max:255',
            'genre'=> 'nullable|string|max:255',
            'finished_day'=> 'date',
            'review' => 'nullable|string',
            'rating' => 'nullable|string|min:1|max:5',
            'thumbnail' => 'nullable|string|max:255'
        ]);
         $validated['user_id'] = auth()->id();
    
        Book::create($validated);
           
            return redirect()->route('book.index');

    }

    /**
     * Display the specified resource.
     */
     public function storeToReadbook(Request $request)
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
        

        $secureImageUrl = isset($validated['image_url']) ? str_replace('http://','https://',$validated['image_url']) : null;
        $secureBookUrl = isset($validated['book_url']) ? str_replace('http://','https://',$validated['book_url']) : null;

        
        BookMark::create([
            'user_id' => Auth()->id(),
            'title' =>  $validated['title'],
            'author' => $validated['author'] ?? null,
            'genre' => $validated['genre'] ?? null,
            'price' => $validated['price'] ?? null,
            'review_average' => $validated['review_average'] ?? null,
            'review_count' => $validated['review_count'] ?? null,
            'image_url' => $secureImageUrl,
            'book_url' => $secureBookUrl,
            'rakuten_book_id' => $validated['rakuten_book_id'] ?? null,
            'type' => $validated['type']


        ]);

        return redirect()->back()->with('suucces','ブックマークに追加しました');
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
        $book = Book::where('user_id',auth()->id())->findOrFail($id);
        $book -> delete();

        return redirect()->back();
    }

    public function serch(Request $request){
        $query = $request->input('q');
        if(!$query){
            return response()->json(['error'=>'検索後が必要です'],400);
        }

        $response= Http::get('https://www.googleapis.com/books/v1/volumes',[
            'q'=>$query,
            'maxResult'=>5
        ]);

        $data = $response->json();
        return response()->json($data['items'] ?? []);

    }
}
