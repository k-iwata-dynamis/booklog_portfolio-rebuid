{{-- resources/views/books/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            本の登録
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto">
        <form action="{{ route('book.store') }}" method="POST" class="space-y-6">
            @csrf

            <input type="hidden" name="thumbnail" value="{{ request('thumbnail') }}">


            <div>
                <label for="title" class="block font-medium text-gray-700">タイトル</label>
                <input type="text" name="title" id="title" value="{{ request('title') }}" class="w-full mt-1 border rounded p-2" required>
            </div>

            <div>
                <label for="author" class="block font-medium text-gray-700">著者名</label>
                <input type="text" name="author" id="author" value="{{ request('author') }}"  class="w-full mt-1 border rounded p-2" >
            </div>

            <div>
                <label for="genre" class="block font-medium text-gray-700">ジャンル</label>
                <input type="text" name="genre" id="genre" class="w-full mt-1 border rounded p-2">
            </div>

            <div>
                <label for="finished_day" class="block font-medium text-gray-700">読了日</label>
                <input type="date" name="finished_day" id="finished_day" value="{{ date('Y-m-d') }}" class="w-full mt-1 border rounded p-2" >
            </div>

            <div>
                <label for="review" class="block font-medium text-gray-700">感想・メモ</label>
                <textarea name="review" id="review" rows="4" class="w-full mt-1 border rounded p-2"></textarea>
            </div>

            <div>
                <label for="rating" class="block font-medium text-gray-700">評価（1〜5）</label>
                <select name="rating" id="rating" class="w-full mt-1 border rounded p-2">
                    <option value="">選択してください</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} ★</option>
                    @endfor
                </select>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    登録する
                </button>
            </div>
        </form>
    </div>

<script>
function fillForm(title,author){
document.getElementById('title').value = title;
document.getElementById('author').value = author;
}
</script>

</x-app-layout>
