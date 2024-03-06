<x-app-layout :title="'Dashboard'">
    {{-- newest room --}}
    <section class="flex flex-col gap-4">
        <h2 class="text-3xl ">ROOM</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 place-items-center lg:grid-cols-5 xl:grid-cols-6 gap-6 px-2">
            <x-cards.addroom />
            @foreach ($rooms as $room)
                <x-cards.room :room="$room" />
            @endforeach
        </div>
        <div class="ml-auto">
            <x-button.see-more :href="route('admin.rooms')" />
        </div>
    </section>

    {{-- top 5 students --}}
    <section class="my-16 mx-auto xl:max-w-screen-xl">
        <div class="relative border-2 border-indigo-500 rounded-md shadow-md p-2 mt-5 pt-6">
            <div
                class="border-2 border-cyan-600 bg-cyan-100 absolute whitespace-nowrap -top-7 font-semibold text-xl px-4 py-2 rounded left-[50%] transform -translate-x-1/2">
                {{ $class->name ?? '? ? ?' }}
            </div>

            @if (isset($class->name))
                <div class="flex flex-col gap-3" x-init>
                    {{-- button tambah siswa --}}
                    <x-button.add-user />

                    {{-- list siswa --}}
                    @forelse ($students as $student)
                        <x-cards.user :$student />
                    @empty
                        <div class="text-xl flex items-center justify-center font-bold text-gray-500">
                            Tidak ada siswa
                        </div>
                    @endforelse

                    {{-- button selengkapnya --}}
                    <div class="ml-auto">
                        <x-button.see-more :href="route('admin.users')" />
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    <div class="text-center">
                        <h2 class="text-2xl">Anda tidak mempunyai kelas</h2>
                        <form action="{{ route('admin.class.create.process') }}" method="post">
                            @csrf
                            <input type="text" name="name" id="name"
                                class="border-2 border-cyan-600 bg-cyan-100 py-1 text-center mt-4 rounded-md shadow-md"
                                placeholder="nama kelas">
                            <button
                                class=" px-4 py-1 mt-2 rounded-md shadow-md bg-black text-white hover:bg-gray-800 transition-all"
                                type="submit">Buat</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
