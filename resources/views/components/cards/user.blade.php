{{-- card siswa --}}
<a href="{{ route('admin.users.detail', $student->id) }}"
    class="flex items-center gap-3 border-2 border-gray-300 px-1 py-2 hover:bg-slate-200 dark:hover:bg-slate-800 dark:border-gray-700 dark:hover:border-gray-300 transition-all hover:border-black">
    <div class="size-14 shrink-0 ml-3">
        @if ($student->profile_picture_url)
            <img src="{{ $student->profile_picture_url }}" alt="{{ $student->name }}"
                class="w-full aspect-square object-cover rounded-full" />
        @else
            <x-icons.person />
        @endif
    </div>
    <div class="overflow-auto">
        <p class="truncate w-full break-all text-xl">{{ $student->name }}</p>
        <p class="text-xs">Rata Rata : <span class="text-cyan-700 text-sm underline">{{ 98 }}</span> </p>
    </div>
</a>
