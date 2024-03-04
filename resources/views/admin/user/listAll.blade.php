<x-app-layout :title="'List Siswa'">
    <div class="mt-5 flex justify-between items-center"" x-init>
        <form action="{{ route('admin.class.edit.process') }}" id="formEditClass" method="post"
            onsubmit="return confirm('Apakah Anda yakin ingin mengganti nama kelas?')">
            @csrf
            <input type="text" name="name" id="name" value="{{ $class->name }}"
                onblur="
                    if(confirm('Apakah Anda yakin ingin mengganti nama kelas?')) {
                        document.getElementById('formEditClass').submit()
                    }
                "
                class="text-3xl font-semibold w-full focus:border-b-2 border-black outline-none">
        </form>

        <x-button.adduser />
    </div>

    <div class="flex flex-col gap-4 mt-8">
        @forelse ($students as $student)
            <x-cards.user :$student />
        @empty
            <div class="text-xl min-h-[70vh] flex items-center justify-center font-bold text-gray-500">
                Tidak ada siswa </div>
        @endforelse
    </div>
</x-app-layout>
