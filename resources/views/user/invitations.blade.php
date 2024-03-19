<x-app-layout :title="'Invitations'">
    <div class="container mx-auto" x-init>
        <div class="flex flex-col gap-5">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">Undangan</h1>
            </div>
            @forelse ($invitations as $invitation)
                <div class="flex items-center gap-3 dark:bg-slate-800 py-4 px-3 rounded-md shadow dark:shadow-slate-600 "
                    :class="'{{ $invitation->status }}' == 'done' && ' opacity-50'">
                    <div class="flex-auto">
                        <div class="sm:flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="size-8">
                                    @if ($invitation->fromUser->profile_picture_url)
                                        <img src="{{ $invitation->fromUser->profile_picture_url }}"
                                            class="rounded-full shadow dark:shadow-slate-500" alt="">
                                    @else
                                        <x-icons.person />
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-xl">{{ $invitation->room->name }}</h3>
                                    <div class="text-gray-700 dark:text-gray-400 text-sm -mt-1 ml-1">
                                        {{ $invitation->fromUser->name }}</div>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('user.room.detail', $invitation->room->id) }}"
                                    class="focus:outline-none inline-block mt-3 w-full text-center text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Kerjakan</a>
                            </div>
                        </div>
                        <div class="dark:bg-slate-700 rounded-md px-3 py-4 mt-3">
                            <p>{{ $invitation->message }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-xl dark:text-gray-400 text-gray-700">Belum Ada Undangan</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
