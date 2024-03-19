<x-app-layout :title="'invite'">
    <div class="my-8 bg-slate-100 shadow dark:shadow-slate-600 dark:bg-slate-800 rounded p-2">
        <div class="dark:bg-slate-900 p-4 w-fit rounded shadow dark:shadow-slate-600 mb-10">
            Undangan Kelas Untuk mengerjakan <span
                class="text-indigo-700 dark:text-indigo-400 font-semibold text-xl">{{ $room->name }}</span>
        </div>
        <div class="mb-5">
            <span class="inline-block mb-2 ml-1">Kepada Kelas</span>
            <section class="dark:bg-slate-900 shadow dark:shadow-slate-600 py-3 bg-slate-100 rounded ">
                <div class="flex items-center gap-2 ml-6">
                    <div class="size-10">
                        @if ($room->user->profile_picture_url)
                            <img src="{{ $room->user->profile_picture_url }}" alt="profile"
                                class="w-full h-full rounded-full bg-black">
                        @else
                            <x-icons.person />
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-3xl">{{ $classroom->name }}</p>
                        <p class="text-xs text-gray-500 -mt-1 dark:text-gray-400">{{ $room->user->name }}</p>
                    </div>
                </div>
            </section>
        </div>

        <form action="{{ route('admin.invite.classroom.process', [$room->id, $classroom->id]) }}" method="POST">
            @csrf
            <div class="mb-5">
                <span class="inline-block mb-2 ml-1">message</span>
                <textarea name="message" id="" class="w-full dark:bg-slate-900 bg-white" rows="10"></textarea>
            </div>

            <div>
                <button type="submit"
                    class="bg-indigo-700 dark:bg-indigo-600 text-white dark:text-gray-200 px-5 py-2.5 rounded-lg font-medium focus:outline-none focus:ring-4 focus:ring-indigo-300">Kirim</button>
            </div>
        </form>

    </div>
</x-app-layout>
