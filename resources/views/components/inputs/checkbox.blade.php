<div class="select-none">
    <label class="flex cursor-pointer items-center justify-between p-1">
        <div class="w-full">
            <span class="text-xl">{{ $label }}</span>
            <p class="text-xs text-gray-500">{{ $explanation }}</p>
        </div>
        <div class="relative inline-block">
            <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
                {{ $attributes->has('checked') ? ($attributes->get('checked') ? 'checked' : '') : '' }}
                class="peer h-6 w-12 cursor-pointer appearance-none rounded-full border border-gray-300 bg-white checked:border-gray-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-900 focus-visible:ring-offset-2">
            <span
                class="pointer-events-none absolute left-1 top-1 block h-4 w-4 rounded-full bg-gray-400 transition-all duration-200 peer-checked:left-7 peer-checked:bg-gray-900"></span>
        </div>
    </label>
</div>
