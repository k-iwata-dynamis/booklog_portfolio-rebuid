<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookMarkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RakutenController;

// ルート（トップ） → ログインページへリダイレクト
Route::get('/', function () {
    return redirect()->route('login');
});

// Breeze認証ルート（ログイン、パスワード関連など）
require __DIR__.'/auth.php';

// Googleログイン認証
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ログイン後の画面 → Rakutenから本を取得して表示
//楽天で書籍検索
Route::get('/dashboard', [RakutenController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



// 認証済みユーザーだけが使えるルート
Route::middleware('auth')->group(function () {

    // プロフィール関連（Breeze標準）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 読了本登録（保存）
    Route::post('/book', [BookController::class, 'store'])->name('book.store');

    // ブックリスト表示
    Route::get('/showBookList', [BookController::class, 'index'])->name('book.index');

    // Google Books API から検索
    Route::get('/book/search', [BookController::class, 'serch'])->name('book.search');

    // 読了本を登録するページ（検索結果クリック後に遷移）
    Route::get('/createBookList', [BookController::class, 'create'])->name('book.create');

    //後で読むボタン、ビューからデータ受け取りテーブルに保存
    Route::middleware('auth')->post('/bookMark',[BookMarkController::class,'store'])->name('bookMark.store');

    //BookMarkから後から読むリストにいれた本の情報を取り出す
    //すでにget('/showBookList')は存在するので同じルートはエイリアスと使用するメソッドが違っても使えない
    //Route::middleware('auth')->get('/showBookList)',[BookMarkController::class,'showToList'])->name('bookmark.showToList');


    //読了本の錯書
    Route::middleware('auth')->delete('/book/{id}',[BookController::class,'destroy'])->name('book.destroy');
    //後で読むの削除
    Route::middleware('auth')->delete('/bookMard/{id}',[BookMarkController::class,'destroy'])->name('bookMark.destroy');
});

    

    


    
   

    

require __DIR__.'/auth.php';
