<x-app-layout :title="'My Rooms'">
    <section class="flex flex-col gap-4">
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 2xl:grid-cols-7 place-items-center gap-6">
            <div class="w-full">
                <x-cards.addroom />
                <p class="text-center">Buat Room Baru</p>
            </div>
            @foreach ($rooms as $room)
                <x-cards.room :room="$room" />
            @endforeach
        </div>
    </section>
</x-app-layout>
