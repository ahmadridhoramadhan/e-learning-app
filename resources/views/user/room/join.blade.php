<x-join-room-layout :title="$room->name" :$room :questions="$questions" :roomId="$room->id" :$maxTime>
    <div
        class="border dark:border-slate-800 p-2 shadow-md bg-slate-50 dark:bg-slate-800 rounded dark:shadow-slate-600 min-h-52 text-lg select-none">
        <span class="text-2xl text-indigo-700" x-text="currentIndex + 1 + '.'"></span>
        <div class="inline-block break-words" x-html="questions[currentIndex].question"></div>
    </div>
    <div id="container-answer" class="flex flex-col gap-4 mt-8 select-none">
        <template x-for="answer in questions[currentIndex].answers" :key="answer.id">
            <label class="w-full relative">
                <input type="radio" name="answer" class="peer z-10 h-full w-full cursor-pointer hidden"
                    :value="answer.id" @click="questions[currentIndex].selected = answer.id"
                    :checked="questions[currentIndex].selected == answer.id" />
                <div class="w-full py-2 shadow dark:shadow-slate-600 dark:bg-slate-800 dark:border-slate-700 rounded bg-slate-100 border px-2 transition-all peer-checked:border-2 peer-checked:bg-cyan-100 peer-checked:border-cyan-700 peer-checked:text-cyan-800"
                    x-html="answer.answer"></div>
            </label>
        </template>
    </div>
</x-join-room-layout>
