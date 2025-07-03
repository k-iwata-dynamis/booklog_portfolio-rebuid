<x-app-layout>
  <x-slot name="header">
    <!-- Google Booksで検索できるようにする（必要ならここにフォームなどを追加） -->
  </x-slot>

  {{-- 読了本セクション --}}
  <h2 class="w-screen text-center bg-black text-white text-2xl font-bold py-4">読了本</h2>
  <section class="max-w-screen-xl mx-auto px-4 py-8">
    <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
      @foreach ($bookInfo as $book)
        <div class="relative mx-auto w-full">
          <div class="relative inline-block w-full transform transition-transform duration-300 ease-in-out hover:-translate-y-2">
            <div class="rounded-lg bg-white p-4 shadow">
              <div class="relative flex h-52 justify-center overflow-hidden rounded-lg">
                <div class="w-full transform transition-transform duration-500 ease-in-out hover:scale-110">
                  <div class="absolute inset-0 bg-black bg-opacity-80">
                    @php
                      $link = route('book.create', [
                        'title' => $book->title,
                        'author' => $book->author,
                        'thumbnail' => $book->thumbnail,
                      ]);
                    @endphp
                    <img src="{{ $book->thumbnail ?? 'https://via.placeholder.com/150x200?text=No+Image' }}" 
                         alt="{{ $book->title }}" 
                         class="object-cover w-full h-full cursor-pointer"
                         onclick="window.location.href='{{ $link }}'" />
                  </div>
                </div>
              </div>

              <div class="mt-4">
                <h3 class="line-clamp-1 text-xl font-bold text-gray-800" title="{{ $book->title }}">{{ $book->title }}</h3>
                <p class="text-sm text-gray-700 mt-1">著者: {{ $book->author ?? '不明' }}</p>
                <p class="text-sm text-gray-700">ジャンル: {{ $book->genre ?? 'なし' }}</p>
                <p class="text-sm text-gray-700">読了日: {{ $book->finished_day }}</p>
                <p class="mt-2 text-sm text-gray-800">感想: {{ $book->review ?? '（なし）' }}</p>
                <p class="mt-1 text-yellow-500">評価: {{ $book->rating ? str_repeat('★', $book->rating) : '未評価' }}</p>

                <form method="POST" action="{{ route('book.destroy', $book->id) }}" onsubmit="return confirm('削除しますか？')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="w-full mt-2 rounded border-red-500 bg-white px-3 py-1 text-base font-bold text-red-500 transition duration-100 hover:bg-yellow-400 hover:text-red-900">
                    削除する
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- 後で読むセクション --}}
<h2 class="w-screen text-center bg-black text-white text-2xl font-bold py-4">後で読む</h2>
<section class="bg-gray-100 py-12 rounded-lg">
  <div class="max-w-screen-xl mx-auto px-4">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
      @foreach($bookmarks as $bookmark)
        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 p-4 flex flex-col items-center text-center">
          <a href="{{ $bookmark->book_url }}" target="_blank" class="block w-full relative group">
            <div class="relative h-60 overflow-hidden rounded-md">
              <img src="{{ $bookmark->image_url ?? 'https://placehold.co/150x200?text=No+Image' }}"
                   alt="{{ $bookmark->title }}"
                   class="w-full h-full object-cover rounded-md transform transition-transform duration-500 ease-in-out group-hover:scale-110" />
            </div>
          </a>

          <p class="mt-2 text-sm font-bold break-words line-clamp-2 text-gray-800">
            {{ Str::limit($bookmark->title, 20) }}
          </p>
          <p class="text-sm text-gray-500 break-words truncate max-w-[180px]">
            {{ $bookmark->author ?? '著者不明' }}
          </p>

          <form method="POST" action="{{ route('bookMark.destroy', $bookmark->id) }}" onsubmit="return confirm('削除しますか？')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full mt-2 rounded border-red-500 bg-white px-3 py-1 text-base font-bold text-red-500 transition duration-100 hover:bg-yellow-400 hover:text-red-900">
              削除する
            </button>
          </form>
        </div>
      @endforeach
    </div>
  </div>
</section>

</x-app-layout>
