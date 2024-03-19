<x-app-layout :title="'Histories'">

    <ol class="relative border-s border-gray-200 dark:border-gray-700">
        @foreach ($assessmentHistoriesGroups as $assessmentHistories)
            <li class="mb-10 ms-6">
                <span
                    class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                    <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </span>
                <time class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $dates[$loop->index] }}
                </time>
                <div
                    class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400 grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-5 place-items-center container">
                    @foreach ($assessmentHistories as $assessmentHistory)
                        <a href="{{ route('user.room.detail', [$assessmentHistory->room->id, $assessmentHistory->id]) }}"
                            class="border-2 relative flex flex-col items-center w-full aspect-square border-indigo-700 dark:hover:bg-indigo-950 bg-indigo-100 dark:bg-transparent rounded-md shadow-md max-w-48">
                            <div
                                class="flex-auto flex items-center font-bold lg:text-5xl text-3xl sm:text-4xl dark:text-white pb-2">
                                {{ $assessmentHistory->score }}
                            </div>
                            <div
                                class="p-2 line-clamp-2 break-words font-semibold absolute bottom-0 left-0 right-0 text-center text-sm">
                                {{ $assessmentHistory->room->name }}</div>
                        </a>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ol>


</x-app-layout>
