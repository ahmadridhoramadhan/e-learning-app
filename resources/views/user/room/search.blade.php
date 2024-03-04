<x-app-layout :title="'cari room'">
    <div class="flex flex-col gap-5">
        {{-- card close --}}
        @foreach ($teachers as $teacher)
            <x-cards.roomsteacherlist :teacher="$teacher" />
        @endforeach

    </div>
</x-app-layout>
