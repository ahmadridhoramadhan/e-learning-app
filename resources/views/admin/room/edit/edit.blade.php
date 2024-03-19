<x-editor-layout :title="$room->name" :questions="$room->questions" :roomId="$room->id" :room="$room">

    <div class="absolute top-2 left-0 right-0" id="alert">

    </div>

    <div class="flex flex-col justify-between" x-data="{ openEditor: false }">
        <div class="flex flex-col gap-3">
            {{-- question --}}
            <div>
                <div class="border border-indigo-800 dark:border-indigo-500 rounded-md shadow-md w-fit py-1 px-5 text-xl mb-1"
                    x-text="currentIndex +1"></div>
                <div class="question editor border-indigo-500 border rounded shadow-md p-2 min-h-48 resize-y overflow-auto break-all"
                    @click="renderSummernote($event.target)" x-html="questions[currentIndex].question">
                </div>
            </div>


            {{-- correct answers --}}
            <div class="answer editor border-black border rounded-lg shadow-md p-2 pl-3 min-h-10 bg-cyan-100 dark:bg-cyan-800 dark:border-cyan-500"
                @click="renderSummernote($event.target)" x-html="questions[currentIndex].answers[0]">
            </div>
            {{-- wrong answers / another answer --}}
            <template class="flex flex-col gap-3" x-for="(answer, index) in questions[currentIndex].answers">
                <template x-if="index > 0"> {{-- tidak menampilkan yang pertama --}}
                    <div class="relative">
                        <div class="answer editor border-black border rounded-lg shadow-md p-2 pl-3 min-h-10 dark:border-white"
                            @click="renderSummernote($event.target)" x-html="answer">
                        </div>

                        <div class="rotate-45 text-red-500 absolute top-px right-px w-8 aspect-square"
                            @click="$event.target.closest('.relative').remove()">
                            <x-icons.plus />
                        </div>
                    </div>
                </template>
            </template>

            {{-- container add answer --}}
            <div id="container-answers" class="flex gap-3 flex-col"
                x-effect="currentIndex;
                    let container = document.getElementById('container-answers');
                    container.innerHTML = '';
                    ">
                {{-- menghapus setiap kali currentIndex berubah --}}
            </div>

            {{-- add answer --}}
            <button type="button" @click="addAnswer()" id="add-answer"
                class="rounded-xl shadow-md flex h-10 w-20 p-2 border border-black dark:border-white">
                <x-icons.plus />
            </button>
        </div>
    </div>
</x-editor-layout>
