
<x-app-layout>
    {{-- ヘッダー --}}
    {{-- 楽天で検索 --}}

     {{--おすすめ本表示領域--}}
      @if(session('success'))
            <div class="text-center max-w-xl mx-auto my-4 p-4 bg-green-100 text-green-800 text-sm rounded border border-green-300 shadow">
                {{session('success')}}
            </div>
            @endif

            
<div class="w-full px-4">
    <div id="search-bar" class="max-w-xl mt-10 mx-auto bg-white rounded-md shadow-lg z-10">
        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center justify-center p-2">
            <input 
                type="text" 
                name="q"
                placeholder="何を読もうかな？"
                value="{{ old('q', $keyword ?? '') }}"
                class="w-full rounded-md px-4 py-2 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 shadow-inner"
            >
            <button 
                type="submit"
                class="bg-gray-900 text-white font-semibold px-4 py-2 rounded-md hover:bg-gray-700 transition whitespace-nowrap min-w-[6rem]"
            >
                楽天で検索
            </button>
        </form>
    </div>
</div>
    
@if(!empty($searchItems))
<div class="max-w-6xl mx-auto mt-10">
    <h2 class="text-lg text-center font-bold mb-4">"{{ $keyword }}" の検索結果</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($searchItems as $searchitem)
            @php $book = $searchitem['Item']; @endphp
            <div class="bg-white rounded shadow p-3 text-sm flex flex-col justify-between h-full max-w-[180px] mx-auto">
                <div>
                    <img 
                        src="{{ $book['largeImageUrl'] }}" 
                        alt="{{ $book['title'] }}" 
                        class="w-full h-auto mb-2 object-contain rounded"
                    >
                    <div class="font-bold truncate mb-1">{{ $book['title'] }}</div>
                    <div class="text-gray-600 text-xs truncate mb-1">{{ $book['author'] }}</div>
                    <a 
                        href="{{ $book['itemUrl'] }}" 
                        target="_blank" 
                        class="text-blue-500 text-xs underline inline-block mb-2 hover:text-blue-700"
                    >
                        楽天で見る
                    </a>
                </div>

                <form method="POST" action="{{ route('bookMark.store') }}" class="mt-auto">
                    @csrf
                    <input type="hidden" name="title" value="{{ $book['title'] }}">
                    <input type="hidden" name="author" value="{{ $book['author'] }}">
                    <input type="hidden" name="price" value="{{ $book['itemPrice'] }}">
                    <input type="hidden" name="review_average" value="{{ $book['reviewAverage'] }}">
                    <input type="hidden" name="image_url" value="{{ $book['mediumImageUrl'] }}">
                    <input type="hidden" name="book_url" value="{{ $book['itemUrl'] }}">
                    <input type="hidden" name="type" value="to_read">

                    <button 
                        type="submit"
                        class="w-full mt-2 rounded border border-black bg-white px-2 py-1 text-xs font-semibold hover:bg-yellow-400 hover:text-black transition"
                    >
                        後で読むリストに追加
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endif

    

    {{--メインコンテンツ--}}

    {{--楽天で検索--}}
    

   

    <section class="bg-grey-200 py-12">
  <div class="max-w-screen-xl mx-auto px-4">
    <h2 class="text-xl font-bold mb-6">Rakuten Bookでの売り上げトップテン10</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
      @foreach($items as $item)
        @php $book = $item['Item'] ?? null; @endphp
        @if($book)
          <div class="w-full text-center border border-gray-200 p-2 min-h-[300px] flex flex-col justify-between">
            <a href="{{ $book['itemUrl'] }}" target="_blank">
              <img src="{{ $book['largeImageUrl'] }}" alt="{{ $book['title'] }}"
                   class="w-24 h-auto mx-auto rounded shadow">
            </a>
            <p class="mt-2 text-sm font-bold break-words">{{ Str::limit($book['title'], 30) }}</p>
            <p class="text-xs text-gray-600">{{ $book['author'] ?? '' }}</p>

          

            {{--後で読むに追加ボタン--}}
            <form method="POST" action="{{route('bookMark.store')}}" class="mt-2">
                @csrf

               

                <input type="hidden" name="title" value="{{$book['title']}}">
                <input type="hidden" name="author" value="{{$book['author']}}">
                <input type="hidden" name="price" value="{{$book['itemPrice']}}">
                <input type="hidden" name="review_average" value="{{$book['reviewAverage']}}">
                
                <input type="hidden" name="image_url" value="{{$book['mediumImageUrl']}}">
                <input type="hidden" name="book_url" value="{{$book['itemUrl']}}">
                
                <input type="hidden" name="type" value="to_read">
                <button type="submit"class="relative inline-block h-full w-full rounded border-2 border-black bg-white px-3 py-1 text-base font-bold text-black transition duration-100 hover:bg-yellow-400 hover:text-gray-900">
                    後で読むリストに追加

                </button>
  
            </form>
            
            
          </div>

         
        @endif
      @endforeach
    </div>
  </div>

            
