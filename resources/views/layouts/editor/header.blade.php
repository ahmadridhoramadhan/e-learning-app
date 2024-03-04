    {{-- header --}}
    <div x-data="{ isOpenNav: false }">
        <header class="py-3 px-4 flex justify-between">
            <div>
                <button type="button" class="w-7 h-7" @click="isOpenNav = true">
                    <x-icons.burger />
                </button>
            </div>

            <a href="{{ route('admin.rooms.settings', request()->segment(4)) }}" class="block w-7 h-7 mr-2">
                <x-icons.settings />
            </a>
        </header>

        <nav class="fixed bottom-0 top-0 left-0 w-[90%] bg-white border-r border-black z-50 flex flex-col justify-between"
            x-show="isOpenNav">
            <div class="flex-auto overflow-y-scroll">
                <div class="px-2 my-3">
                    <button type="" class="w-8 h-8" @click="isOpenNav = false">
                        <x-icons.close />
                    </button>
                </div>

                <h1 class="text-center my-4 text-xl">{{ $attributes->get('title') }}</h1>

                <div class="grid grid-cols-5 mx-3 gap-2">
                    {{-- move between questions --}}
                    <template x-for="(question, i) in questions">
                        <div class="border border-black text-2xl aspect-square flex justify-center items-center"
                            :class="(currentIndex === i ? 'bg-cyan-200' : '')" x-text="i+1" @click="currentIndex = i">
                        </div>
                    </template>
                    <div class="border border-black text-2xl aspect-square flex justify-center items-center bg-indigo-100"
                        @click="addQuestion()">
                        <x-icons.plus />
                    </div>
                </div>

            </div>
            <div class="mb-4 flex gap-2 flex-col items-center" @click="saveToApi(currentIndex)">
                <a href="{{ route('admin.rooms.detail', request()->segment(4)) }}"
                    class="text-center py-3 w-[90%] border-indigo-500 text-indigo-700 border-2 rounded-md shadow-md">Kembali</a>
                <button type="button"
                    class="block w-[90%] text-center py-3 bg-cyan-300 border border-black rounded shadow-md">simpan</button>
            </div>
        </nav>
    </div>
