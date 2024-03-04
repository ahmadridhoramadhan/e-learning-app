<x-app-layout :title="$room->name">
    {{-- profile owner --}}
    <section>
        <div class="flex items-center gap-2 ml-6">
            <div class="w-10 h-10">
                <img src="" alt="profile" class="w-full h-full rounded-full bg-black">
            </div>
            <div>
                <p class="font-semibold text-3xl">{{ $room->name }}</p>
                <p class="text-xs text-gray-500 -mt-2">{{ $room->user->name }}</p>
            </div>
        </div>
    </section>

    <div class="flex my-10 flex-col lg:flex-row">
        @if ($settings['leader_board'])
            {{-- leaderboard --}}
            <section id="leaderboard"
                class="py-4 flex flex-col gap-3 border-b border-black relative basis-3/5 lg:order-2">

                @foreach ($leaderBoard as $siswa)
                    <x-cards.leaderBoard :number="$loop->iteration" :name="$siswa->user->name" :score="$siswa->score" />
                @endforeach

                <a href="{{ route('user.room.leaderBoard', $room->id) }}"
                    class="inline-block absolute bottom-2 right-1 w-5 -rotate-90 aspect-square" type="button">
                    <x-icons.chevron />
                </a>
            </section>
        @endif

        @if ($settings['show_result'])
            {{-- statistic --}}
            <section class="flex gap-2 px-2 my-8 flex-auto mx-14 lg:order-1">
                <div
                    class="basis-2/5 border-2 border-indigo-700 bg-indigo-100 flex justify-center flex-col items-center text-indigo-700">
                    <span class="pt-1">nilai</span>
                    <div class="flex-auto text-7xl py-5 font-semibold">{{ $assessmentHistory->score ?? ' ? ' }}</div>
                </div>
                <div class="flex justify-between flex-col flex-auto gap-2">
                    <div class="bg-slate-300 flex-auto flex items-center">nilai rata rata : {{ $averageScoreRoom }}
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="border-2 border-green-700 text-green-700 bg-green-100 flex flex-col items-center justify-center flex-auto">
                            <div class="pt-2 pb-1 text-3xl">{{ $assessmentHistory->right_answer ?? ' ? ' }}</div> <span
                                class="pb-1">Benar</span>
                        </div>
                        <div
                            class="border-2 border-red-700 text-red-700 bg-red-100 flex flex-col items-center justify-center flex-auto">
                            <div class="pt-2 pb-1 text-3xl">{{ $assessmentHistory->wrong_answer ?? ' ? ' }}</div> <span
                                class="pb-1">Salah</span>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <section class="mb-10" x-init>
        <dialog id="insertPassword" class="max-w-md w-full border rounded-md shadow-md pb-5 pt-2 px-2 md:px-4">
            <div class="relative">
                <button type="button" class="w-6 h-6 top-2 right-3 absolute"
                    @click="insertPassword.close()"><x-icons.close /></button>
                <form action="{{ route('user.room.join.process', $room->id) }}" method="post">
                    @csrf
                    <div class="flex flex-col gap-5 p-5">
                        <label for="password" class="text-lg">Masukkan password</label>
                        <x-inputs.text2 id="password" name="password" type="password" required :label="'Password'"
                            :value="''" :error="$errors->first('password')" />
                        <button type="submit"
                            class="w-full border-2 border-cyan-600 text-cyan-700 bg-cyan-100 py-4 rounded-md shadow-md">Kerjakan</button>
                    </div>
                </form>
            </div>
        </dialog>

        @if ($room->is_active)
            {{-- button --}}
            <button type="button" @click="insertPassword.showModal()"
                class="w-full border-2 border-cyan-600 text-cyan-700 bg-cyan-100 py-4 rounded-md shadow-md">Kerjakan</button>
        @else
            <p class="w-full border-2 border-red-600 text-center text-red-700 bg-red-100 py-4 rounded-md shadow-md">Room
                Di Tutup
            </p>
        @endif
    </section>

    @if ($settings['answer_history'])
        {{-- list question wrong --}}
        @if ($wrongAnswers->count() > 0)
            <section class="border-2 border-red-700 p-2 rounded shadow-md mb-5" x-data="{ isWrongShow: false }">
                <div class="flex justify-between text-red-700 text-2xl items-center"
                    @click="isWrongShow = !isWrongShow">
                    <span>Salah</span>
                    <button type="button" class="w-7 h-7 mr-3"><x-icons.chevron /></button>
                </div>

                {{-- question container --}}
                <div class="px-2 mt-5" x-show="isWrongShow" x-transition>
                    @foreach ($wrongAnswers as $wrongAnswer)
                        <x-cards.reviewquestion :question="$wrongAnswer" />
                    @endforeach
                </div>
            </section>
        @endif

        {{-- list question correct --}}
        @if ($correctAnswers->count() > 0)
            <section class="border-2 border-green-700 p-2 rounded shadow-md mb-10" x-data="{ isCorrectShow: false }">
                <div class="flex justify-between text-green-700 text-2xl items-center"
                    @click="isCorrectShow = !isCorrectShow">
                    <span>Benar</span>
                    <button type="button" class="w-7 h-7 mr-3"><x-icons.chevron /></button>
                </div>

                {{-- question container --}}
                <div class="px-2 mt-5" x-show="isCorrectShow" x-transition>
                    {{-- question card --}}
                    @foreach ($correctAnswers as $correctAnswer)
                        <x-cards.reviewquestion :question="$correctAnswer" />
                    @endforeach
                </div>
            </section>
        @endif
    @endif
</x-app-layout>
