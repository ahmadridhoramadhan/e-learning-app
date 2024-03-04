<x-editor-layout :title="$room->name" :questions="$room->questions">


    {{-- alert success --}}
    {{-- <div class="success">
        <div class="success__icon">
            <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                    d="m12 1c-6.075 0-11 4.925-11 11s4.925 11 11 11 11-4.925 11-11-4.925-11-11-11zm4.768 9.14c.0878-.1004.1546-.21726.1966-.34383.0419-.12657.0581-.26026.0477-.39319-.0105-.13293-.0475-.26242-.1087-.38085-.0613-.11844-.1456-.22342-.2481-.30879-.1024-.08536-.2209-.14938-.3484-.18828s-.2616-.0519-.3942-.03823c-.1327.01366-.2612.05372-.3782.1178-.1169.06409-.2198.15091-.3027.25537l-4.3 5.159-2.225-2.226c-.1886-.1822-.4412-.283-.7034-.2807s-.51301.1075-.69842.2929-.29058.4362-.29285.6984c-.00228.2622.09851.5148.28067.7034l3 3c.0983.0982.2159.1748.3454.2251.1295.0502.2681.0729.4069.0665.1387-.0063.2747-.0414.3991-.1032.1244-.0617.2347-.1487.3236-.2554z"
                    fill="#393a37" fill-rule="evenodd"></path>
            </svg>
        </div>
        <div class="success__title">lorem ipsum dolor sit amet</div>
        <div class="success__close"><svg height="20" viewBox="0 0 20 20" width="20"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"
                    fill="#393a37"></path>
            </svg></div>
    </div> --}}

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
