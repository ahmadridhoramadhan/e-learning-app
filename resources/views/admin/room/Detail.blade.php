<x-app-layout :title="$room->name">
    <section class="flex gap-5 justify-between items-center">
        <section id="leaderboard" class="py-4 flex-auto flex flex-col gap-2 border-b h-fit border-black max-w-2xl ">
            {{-- leaderboard card 1 --}}
            @foreach ($assessmentHistories as $assessmentHistory)
                <x-cards.leaderBoard :number="$loop->iteration" :name="$assessmentHistory->user->name" :score="$assessmentHistory->score" />
            @endforeach
        </section>


        <section class="text-center my-8 flex-auto ml-20">
            <div class="flex justify-around">
                <div
                    class="aspect-square w-1/3 bg-cyan-100 border-2 border-cyan-700 rounded py-2 flex flex-col justify-around">
                    <span>Partisipan</span>
                    <span class="text-3xl">{{ $totalParticipant }}</span>
                </div>
                <div
                    class="aspect-square w-1/3 bg-cyan-100 border-2 border-cyan-700 rounded py-2 flex flex-col justify-around">
                    <span>nilai rata rata</span>
                    <span class="text-3xl">{{ $averageScore }}</span>
                </div>

            </div>
            <div class="flex flex-col items-center mt-4 gap-2">
                <a href="{{ route('user.room.detail', $room->id) }}"
                    class="py-3 border-2 rounded shadow-md w-full border-indigo-600">Coba Soal</a>
                <a href="{{ route('admin.rooms.edit', $room) }}"
                    class="py-3 border rounded shadow-md border-black bg-cyan-300 w-full flex justify-center items-center gap-1">
                    Edit Room
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                        </g>
                    </svg>
                </a>
            </div>
        </section>

    </section>


    {{-- undang guru --}}
    <section class="border-2 my-8 border-indigo-600 rounded shadow-md p-2">
        <div class="flex items-center">
            <form action="" class="w-full block">
                <div class="relative flex items-center border-2 rounded-md px-px border-black w-full">
                    <input type="text" name="search" id="search" placeholder="Search"
                        class="pl-7 w-full pr-1 outline-none py-1">
                    <button type="submit" class="w-5 h-5 absolute left-1">
                        <x-icons.search />
                    </button>
                </div>
            </form>

            <div class="mx-2 w-8">
                <x-icons.chevron />
            </div>
        </div>
        <div class="mt-5 mb-2 flex flex-col gap-4">
            {{-- card --}}
            <div class="flex justify-between items-center w-full overflow-hidden">
                <div class="flex gap-2 items-center flex-auto">
                    <div class="rounded-full w-8 h-8 bg-black">
                        <img src="" alt="">
                    </div>
                    <div class="flex-auto">
                        <p class="break-all truncate w-48">Ahmad Ridho Ramadhan</p>
                    </div>
                </div>
                <div class="mx-1">
                    {{-- delete --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </div>
            </div>
        </div>
    </section>


    {{-- undang kelas --}}
    <section class="border-2 my-8 border-indigo-600 rounded shadow-md p-2">
        <div class="flex items-center">
            <form action="" class="w-full block">
                <div class="relative flex items-center border-2 rounded-md px-px border-black w-full">
                    <input type="text" name="search" id="search" placeholder="Search"
                        class="pl-7 w-full pr-1 outline-none py-1">
                    <button type="submit" class="w-5 h-5 absolute left-1">
                        <x-icons.search />
                    </button>
                </div>
            </form>

            <div class="mx-2 w-8">
                <x-icons.chevron />
            </div>
        </div>
        <div class="mt-5 mb-2 flex flex-col gap-4">
            {{-- card --}}
            <div class="flex justify-between items-center w-full overflow-hidden">
                <div class="flex-auto">
                    <p class="break-all truncate w-48 text-2xl">kelas</p>
                </div>

                <div class="flex mx-1 gap-1">
                    <div class="">
                        {{-- update --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                    <div class="">
                        {{-- delete --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- delete zoon --}}
    <section class="border-2 rounded shadow-md py-2 border-red-600 my-8">
        {{-- card --}}
        <x-cards.deleteindangerzone :action="route('admin.rooms.closeOrOpen.process', $room->id)" :title="($room->is_active ? 'Tutup' : 'Buka') . ' Room'" :explanation="'Room akan di tutup sampai anda membukanya. Data tidak akan hilang namun siswa tidak dapat menjawab lagi.'" :buttonText="$room->is_active ? 'Tutup' : 'Buka'"
            :method="'PUT'" />
        <x-cards.deleteindangerzone :action="route('admin.rooms.questions.reset.process', $room->id)" :title="'Hapus Semua Soal'" :explanation="'semua soal akan di hapus dari room. Data lain akan tetap di simpan'" />
        <x-cards.deleteindangerzone :action="route('admin.rooms.reset.process', $room->id)" :title="'Reset Data'" :explanation="'Semua Data siswa yang menjawab akan di hapus termasuk guru yang jadi pengawas.'" :buttonText="'Reset'" />
        <x-cards.deleteindangerzone :action="route('admin.rooms.delete.process', $room->id)" :title="'Hapus Room'" :explanation="'Semua data akan di hapus termasuk data siswa yang mengerjakan'" />
    </section>
</x-app-layout>
