<x-editor-layout :title="$room->name" :questions="$room->questions" :roomId="$room->id" :room="$room">
    <form action="{{ route('admin.rooms.settings.process', $room->id) }}" method="POST">
        @csrf
        <x-inputs.form-settings-room :$room />
        <div class="flex flex-col gap-2">
            <a href="{{ route('admin.rooms.edit', $room->id) }}"
                class="w-full border border-indigo-600 text-center py-3 rounded-md shadow-md text-indigo-500">kembali</a>
            <button type="submit"
                class="block text-center py-3 bg-cyan-300 border border-black rounded shadow-md">Simpan</button>
        </div>
    </form>
</x-editor-layout>
