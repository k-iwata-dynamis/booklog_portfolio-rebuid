<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RakutenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){


        //楽天小説の売り上げトップ10

        $keyword = $request->input('q');
        $response = Http::get('https://app.rakuten.co.jp/services/api/BooksTotal/Search/20170404' ,[
            'applicationId' => config('services.rakuten.app_id'),
            'format' => 'json',
            'sort' => 'sales',
            'hits' => 10,
            'booksGenreId' => '000',
            'keyword' => '小説'
        ]);
       
        $items = $response->json()['Items'];
       

        //ユーザーによる検索結果
        $searchItems = [];
        if(!empty($keyword)) {
            $searchResponse = Http::get('https://app.rakuten.co.jp/services/api/BooksTotal/Search/20170404',[
            'applicationId' => config('services.rakuten.app_id'),
            'format' => 'json',
            'sort' => 'sales',
            'hits' => 10,
            'booksGenreId' => '000',
            'keyword' => $keyword


            ]);

            $searchItems = $searchResponse->json()['Items'];
        }

        
         return view('dashboard',compact('items','keyword','searchItems'));

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
