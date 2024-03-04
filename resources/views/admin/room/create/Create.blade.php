<x-app-layout :title="'Room Baru'">
    <form action="{{ route('admin.rooms.create.process') }}" method="post" class="pb-3 flex flex-col justify-between">
        @csrf
        <div>
            <h1 class="text-center text-2xl my-5">Buat Room Baru</h1>

            {{-- form settings --}}
            <x-inputs.formsettingsroom />

        </div>

        <div class="flex flex-col gap-3 justify-center items-center text-xl">
            <button type="submit"
                class="border border-black py-3 w-full rounded-md text-center bg-cyan-200 hover:bg-cyan-400 transition-all">Buat</button>
            <a href="{{ route('admin.dashboard') }}"
                class="border py-3 w-full rounded-md text-center border-red-600 hover:bg-red-200 transition-all font-semibold text-red-800">Batal</a>
        </div>

    </form>
</x-app-layout>
