<x-app-layout :title="$room->name">
    @if (session('error'))
        <x-alerts.warning :message="session('error')" />
    @endif
    @if (session('success'))
        <x-alerts.success :message="session('success')" />
    @endif

    {{-- TODO: skip password jika room tidak memerlukan password --}}
    {{-- FIXME: jika submit tapi ada soal yang belum di jawab entah kenapa akan muncul alert --}}

    {{-- profile owner --}}
    <section class="dark:bg-slate-800 shadow dark:shadow-slate-600 py-4 bg-slate-100">
        <div>
            <p class="text-center text-xs dark:text-gray-400 text-gray-500">Dibuat pada
                {{ $room->created_at->format('d F Y') }}</p>
        </div>
        <div class="md:flex justify-between items-center">
            <div class="flex items-center gap-2 ml-6">
                <div class="size-10 shrink-0 grow-0">
                    @if ($room->user->profile_picture_url)
                        <img src="{{ $room->user->profile_picture_url }}" alt="profile"
                            class="w-full h-full rounded-full bg-black">
                    @else
                        <x-icons.person />
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-3xl">{{ $room->name }}</p>
                    <p class="text-xs text-gray-500 -mt-1 dark:text-gray-400">{{ $room->user->name }}</p>
                </div>
            </div>
            @if ($settings['average_score'])
                <div
                    class="bg-white dark:bg-slate-900 px-3 py-2 rounded shadow dark:shadow-slate-600 mt-2 md:mt-0 mx-3 text-center">
                    <span class="text-gray-700 dark:text-gray-400">nilai rata rata</span> <br> <span
                        class="text-xl underline underline-offset-2">{{ $averageScore }}</span>
                </div>
            @endif
        </div>
    </section>

    <div class="flex my-10 flex-col lg:flex-row">
        @if ($settings['leader_board'])
            {{-- leaderboard --}}
            <section id="leaderboard"
                class="py-4 pb-6 flex flex-col gap-3 border-b border-black lg:order-2 relative basis-3/5 dark:border-white dark:bg-slate-800 shadow rounded-md dark:shadow-slate-600 bg-slate-100 px-2">
                <h4
                    class="text-xl ml-3 bg-white dark:bg-slate-900 w-fit px-3 py-2 rounded-md shadow dark:shadow-slate-700">
                    Papan Peringkat</h4>
                <div class="divide-y dark:divide-gray-400 divide-gray-700">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="w-full px-3 py-3 flex justify-between">
                            <div class="flex items-center overflow-auto">
                                <span
                                    class="sm:text-2xl text-xl justify-center flex sm:w-8 w-3 flex-shrink-0">{{ $i }}.</span>
                                <div class="sm:size-8 size-6 sm:mr-3 mr-1 sm:ml-4 ml-2 flex-shrink-0">
                                    @if ($leaderBoard[$i - 1]->user->profile_picture_url ?? null)
                                        <img src="{{ $leaderBoard[$i - 1]->user->profile_picture_url }}"
                                            class="w-full h-full rounded-full bg-black flex-shrink-0" alt="">
                                    @else
                                        <x-icons.person />
                                    @endif
                                </div>
                                <h5 class="truncate sm:text-base text-sm">
                                    {{ $leaderBoard[$i - 1]->user->name ?? '????' }}
                                </h5>
                            </div>
                            <span
                                class="sm:text-3xl text-2xl font-semibold dark:text-indigo-400 text-indigo-700">{{ $leaderBoard[$i - 1]->score ?? '' }}</span>
                        </div>
                    @endfor
                </div>

                @if ($settings['list_score_user'])
                    <a href="{{ route('user.room.leaderBoard', $room->id) }}"
                        class="flex absolute bottom-3 right-2 hover:right-0 transition-all dark:hover:text-indigo-300 hover:text-indigo-700"
                        type="button">
                        selengkapnya
                        <div class="size-6 -rotate-90">
                            <x-icons.chevron />
                        </div>
                    </a>
                @endif
            </section>
        @endif
        <div class="lg:mx-3 flex-auto flex flex-col justify-between mt-10 lg:mt-0">
            @if ($settings['show_result'])
                {{-- statistic --}}
                <section class="my-auto sm:px-5 px-2">
                    <div
                        class=" border-2 flex-auto border-indigo-700 bg-indigo-100 flex justify-center flex-col items-center text-indigo-700 relative py-5 mb-2">
                        <span class="pt-1 absolute top-0 left-0 right-0 text-center">nilai</span>
                        <div
                            class="flex-auto text-7xl py-5 font-semibold w-full h-full flex justify-center items-center">
                            {{ $assessmentHistory->score ?? ' ? ' }}</div>
                    </div>
                    <div class="flex gap-2">

                        <div
                            class="border-2 border-green-700 text-green-700 relative bg-green-100 flex-auto py-5 dark:text-green-300 dark:border-green-300 dark:bg-slate-900">
                            <div class="pt-2 pb-1 text-3xl flex justify-center items-center">
                                {{ $assessmentHistory->right_answer ?? ' ? ' }}</div> <span
                                class="pb-1 absolute bottom-0 left-0 right-0 text-center">Benar</span>
                        </div>
                        <div
                            class="border-2 border-red-700 text-red-700 bg-red-100 relative flex-auto py-5 dark:bg-slate-900 dark:text-red-300 dark:border-red-400">
                            <div class="pt-2 pb-1 text-3xl flex justify-center items-center">
                                {{ $assessmentHistory->wrong_answer ?? ' ? ' }}</div> <span
                                class="pb-1 absolute bottom-0 left-0 right-0 text-center">Salah</span>
                        </div>
                    </div>
                </section>
            @endif

            {{-- button --}}
            <section class="mt-2" x-init>
                <dialog id="insertPassword" class="max-w-md w-full rounded-md shadow-md dark:bg-slate-900"
                    @click="insertPassword.close()"">
                    <div class="w-full h-full" @click="$event.stopPropagation()">
                        <div
                            class="border-b dark:border-gray-400 py-4 px-4 flex justify-between items-center dark:text-white">
                            <h4 class="text-xl font-semibold">Masukkan Password</h4>
                            <button type="button" class="size-7"
                                @click="insertPassword.close()"><x-icons.close /></button>
                        </div>
                        <div class="pb-4 pt-2 px-2">
                            <form action="{{ route('user.room.join.process', $room->id) }}" method="post">
                                @csrf
                                <div class="flex flex-col gap-5 p-5">
                                    @if ($room->password != '')
                                        <x-inputs.text id="password" name="password" required :label="'Password'"
                                            :value="''" :error="$errors->first('password')" />
                                    @else
                                        <p class="dark:text-white text-center">Apakah Anda Yakin Ingin Mengerjakan</p>
                                    @endif
                                    <button type="submit"
                                        class="w-full border-2 border-cyan-600 text-cyan-700 bg-cyan-100 py-4 rounded-md shadow-md">Kerjakan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </dialog>
                @if ($room->is_active)
                    {{-- button --}}
                    <button type="button" @click="insertPassword.showModal(); sessionStorage.clear();"
                        class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-xl px-5 py-3 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900 w-full">Kerjakan</button>
                @else
                    <p
                        class="w-full border-2 border-red-600 text-center text-red-700 bg-red-100 py-4 rounded-md shadow-md">
                        Room
                        Di Tutup
                    </p>
                @endif
            </section>
        </div>

    </div>

    @if ($settings['answer_history'])
        {{-- list question wrong --}}
        @if ($wrongAnswers->count() > 0)
            <section class=" p-2 dark:bg-slate-800 rounded shadow bg-slate-100 dark:shadow-slate-600 mb-5">
                <div
                    class="flex justify-between text-red-700 dark:text-red-400 text-2xl items-center border-b dark:border-gray-500">
                    <span>Soal Salah</span>
                </div>

                {{-- question container --}}
                <div class="px-2 mt-5">
                    @foreach ($wrongAnswers as $wrongAnswer)
                        <x-cards.question-history :question="$wrongAnswer" />
                    @endforeach
                </div>
            </section>
        @endif

        {{-- list question correct --}}
        @if ($correctAnswers->count() > 0)
            <section
                class="p-2 rounded shadow dark:shadow-slate-600 dark:bg-slate-800 bg-slate-100 mb-10 dark:hover:bg-slate-700 hover:bg-slate-200 transition-colors">
                <div class="flex justify-between text-green-700 text-2xl items-center border-b dark:border-gray-400">
                    <span>Soal Benar</span>
                </div>

                {{-- question container --}}
                <div class="px-2 mt-5">
                    {{-- question card --}}
                    @foreach ($correctAnswers as $correctAnswer)
                        <x-cards.question-history :question="$correctAnswer" />
                    @endforeach
                </div>
            </section>
        @endif
    @endif
</x-app-layout>
