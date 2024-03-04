<div class="border-b last:border-b-0 last:pb-0 last:mb-0 pb-2 mb-2 border-gray-400 px-2">
    <div class="text-2xl">{{ $title }}</div>
    <p class="ml-px text-xs text-gray-500">
        {{ $explanation }}
    </p>
    <form action="{{ $action }}" method="POST">
        @csrf
        @method($method ?? 'DELETE')
        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin {{ $buttonText ?? 'hapus' }}?')"
            class="block ml-auto mt-1 bg-slate-50 shadow-md border border-red-500 rounded text-lg py-2 px-4 font-semibold text-red-700">{{ $buttonText ?? 'Hapus' }}</button>
    </form>
</div>
