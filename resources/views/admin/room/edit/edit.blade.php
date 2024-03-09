<x-editor-layout :title="$room->name" :questions="$room->questions">

    <x-alert.success :title="'hai'" :message="'cuma ngetes'" />

    <div class="flex flex-col justify-between min-h-[93vh]" x-data="{ openEditor: false }">
        <div class="flex flex-col gap-3">

            {{-- question --}}
            <div>
                <div class="border border-black rounded-md shadow-md w-fit py-1 px-5 text-xl mb-1"
                    x-text="currentIndex +1"></div>
                <div class="question editor border-indigo-500 border rounded shadow-md p-2 min-h-48 resize-y overflow-auto break-all"
                    @click="renderSummernote($event.target)" x-html="questions[currentIndex].question">
                </div>
            </div>


            {{-- correct answers --}}
            <div class="answer editor border-black border rounded-lg shadow-md p-2 pl-3 min-h-10 bg-cyan-100"
                @click="renderSummernote($event.target)" x-html="questions[currentIndex].answers[0]">
            </div>
            {{-- wrong answers / another answer --}}
            <template class="flex flex-col gap-3" x-for="(answer, index) in questions[currentIndex].answers">
                <template x-if="index > 0"> {{-- tidak menampilkan yang pertama --}}
                    <div class="relative">
                        <div class="answer editor border-black border rounded-lg shadow-md p-2 pl-3 min-h-10"
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
                class="rounded-xl shadow-md flex h-10 w-20 p-2 border border-black">
                <x-icons.plus />
            </button>
        </div>

        <div>
            <div class="flex justify-between my-6 items-center">
                {{-- prev --}}
                <button type="button" @click="save(currentIndex); getSession(); currentIndex--; "
                    :disabled="currentIndex <= 0" :class="(currentIndex <= 0 ? ' opacity-20' : '')"
                    class="'w-10 h-10 rotate-90 flex justify-center items-center rounded-full border border-gray-700">
                    <x-icons.chevron />
                </button>

                {{-- trash --}}
                <button type="button" class="border-red-500 border w-11 h-11  rounded-md shadow-md p-2 text-red-700"
                    @click="questions.splice(currentIndex, 1);
                    if(currentIndex >= questions.length){currentIndex--};
                    storeSession();">
                    <x-icons.trash />
                </button>

                {{-- add question --}}
                <button type="button" class="p-1 border w-10 h-10 border-black rounded-full shadow-md bg-cyan-300"
                    @click="save(currentIndex); getSession(); addQuestion();">
                    <x-icons.plus />
                </button>

                {{-- next --}}
                <button type="button" @click="save(currentIndex); getSession(); currentIndex++;"
                    x-show="currentIndex <= questions.length - 2"
                    class="w-10 h-10 -rotate-90 flex justify-center items-center rounded-full border border-gray-700">
                    <x-icons.chevron />
                </button>
            </div>

        </div>
    </div>
</x-editor-layout>
