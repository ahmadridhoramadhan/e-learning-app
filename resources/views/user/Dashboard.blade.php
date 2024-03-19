<x-app-layout :class="'flex-auto'">
    <div class="dark:bg-slate-800 bg-slate-100 rounded-md shadow dark:shadow-slate-600 py-5 px-3 mb-5">
        <div class="flex items-center gap-2 ml-6">
            <div class="size-10">
                @if (auth()->user()->fromClassroom->teacher->profile_picture_url)
                    <img src="{{ auth()->user()->fromClassroom->teacher->profile_picture_url }}" alt="profile"
                        class="w-full h-full rounded-full bg-black">
                @else
                    <x-icons.person />
                @endif
            </div>
            <div>
                <p class="font-semibold text-3xl">{{ auth()->user()->fromClassroom->name }}</p>
                <p class="text-xs text-gray-500 -mt-1 dark:text-gray-400">
                    {{ auth()->user()->fromClassroom->teacher->name }} <span class="text-white px-2">|</span>
                    {{ auth()->user()->fromClassroom->teacher->email }}
                </p>
            </div>
        </div>

    </div>
    <div class="grid grid-cols-3 gap-5">
        <div
            class="dark:bg-slate-800 bg-slate-100 gap-3 flex justify-center items-center flex-col rounded-md shadow dark:shadow-slate-600 py-5">
            <span class="text-center text-sm sm:text-base">Nilai Rata Rata</span>
            <span class="text-3xl">{{ $averageScore }}</span>
        </div>
        <div
            class="dark:bg-slate-800 bg-slate-100 gap-3 flex justify-center items-center flex-col rounded-md shadow dark:shadow-slate-600 py-5">
            <span class="text-center text-sm sm:text-base">Room di kerjakan</span>
            <span class="text-3xl">{{ $totalAlreadyDone }}</span>
        </div>
        <div
            class="dark:bg-slate-800 bg-slate-100 gap-3 flex justify-center items-center flex-col rounded-md shadow dark:shadow-slate-600 py-5">
            <span class="text-center text-sm sm:text-base">dikeluarkan dari room</span>
            <span class="text-3xl">{{ auth()->user()->warnings()->where('status', 'declined')->get()->count() }}</span>
        </div>
    </div>

    <div class="container mx-auto">

        {{-- room --}}
        <section class="my-10 mx-3 md:mx-0">
            {{-- filter --}}
            <div class="flex gap-2 items-center mb-5">
                <div class="w-7 h-7 shrink-0"><x-icons.filter /></div>
                <div class="text-lg">Terbaru</div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 place-items-center lg:grid-cols-5 xl:grid-cols-6 gap-6 px-2">
                {{-- card --}}
                @foreach ($assessmentHistories as $assessmentHistory)
                    <a href="{{ route('user.room.detail', [$assessmentHistory->room->id, $assessmentHistory->id]) }}"
                        class="border-2 text-center relative flex flex-col items-center w-full aspect-square border-indigo-700 dark:hover:bg-indigo-950 bg-indigo-100 dark:bg-transparent rounded-md shadow-md max-w-48">
                        <time class="text-xs py-2 absolute top-0 left-0 right-0">
                            {{ \Carbon\Carbon::parse($assessmentHistory->created_at)->format('j F Y') }}</time>
                        <div class="flex-auto flex items-center font-bold text-5xl">{{ $assessmentHistory->score }}
                        </div>
                        <div
                            class="p-2 line-clamp-2 text-center break-words overflow-hidden font-semibold absolute bottom-0 left-0 right-0">
                            {{ $assessmentHistory->room->name }}</div>
                    </a>
                @endforeach
            </div>
        </section>

    </div>
</x-app-layout>
