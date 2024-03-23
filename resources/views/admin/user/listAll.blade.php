<x-app-layout :title="'List Siswa'">
    <div x-init class="flex flex-col gap-10">
        @foreach ($classrooms as $classroom)
            <div class="dark:bg-slate-800 rounded-md shadow-md dark:shadow-slate-500 p-5 bg-slate-50 relative">
                <form action="{{ route('admin.class.delete.process', $classroom->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="size-10 absolute top-3 right-3 dark:text-red-400 text-red-800 p-2 bg-slate-900 rounded-md">
                        <x-icons.trash />
                    </button>
                </form>
                <form action="{{ route('admin.class.edit.process', $classroom->id) }}"
                    id="formEditClass{{ $classroom->id }}" method="post">
                    @csrf
                    <input type="text" name="name" value="{{ $classroom->name }}"
                        onblur="if(confirm('Apakah Anda yakin ingin mengganti nama kelas?')) {document.getElementById('formEditClass{{ $classroom->id }}').submit()}"
                        class="text-3xl font-semibold w-full focus:border-b-2 border-black outline-none bg-transparent border-0 ring-0 text-center mb-7">
                </form>
                <div class="grid gap-5 place-items-center xl:grid-cols-5 grid-cols-2 lg:grid-cols-3">
                    <x-buttons.add-user :classroomId="$classroom->id" />
                    @foreach ($classroom->students as $student)
                        <div
                            class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-full">
                            <div class="flex justify-end px-4 pt-4">
                                <button id="dropdownButton" data-dropdown-toggle="dropdown{{ $loop->index }}"
                                    class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                                    type="button">
                                    <span class="sr-only">Open dropdown</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 16 3">
                                        <path
                                            d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown{{ $loop->index }}"
                                    class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2" aria-labelledby="dropdownButton">
                                        <li>
                                            <x-buttons.edit-user :$student />
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export
                                                Data</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.users.delete.process', $student->id) }}"
                                                method="post"
                                                onsubmit="return confirm('apakah anda yakin ingin menghapus siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full text-start px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-300 dark:hover:text-red-400">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.detail', $student->id) }}"
                                class="flex flex-col items-center pb-10 px-1">
                                @if ($student->profile_picture_url == null)
                                    <div class="size-24 mb-3 rounded-full shadow-lg">
                                        <x-icons.person />
                                    </div>
                                @else
                                    <img class="w-24 h-24 mb-3 rounded-full shadow-lg"
                                        src="{{ $student->profile_picture_url }}" alt="{{ $student->name }} image" />
                                @endif
                                <h5
                                    class="mb-1 text-xl font-medium text-center text-gray-900 dark:text-white line-clamp-2">
                                    {{ $student->name }}</h5>
                                <span
                                    class="text-sm text-gray-500 w-full text-center dark:text-gray-400 truncate">{{ $student->email }}</span>

                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach
        <!-- Modal toggle -->
        <button type="button" data-modal-target="create-class-modal" data-modal-toggle="create-class-modal"
            class="dark:bg-slate-800 rounded-md shadow-md dark:shadow-slate-500 p-5 bg-slate-50 flex justify-center items-center">
            <div class="size-16">
                <x-icons.plus />
            </div>
            <p>Buat kelas baru</p>
        </button>


        <!-- Main modal -->
        <div id="create-class-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Buat Kelas Baru
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="create-class-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="{{ route('admin.class.create.process') }}" method="POST">
                            @csrf
                            <div>
                                <label for="classname"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                    Kelas</label>
                                <input type="text" name="name" id="classname"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Nama Kelas Yang Ingin Di Buat" required />
                            </div>

                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buat
                                Kelas</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
