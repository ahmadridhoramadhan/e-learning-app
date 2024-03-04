<x-app-layout :title="'My Rooms'">
    <a href="{{ route('admin.rooms.create') }}"
        class="flex justify-center items-center py-2 border-2 rounded-md border-black w-full mt-2">Buat Room
        Baru</a>


    <section class="flex flex-col gap-4 mt-6">
        <div class="grid grid-cols-2 gap-6 px-2">
            @foreach ($rooms as $room)
                <x-cards.room :room="$room" />
            @endforeach
        </div>

    </section>
</x-app-layout>
