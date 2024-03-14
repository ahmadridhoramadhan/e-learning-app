<x-app-layout :title="'Dashboard'">
    {{-- newest room --}}
    <section class="flex flex-col mt-5 gap-4">
        <h2 class="text-3xl ">ROOM</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 place-items-center lg:grid-cols-5 xl:grid-cols-6 gap-6 px-2">
            <div class="w-full">
                <x-cards.addroom />
                <p class="text-center">Buat Room Baru</p>
            </div>
            @foreach ($rooms as $room)
                <x-cards.room :room="$room" />
            @endforeach
        </div>

        @if ($rooms->count() > 5)
            <div class="ml-auto">
                <x-button.see-more :href="route('admin.rooms')" />
            </div>
        @endif

    </section>

    <section class="mb-16 mt-32 dark:bg-slate-800 rounded-md bg-gray-100 shadow dark:shadow-slate-500 py-5 px-3">
        <h3 class="text-center mb-10 mt-6 text-3xl">Kelas Anda</h3>
        <div class="grid xl:grid-cols-2 gap-5">
            @foreach ($classrooms as $classroom)
                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-full">
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center py-5">
                        <h5 class="mb-1 text-4xl font-semibold text-center text-gray-900 dark:text-white line-clamp-2">
                            {{ $classroom->name }}
                        </h5>
                        <span class="text-sm text-gray-500 w-full text-center dark:text-gray-400 truncate"><span
                                class="underline text-base">{{ $classroom->students->count() }}</span>
                            siswa</span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

</x-app-layout>
