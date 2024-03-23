<div class="relative z-0" x-data="{ isOpen: false }">
    <div class="border-2 transition-all flex items-center px-3 py-2 gap-3 relative z-10 rounded shadow-md"
        :class="isOpen && 'border-cyan-700 dark:border-cyan-500 dark:bg-cyan-900 bg-cyan-100 w-fit ml-3'"
        @click="isOpen=!isOpen">
        <div><img src="{{ $teacher->profile_picture_url }}" alt="teacher foto profile" class="rounded-full aspect-square"
                :class="isOpen ? 'w-6' : 'w-10'"></div>
        <div class="w-32 truncate">{{ $teacher->name }}</div>
    </div>

    <div class="border-2 border-black pt-8 pb-3 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 px-6 gap-5 rounded-md relative -top-5 w-full"
        @click.away="isOpen = false" x-show="isOpen">

        @forelse ($teacher->rooms->sortByDesc('created_at') as $room)
            @if ($room->is_active)
                <x-cards.room :room="$room" />
            @endif
        @empty
            <div class="text-center text-gray-500">Belum ada room</div>
        @endforelse
    </div>
</div>
