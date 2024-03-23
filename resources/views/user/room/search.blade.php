<x-app-layout :title="'cari '">
    <div class="max-w-lg mx-auto mb-10" x-data="{ selected: 'room', value: '' }">
        <div class="flex relative">
            <label for="search-dropdown"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white relative">Your
                Email</label>
            <button id="dropdown-button" data-dropdown-toggle="dropdown"
                class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                type="button">
                <span x-text="selected == '' ? 'kategori' : selected"></span>
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="dropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                    <li>
                        <label class="w-full">
                            <input type="radio" name="category" x-model="selected" value="teacher"
                                class=" peer z-10 h-full w-full cursor-pointer hidden"
                                :selected="selected == 'teacher'" />
                            <div
                                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:bg-gray-600 dark:peer-checked:text-white peer-checked:bg-gray-100">
                                Guru</div>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="category" class="peer hidden" x-model="selected" value="room"
                                :selected="selected == 'room'" />
                            <div
                                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:peer-checked:bg-gray-600 dark:peer-checked:text-white peer-checked:bg-gray-100">
                                Room
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="relative w-full">
                <input type="search" id="search-dropdown" @keyup="search(selected, value)" x-model="value"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    :placeholder="'cari ' + selected" autocomplete="off" />
            </div>
            <div class="absolute w-full z-10 top-full dark:bg-slate-800 bg-gray-50 rounded-b-md"
                id="container-result-search"></div>
        </div>
    </div>
    <div class="flex flex-col gap-5">
        {{-- card close --}}
        @foreach ($teachers as $teacher)
            <x-cards.rooms-teacher-list :$teacher />
        @endforeach
    </div>

    <script>
        const containerResultSearch = document.getElementById('container-result-search');

        async function search(categories, value) {
            try {
                const res = await fetch(`{{ route('user.search') }}?categories=${categories}&name=${value}`);
                const data = await res.json();

                if (res.ok) {
                    switch (categories) {
                        case 'teacher':
                            containerResultSearch.innerHTML = '';
                            data.teachers.forEach(teacher => {
                                containerResultSearch.innerHTML += `
                                    <a href="{{ route('user.room.search') }}/${teacher.id}" class="w-full gap-2 flex py-3 pl-2 overflow-auto">
                                        <div class="size-6 flex-shrink-0">
                                            <img src="${ teacher.profile_picture_url }"
                                                class="rounded-full w-full h-full" />
                                        </div>
                                        <div class="truncate">${teacher.name}</div>
                                    </a>
                                `;
                            });
                            break;

                        case 'room':
                            containerResultSearch.innerHTML = '';
                            data.rooms.forEach(room => {
                                containerResultSearch.innerHTML = `
                                    <a href="{{ route('user.room.detail') }}/${room.id}" class="block py-3 pl-2"> ${room.name}</a>
                                `;
                            });
                            break;

                        default:
                            containerResultSearch.innerHTML = '';
                            containerResultSearch.innerHTML = `
                                        <div class="py-3 pl-2 text-center">pilih kategori</div>
                                    `;

                            break;
                    }
                    console.log(data)
                }

            } catch (error) {
                console.error(error);
            }
        }
    </script>
</x-app-layout>
