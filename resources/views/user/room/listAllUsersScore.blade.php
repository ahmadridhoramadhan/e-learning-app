<x-app-layout :title="'leaderBoard'">
    {{-- profile owner --}}
    <section class="mb-10 mt-4">
        <a href="{{ route('user.room.detail', $room->id) }}" class="flex items-center gap-2 ml-3">
            <div class="w-10 h-10">
                <img src="" alt="profile" class="w-full h-full rounded-full bg-black">
            </div>
            <div>
                <p class="font-semibold text-3xl">{{ $room->name }}</p>
                <p class="text-xs text-gray-500 -mt-2">{{ $room->user->name }}</p>
            </div>
        </a>
    </section>
    <div class="flex flex-col gap-4 mb-5">
        @foreach ($assessmentHistories as $assessmentHistory)
            <x-cards.leaderBoard :number="$loop->iteration" :name="$assessmentHistory->user->name" :score="$assessmentHistory->score" />
        @endforeach
    </div>
</x-app-layout>