</section>




    

    {{--読了本登録フォーム--}}
    <div class="flex flex-wrap justify-center gap-6">
 <a href="{{route('book.create')}}" class="relative">
        <span class="absolute top-0 2left-0 mt-1 ml-1 h-full w-full rounded bg-gray-700"></span>
        <span class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-black px-3 py-1 text-base font-bold text-white transition duration-100 hover:bg-gray-900 hover:text-yellow-500">ブックリストに追加</span>
    </a>

    <a href="{{route('book.index')}}" class="relative">
        <span class="absolute top-0 2left-0 mt-1 ml-1 h-full w-full rounded bg-gray-700"></span>
        <span class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-black px-3 py-1 text-base font-bold text-white transition duration-100 hover:bg-gray-900 hover:text-yellow-500">ブックリストを表示</span>
    </a>

    <a href="{{route('book.index')}}" class="relative">
        <span class="absolute top-0 2left-0 mt-1 ml-1 h-full w-full rounded bg-gray-700"></span>
        <span class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-black px-3 py-1 text-base font-bold text-white transition duration-100 hover:bg-gray-900 hover:text-yellow-500">後で読むリストを表示</span>
    </a>
</div>

{{--読了本を検索して登録--}}

<div class="w-full px-4 mt-24 mb-40" >
<h2 class="text-xl font-bold text-center mb-6">本をキーワードから検索して登録</h2>
   <div
    class="mx-auto relative bg-white max-w-2xl flex flex-col md:flex-row items-center justify-center border py-2 px-2 rounded-2xl gap-2 shadow-2xl focus-within:border-gray-300">
     
    <input id="searchTitle" placeholder="読了本を検索して登録"
        class="px-6 py-2 w-full rounded-md flex-1 outline-none bg-white">
    <button onclick="searchBook()"
        class="w-full md:w-auto px-6 py-3 bg-black border-black text-white fill-white active:scale-95 duration-100 border will-change-transform overflow-hidden relative rounded-xl transition-all disabled:opacity-70">
        
        <div class="relative">

            <!-- Loading animation change opacity to display -->
            <div
                class="flex items-center justify-center h-3 w-3 absolute inset-1/2 -translate-x-1/2 -translate-y-1/2 transition-all">
                <svg class="opacity-0 animate-spin w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <div class="flex items-center transition-all opacity-1 valid:"><span
                    class="text-sm font-semibold whitespace-nowrap truncate mx-auto">
                    検索
                </span>
            </div>

        </div>
        
    </button>
</div>
</div>




<!-- 結果を表示する場所 -->
 <div class="w-full px-4 mt-24 mb-40" >
<h2 class="text-xl font-bold text-center mb-6">検索結果</h2>

<div id="result" class="mt-4"></div>

    <main class="mt-4">
       

</main>

<!-- ブレードテンプレート内 -->
<div id="search-container" data-book-form-url="{{ route('book.create') }}"></div>
 </div>




</x-app-layout>
<script>
     
function searchBook() {
    const searchUrl = "{{ route('book.search') }}";
    const title = document.getElementById('searchTitle').value;

    // 安全にルートを取得
    const bookFormUrl = document.getElementById('search-container').dataset.bookFormUrl;

    fetch(`${searchUrl}?q=${encodeURIComponent(title)}`)
        .then(res => res.json())
        .then(data => {
            let resultHTML = '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">';
            data.forEach(book => {
                const info = book.volumeInfo;
                const bookTitle = info.title || '不明';
                const authors = (info.authors || []).join(', ');
                let thumbnail = info.imageLinks?.thumbnail;

                if (thumbnail) {
                thumbnail = thumbnail.replace('http://', 'https://');
                    }  else {     
                thumbnail = 'https://placehold.co/150x200?text=No+Image';
                    }
        


                const link = `${bookFormUrl}?title=${encodeURIComponent(bookTitle)}&author=${encodeURIComponent(authors)}&thumbnail=${encodeURIComponent(thumbnail)}`;

                resultHTML += `
                    <div class="book-item border p-4 my-2 cursor-pointer"
                         onclick="window.location.href='${link}'">
                        <strong>タイトル：</strong> ${bookTitle}<br>
                        <strong>著者：</strong> ${authors}<br>
                        <img src="${thumbnail}" alt="カバー写真">
                    </div>
                `;
            });
            resultHTML += '</div>';
            document.getElementById('result').innerHTML = resultHTML;
        })
        .catch(error => {
            console.error(error);
            document.getElementById('result').innerText = '検索エラーが発生しました';
        });
}
</script>