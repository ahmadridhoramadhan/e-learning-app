<header class="my-3 mx-2 z-50 container md:mx-auto">

    <div class="flex justify-between select-none">
        <form action="" class="w-full">
            <div class="relative flex items-center border-2 rounded-md px-px border-black w-40 md:w-96 md:py-1">
                <input type="text" name="search" id="search" placeholder="Search"
                    class="pl-7 w-full pr-1 outline-none py-1">
                <button type="submit" class="w-5 h-5 absolute left-1">
                    <x-icons.search />
                </button>
            </div>
        </form>

        <div x-data="{ isOpen: false }" class="relative flex items-center">
            <button @click="isOpen = !isOpen" class="flex items-center">
                <div class="h-4 w-4 ">
                    <div :class="'transition-all ' + (isOpen ? ' rotate-180' : '')">
                        <x-icons.chevron />
                    </div>
                </div>
                <div class="w-6 h-6">
                    <x-icons.person />
                </div>
            </button>

            <div x-show="isOpen" @click.away="isOpen = false;" x-transition
                class="absolute top-3/4 right-0 mt-2 z-50 w-40 bg-white rounded-md shadow-lg py-1">
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ Route::is('admin.dashboard') ? 'text-black font-semibold' : 'text-gray-700' }}">Dashboard</a>
                    <a href="{{ route('admin.rooms') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ Route::is('admin.rooms') || Route::is('admin.rooms.detail') ? 'text-black font-semibold' : 'text-gray-700' }}">My
                        Rooms</a>
                    <a href="{{ route('admin.users') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ Route::is('admin.users') ? 'text-black font-semibold' : 'text-gray-700' }}">Siswa</a>
                    <a href="{{ route('user.room.search') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ Route::is('user.room.search') ? 'text-black font-semibold' : 'text-gray-700' }}">Cari
                        Room</a>
                @else
                    <a href="{{ route('user.dashboard') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ Route::is('user.dashboard') ? 'text-black font-semibold' : 'text-gray-700' }}">Dashboard</a>

                    <a href="{{ route('user.room.search') }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-100 {{ Route::is('user.room.search') ? 'text-black font-semibold' : 'text-gray-700' }}">Cari
                        Room</a>
                @endif
                <div class="border-t-2 border-gray-200 mx-2"></div>
                <a href={{ route('logout') }}
                    class="px-4 py-2 text-sm text-red-700 hover:bg-gray-100 flex gap-1 items-center">Logout
                    <div class="w-4 h-4">
                        <x-icons.logout />
                    </div>
                </a>
            </div>
        </div>
    </div>

</header>
