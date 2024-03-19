<div class="relative w-full">
    <input type={{ $type ?? 'text' }} name={{ $name }} id={{ $name }} placeholder=" "
        class="w-full outline-none border-2 px-2 py-2 rounded dark:border-gray-400 peer text-lg bg-transparent {{ $error != '' ? 'border-red-600' : 'border-black' }}"
        required>
    <label for={{ $name }}
        class="absolute peer-placeholder-shown:left-3 peer-placeholder-shown:top-2 dark:bg-slate-900 peer-placeholder-shown:text-lg peer-focus:-top-3 peer-focus:-left-1 peer-focus:text-sm text-sm -left-1 -top-3 bg-white px-1 transition-all after:text-red-700 after:content-['*']">{{ $label }}
    </label>
    <p class="text-red-700">
        {{ $error }}
    </p>
</div>
