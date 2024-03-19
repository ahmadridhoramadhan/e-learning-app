<x-app-layout :title="'leaderBoard'">
    {{-- profile owner --}}
    <a href="{{ route('user.room.detail', $room->id) }}" class="flex gap-3 items-center mb-10 group">
        <div class="size-10 inline-block relative group-hover:-left-2 left-0 transition-all rotate-90">
            <x-icons.chevron />
        </div>
        <div class="flex-auto dark:bg-slate-800 shadow dark:shadow-slate-600 py-4 bg-slate-100">
            <div class="flex items-center gap-2 ml-6">
                <div class="size-10">
                    @if ($room->user->profile_picture_url)
                        <img src="{{ $room->user->profile_picture_url }}" alt="profile"
                            class="w-full h-full rounded-full bg-black">
                    @else
                        <x-icons.person />
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-3xl">{{ $room->name }}</p>
                    <p class="text-xs text-gray-500 -mt-1 dark:text-gray-400">{{ $room->user->name }}</p>
                </div>
            </div>
        </div>
    </a>

    <div class="dark:bg-slate-800 bg-slate-100 rounded-md shadow dark:shadow-slate-600 px-2 py-5">
        <div class="dark:bg-slate-900 w-fit shadow dark:shadow-slate-600 p-3 rounded-md mb-3">
            Nilai Semua Siswa
        </div>
        <div class="divide-y dark:divide-slate-400 divide-slate-700">
            @foreach ($assessmentHistories as $assessmentHistory)
                <div class="w-full px-3 py-3 flex justify-between">
                    <div class="flex items-center overflow-auto">
                        <span
                            class="sm:text-2xl text-xl justify-center flex sm:w-8 w-3 flex-shrink-0">{{ $loop->iteration }}.</span>
                        <div class="sm:size-8 size-6 sm:mr-3 mr-1 sm:ml-4 ml-2 flex-shrink-0">
                            @if ($assessmentHistory->user->profile_picture_url ?? null)
                                <img src="{{ $assessmentHistory->user->profile_picture_url }}"
                                    class="w-full h-full rounded-full bg-black flex-shrink-0" alt="">
                            @else
                                <x-icons.person />
                            @endif
                        </div>
                        <h5 class="truncate sm:text-base text-sm">{{ $assessmentHistory->user->name ?? '????' }}
                        </h5>
                    </div>
                    <span
                        class="sm:text-3xl text-2xl font-semibold dark:text-indigo-400 text-indigo-700">{{ $assessmentHistory->score ?? '' }}</span>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
