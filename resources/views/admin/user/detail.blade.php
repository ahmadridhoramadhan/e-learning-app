<x-app-layout :class="'flex-auto container mx-auto'">
    <section x-data="{
        autoBreakLine: function(sentence) {
            return sentence.split(' ').join('<br>');
        },
    }" x-init>
        <h1 class="text-6xl font-semibold break-words leading-tight tracking-tight my-5 px-3"
            x-html="autoBreakLine('{{ $student->name }}');"></h1>
        <div class="bg-black text-white pl-6 py-10 flex flex-col gap-7 relative">
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

            <x-buttons.edit-user :$student />
        </div>
        {{-- statistik --}}
        <div class="flex justify-between gap-1 mt-1 mx-1 md:mx-0">
            <div class="border-2 border-black flex flex-col flex-auto items-center pt-2 shrink-0">
                <p>nilai rata rata</p>
                <p class="text-2xl font-bold flex items-center h-full py-4">{{ $averageScore }}</p>
            </div>
            <div class="border-2 border-black flex flex-col flex-auto items-center pt-2 shrink-0">
                <p>Room Selesai</p>
                <p class="text-2xl font-bold flex items-center h-full py-4">{{ $assessmentHistories->count() }}</p>
            </div>
            <div class="border-2 border-black flex flex-col flex-auto items-center pt-2 shrink-0">
                <p>Dikeluarkan</p>
                <p class="text-2xl font-bold flex items-center h-full py-4">{{ $totalExpelled }}</p>
            </div>
        </div>
    </section>


    {{-- room --}}
    <section class="my-10 mx-3 md:mx-0">
        {{-- filter --}}
        <div class="flex gap-2 items-center mb-5">
            <div class="w-7 h-7 shrink-0"><x-icons.filter /></div>
            <div class="text-lg">Terbaru</div>
        </div>

        <div class="grid sm:grid-cols-3 grid-cols-2 xl:grid-cols-5 justify-items-center  gap-6 px-2">
            {{-- card --}}
            @foreach ($assessmentHistories as $assessmentHistory)
                <div
                    class="border-2 flex flex-col items-center w-full aspect-square border-indigo-700 bg-indigo-100 rounded-md shadow-md max-w-60 dark:bg-indigo-950">
                    <p class="text-xs font-semibold py-2">{{ $assessmentHistory->created_at->format('d F Y') }}</p>
                    <div class="flex-auto flex items-center font-bold text-5xl">{{ $assessmentHistory->score }}</div>
                    <div class="p-2 line-clamp-2 text-sm break-words overflow-hidden">
                        {{ $assessmentHistory->room->name }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- delete zoon --}}
    <section class="border-2 rounded shadow-md py-2 border-red-600 my-8 mx-3 md:mx-0">
        {{-- card --}}
        <x-cards.delete-in-danger-zone :title="'Reset Siswa'" :explanation="'Semua room yang sudah dikerjakan siswa akan di hapus.'" :action="route('admin.users.reset.process', $student->id)" :buttonText="'Reset'"
            :method="'PUT'" />
        <x-cards.delete-in-danger-zone :title="'Hapus Siswa'" :explanation="'Siswa ini akan di hapus dan tidak dapat dikembalikan lagi.'" :action="route('admin.users.delete.process', $student->id)" />
    </section>
</x-app-layout>
{{-- FIXME: perbaiki desain ini --}}
