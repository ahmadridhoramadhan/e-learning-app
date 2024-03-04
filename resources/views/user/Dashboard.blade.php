<x-app-layout :class="'flex-auto'">
    <section x-data="{
        autoBreakLine: function(sentence) {
            return sentence.split(' ').join('<br>');
        },
    }" x-init>
        <h1 class="text-6xl font-semibold break-words leading-tight tracking-tight my-5 px-3 container mx-auto"
            x-html="autoBreakLine('{{ $student->name }}');"></h1>
        <div class="bg-black text-white relative">
            <div class="container mx-auto pl-6 py-10 flex flex-col gap-7">
                {{-- email --}}
                <div class="flex gap-2 items-center">
                    <div class="w-7 h-7 shrink-0"><x-icons.email /></div>
                    <p class="truncate">{{ $student->email }}</p>
                </div>
                {{-- password --}}
                <div class="flex gap-2 items-center">
                    <div class="w-7 h-7 shrink-0"><x-icons.padlock /></div>
                    <p class="truncate">{{ $student->password }}</p>
                </div>
            </div>
        </div>
        {{-- statistik --}}
        <div class="grid grid-cols-3 gap-1 mt-1 container mx-auto">
            <div class="border-2 border-black flex flex-col flex-auto items-center pt-2 shrink-0">
                <p>nilai rata rata</p>
                <p class="text-2xl font-bold flex items-center h-full py-4">{{ $averageScore }}</p>
            </div>
            <div class="border-2 border-black flex flex-col flex-auto items-center pt-2 shrink-0">
                <p class="text-sm text-center">Room dikerjakan</p>
                <p class="text-2xl font-bold flex items-center h-full py-4">{{ $totalAlreadyDone }}</p>
            </div>
            <div class="border-2 border-black flex flex-col flex-auto items-center pt-2 shrink-0">
                <p>Dikeluarkan</p>
                <p class="text-2xl font-bold flex items-center h-full py-4">99.5</p>
            </div>
        </div>
    </section>

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
                        class="border-2 flex flex-col items-center w-full aspect-square border-indigo-700 bg-indigo-100 rounded-md shadow-md max-w-52">
                        <p class="text-xs py-2">
                            {{ \Carbon\Carbon::parse($assessmentHistory->created_at)->format('j F Y') }}</p>
                        <div class="flex-auto flex items-center font-bold text-5xl">{{ $assessmentHistory->score }}
                        </div>
                        <div class="p-2 line-clamp-2 break-words overflow-hidden font-semibold">
                            {{ $assessmentHistory->room->name }}</div>
                    </a>
                @endforeach
            </div>
        </section>

    </div>
</x-app-layout>
