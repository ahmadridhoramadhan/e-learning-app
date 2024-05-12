<div class="border-b last:border-b-0 last:pb-0 last:mb-0 pb-2 mb-2 border-gray-400 dark:border-gray-600 px-2">
    <div class="text-2xl">{{ $title }}</div>
    <p class="ml-px text-xs text-gray-500 dark:text-gray-200">
        {{ $explanation }}
    </p>
    <form action="{{ $action }}" method="POST"
        onsubmit="confirm('Apakah Anda yakin ingin {{ $buttonText }}?', event)">
        @csrf
        @method($method)
        <button type="submit"
            class="block ml-auto mt-1 bg-slate-100 shadow-md rounded text-lg py-2 px-4 font-semibold text-red-700 dark:text-red-500 dark:bg-slate-800">{{ $buttonText }}</button>
    </form>
</div>
