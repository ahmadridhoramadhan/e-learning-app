{{-- card siswa --}}
<a href="{{ route('admin.users.detail', $student->id) }}"
    class="flex items-center gap-3 border-2 border-gray-300 px-1 py-2 hover:bg-slate-200 transition-all hover:border-black">
    <div class="w-7 h-7 shrink-0 ml-3">
        <x-icons.person />
    </div>
    <div class="overflow-auto">
        <p class="truncate w-full break-all text-xl">{{ $student->name }}</p>
        <p class="text-xs">Rata Rata : <span class="text-cyan-700 text-sm underline">{{ 98 }}</span> </p>
    </div>
</a>
