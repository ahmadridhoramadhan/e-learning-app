<div class="relative h-11 w-full min-w-[200px]">
    <input placeholder="{{ $label }}" type="{{ $type ?? 'text' }}" name="{{ $name }}"
        id="{{ $id ?? $name }}" {{ $attributes->has('required') ? 'required' : '' }} value="{{ $value }}"
        class="{{ $error != '' ? 'border-red-400' : 'border-indigo-300' }} peer outline-none focus:ring-0 border-0 h-full w-full px-2 border-b bg-transparent pt-4 pb-1.5 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border-blue-gray-200 focus:border-gray-500 focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50 placeholder:opacity-0 focus:placeholder:opacity-100" />
    <label for="{{ $id ?? $name }}"
        class="{{ $error != '' ? 'text-red-600' : 'text-gray-500' }} after:content[''] dark:peer-focus:text-white dark:peer-focus:after:border-white dark:after:border-gray-200 dark:text-white pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight transition-all after:absolute after:-bottom-1.5 after:block after:w-full after:scale-x-0 after:border-b-2 after:border-gray-500 after:transition-transform after:duration-300 peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.25] peer-placeholder-shown:text-blue-gray-500 peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:after:scale-x-100 peer-focus:after:border-gray-900 peer-disabled:text-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
        {{ $label }} <span class="text-red-600">{{ $attributes->has('required') ? '*' : '' }}</span>
    </label>
    <p class="text-xs text-red-600">{{ $error ?? '' }}</p>
</div>
