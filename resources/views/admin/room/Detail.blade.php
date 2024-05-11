<x-app-layout :title="$room->name">
    <section class="lg:flex gap-5 justify-between items-end">

        {{-- leaderboard --}}
        <section id="leaderboard"
            class="py-4 pb-6 flex flex-col gap-3 border-b border-black  relative basis-3/5 dark:border-white dark:bg-slate-800 shadow rounded-md dark:shadow-slate-600 bg-slate-100 px-2">
            <h4 class="text-xl ml-3 bg-white dark:bg-slate-900 w-fit px-3 py-2 rounded-md shadow dark:shadow-slate-700">
                Papan Peringkat</h4>
            <div class="divide-y dark:divide-gray-400 divide-gray-700">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="w-full px-3 py-3 flex justify-between">
                        <div class="flex items-center overflow-auto">
                            <span
                                class="sm:text-2xl text-xl justify-center flex sm:w-8 w-3 flex-shrink-0">{{ $i }}.</span>
                            <div class="sm:size-8 size-6 sm:mr-3 mr-1 sm:ml-4 ml-2 flex-shrink-0">
                                @if ($assessmentHistories[$i - 1]->user->profile_picture_url ?? null)
                                    <img src="{{ $assessmentHistories[$i - 1]->user->profile_picture_url }}"
                                        class="w-full h-full rounded-full bg-black flex-shrink-0" alt="">
                                @else
                                    <x-icons.person />
                                @endif
                            </div>
                            <h5 class="truncate sm:text-base text-sm">
                                {{ $assessmentHistories[$i - 1]->user->name ?? '????' }}
                            </h5>
                        </div>
                        <span
                            class="sm:text-3xl text-2xl font-semibold dark:text-indigo-400 text-indigo-700">{{ $assessmentHistories[$i - 1]->score ?? '' }}</span>
                    </div>
                @endfor
            </div>

            <a href="{{ route('user.room.leaderBoard', $room->id) }}"
                class="flex absolute bottom-3 right-2 hover:right-0 transition-all dark:hover:text-indigo-300 hover:text-indigo-700"
                type="button">
                selengkapnya
                <div class="size-6 -rotate-90">
                    <x-icons.chevron />
                </div>
            </a>
        </section>

        {{-- info room --}}
        <section class="text-center flex-auto my-3 flex flex-col">
            <div class="text-start mb-4">
                <h1 class="text-3xl font-semibold">{{ $room->name }}</h1>
                <span class="text-sm dark:text-gray-300 text-gray-700">Status :
                    {!! $room->is_active
                        ? '<span class="text-green-600 dark:text-green-400">Buka</span>'
                        : '<span class="text-red-600 dark:text-red-400">Tutup</span>' !!}</span>
            </div>
            <div class="w-full">
                <div class="flex w-full gap-3">
                    <div
                        class="bg-slate-100 shadow dark:shadow-slate-600 border-slate-700 dark:border-slate-300 dark:bg-slate-800 rounded py-2 w-full">
                        <div>Partisipan</div>
                        <div class="text-3xl">{{ $totalParticipant }}</div>
                    </div>
                    <div
                        class="bg-slate-100 shadow dark:shadow-slate-600 border-slate-700 dark:border-slate-300 dark:bg-slate-800 rounded py-2 w-full">
                        <div>nilai rata rata</div>
                        <div class="text-3xl">{{ $averageScore }}</div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mt-4 gap-2">
                <a href="{{ route('admin.rooms.edit', $room) }}"
                    class="py-3 border rounded shadow-md border-cyan-800 bg-cyan-200 w-full flex justify-center items-center gap-1 dark:bg-cyan-800 dark:border-cyan-300">
                    Edit Room
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1" />
                            <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3zM16 5l3 3" />
                        </g>
                    </svg>
                </a>
                <a href="{{ route('user.room.detail', $room->id) }}"
                    class="py-3 border-2 rounded shadow-md w-full border-indigo-600">Coba Soal</a>
            </div>
        </section>

    </section>

    <section class="my-20 bg-slate-100 shadow dark:shadow-slate-600 dark:bg-slate-800 rounded p-2">
        <div class="">
            <div class="bg-white shadow dark:shadow-slate-600 dark:bg-slate-900 rounded p-2 w-fit whitespace-nowrap">
                meminta izin masuk kembali
            </div>
            <p class="text-gray-700 dark:text-gray-400 text-sm mt-2">orang yang muncul disini adalah orang yang saat
                mengejakan mereka ke luar dari browser atau situs ini</p>
        </div>


        <div class="mt-5 mb-2 gap-4 px-2 divide-y-2 divide-gray-700 dark:divide-gray-400">
            {{-- card --}}
            @foreach (auth()->user()->studentWarnings()->where('status', 'pending')->get() as $warning)
                <div class="flex py-2 justify-between items-center w-full">
                    <div class="flex gap-2 pl-2 items-center overflow-auto">
                        <div class="size-7 flex-shrink-0">
                            @if ($warning->fromUser->profile_picture_url)
                                <img src="{{ $warning->fromUser->profile_picture_url }}"
                                    class="rounded-full shadow dark:shadow-slate-600" alt="">
                            @else
                                <x-icons.person />
                            @endif
                        </div>
                        <div class="flex-auto overflow-auto flex-grow-0">
                            <p class="break-all truncate text-xl overflow-auto">{{ $warning->fromUser->name }}</p>
                            <div class="text-xs dark:text-gray-400 text-gray-700 -mt-1">
                                {{ $warning->fromUser->fromClassroom->name }}
                            </div>
                        </div>
                    </div>

                    <div class="flex mx-1 gap-2">
                        <button data-dropdown-toggle="dropdownDots{{ $warning->id }}"
                            data-dropdown-placement="bottom-start"
                            class="flex-shrink-0 inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-slate-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                            type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                <path
                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </button>
                        <div id="dropdownDots{{ $warning->id }}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconButton">
                                <li>
                                    <form action="{{ route('admin.student.warning.accept', $warning->id) }}"
                                        method="POST" onsubmit="return confirm('Apakah anda yakin?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">
                                            izinkan
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.student.warning.decline', $warning->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Siswa tidak bisa lagi masuk ke room ini. Apakah anda yakin?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-start">
                                            keluarkan
                                        </button>
                                    </form>

                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="border-t border-cyan-900 dark:border-cyan-400">
            <p class="text-center mt-3">siswa yang dikeluarkan</p>
            <div class="mb-2 gap-4 px-2 divide-y-2 divide-gray-700 dark:divide-gray-400 opacity-50">
                {{-- card --}}
                @foreach (auth()->user()->studentWarnings()->where('status', 'declined')->get() as $warning)
                    <div class="flex py-2 justify-between items-center w-full">
                        <div class="flex gap-2 pl-2 items-center overflow-auto">
                            <div class="size-7 flex-shrink-0">
                                @if ($warning->fromUser->profile_picture_url)
                                    <img src="{{ $warning->fromUser->profile_picture_url }}"
                                        class="rounded-full shadow dark:shadow-slate-600" alt="">
                                @else
                                    <x-icons.person />
                                @endif
                            </div>
                            <div class="flex-auto overflow-auto flex-grow-0">
                                <p class="break-all truncate text-xl overflow-auto">{{ $warning->fromUser->name }}</p>
                                <div class="text-xs dark:text-gray-400 text-gray-700 -mt-1">
                                    {{ $warning->fromUser->fromClassroom->name }}
                                </div>
                            </div>
                        </div>

                        <div class="flex mx-1 gap-2">
                            <form action="{{ route('admin.student.warning.pending', $warning->id) }}" method="POST"
                                onsubmit="return confirm('Apakah anda yakin?')">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="p-1 px-2 dark:border-cyan-300 dark:bg-cyan-900 border rounded-lg">
                                    kembalikan
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- undang kelas --}}
    <section class="my-20 bg-slate-100 shadow dark:shadow-slate-600 dark:bg-slate-800 rounded p-2">
        <div class="sm:flex space-y-2 sm:space-y-0 items-center gap-2">
            <div class="bg-white shadow dark:shadow-slate-600 dark:bg-slate-900 rounded p-2 w-fit whitespace-nowrap">
                Undang Kelas
            </div>

            <form action="" class="w-full block">
                <div class="relative flex items-center border-2 rounded-md border-black w-full dark:border-white">
                    <input type="text" name="search" id="search" placeholder="Search"
                        class="pl-7 w-full pr-1 outline-none py-1 bg-transparent ring-0 border-0">
                    <button type="submit" class="w-5 h-5 absolute left-1">
                        <x-icons.search />
                    </button>
                    <div class="absolute top-[105%] rounded-b-md left-0 right-0 bg-slate-200 dark:bg-slate-700 divide-y-2 divide-gray-400 dark:divide-gray-600"
                        id="container-livesrarch">
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-5 mb-2 gap-4 px-2 divide-y-2 divide-gray-700 dark:divide-gray-400">
            {{-- card --}}
            @forelse ($invitedClassrooms as $classroom)
                <div class="flex py-2 justify-between items-center w-full overflow-hidden">
                    <div class="flex gap-2 pl-2 items-center">
                        <div class="size-7">
                            @if ($classroom->teacher->profile_picture_url)
                                <img src="{{ $classroom->teacher->profile_picture_url }}"
                                    class="rounded-full shadow dark:shadow-slate-600" alt="">
                            @else
                                <x-icons.person />
                            @endif
                        </div>
                        <div>
                            <p class="break-all truncate w-48 text-2xl">{{ $classroom->name }}</p>
                            <div class="text-xs dark:text-gray-400 text-gray-700 -mt-1">
                                {{ $classroom->teacher->name }}
                            </div>
                        </div>
                    </div>

                    <div class="flex mx-1 gap-1">
                        <form
                            action="{{ route('admin.invite.classroom.delete.process', [$room->id, $classroom->id]) }}"
                            method="POST" onsubmit="return confirm('apakah anda yakin?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dark:text-red-500 text-red-600">
                                {{-- delete --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-700 dark:text-gray-400">Anda Tidak Mengundang Kelas Mana pun</p>
            @endforelse
        </div>
    </section>


    {{-- delete zoon --}}
    <section class="border-2 rounded shadow-md py-2 border-red-600 my-8 dark:border-red-500">
        {{-- card --}}
        <x-cards.delete-in-danger-zone :action="route('admin.rooms.closeOrOpen.process', $room->id)" :title="($room->is_active ? 'Tutup' : 'Buka') . ' Room'" :explanation="'Room akan di tutup sampai anda membukanya. Data tidak akan hilang namun siswa tidak dapat menjawab lagi.'" :buttonText="$room->is_active ? 'Tutup' : 'Buka'"
            :method="'PUT'" />
        <x-cards.delete-in-danger-zone :action="route('admin.rooms.questions.reset.process', $room->id)" :title="'Hapus Semua Soal'" :explanation="'semua soal akan di hapus dari room. Data lain akan tetap di simpan'" />
        <x-cards.delete-in-danger-zone :action="route('admin.rooms.reset.process', $room->id)" :title="'Reset Data'" :explanation="'Semua Data siswa yang menjawab akan di hapus termasuk guru yang jadi pengawas.'" :buttonText="'Reset'" />
        <x-cards.delete-in-danger-zone :action="route('admin.rooms.delete.process', $room->id)" :title="'Hapus Room'" :explanation="'Semua data akan di hapus termasuk data siswa yang mengerjakan'" />
    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const search = document.getElementById('search');
        const container = document.getElementById('container-livesrarch');
        search.addEventListener('keyup', function() {
            let query = this.value;
            if (query != '') {
                $.ajax({
                    url: "{{ route('search.invite.classroom') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        data.forEach(classroom => {
                            container.innerHTML = `
                                    <a href="{{ route('admin.invite.classroom', $room->id) }}/${classroom['id']}"
                                        class="pl-4 py-3 block">
                                        <p class="font-semibold text-xl">${classroom['name']}</p>
                                    </a>
                                    `;

                        });;


                    }
                });
            } else {
                container.innerHTML = '';
            }
        });
    </script>

</x-app-layout>
