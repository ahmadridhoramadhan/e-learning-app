<!DOCTYPE html>
<html lang="en">
{{-- jika session tidak sama dengan nama room maka hapus --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <title>{{ $title }} | {{ config('app.name') }}</title>



</head>

<body class="flex flex-col min-h-screen" x-data="{
    isNavOpen: false,
    currentIndex: 0,
    questions: JSON.parse(sessionStorage.getItem('{{ $title }}')) || {{ $questions }},
    storeSession: function() { sessionStorage.setItem('{{ $title }}', JSON.stringify(this.questions)) }
}">
    <header x-effect="currentIndex; storeSession();">
        <div class="px-3 py-4 flex justify-between">
            <button @click="isNavOpen=true" class="w-7 h-7 lg:hidden"><x-icons.burger /></button>
            <div class="hidden lg:block"></div>
            <div class=" text-xl" id="countdown"></div>
            <div></div>
        </div>
        <div class="fixed z-50 bottom-0 flex flex-col gap-5 top-0 left-0 w-[90%] sm:max-w-md border-r border-black bg-white"
            x-show="isNavOpen">
            <div class="flex justify-between py-3 px-2 items-center">
                <button type="button" @click="isNavOpen=false" class="w-7 h-7"><x-icons.close /></button>
                <div>
                    <h1 class="text-3xl">{{ $title }}</h1>
                    <span class="text-sm">nama pemilik</span>
                </div>
            </div>

            {{-- container navigarion card question --}}
            <div class="grid grid-cols-5 auto-rows-max gap-2 px-4 flex-auto overflow-y-scroll">
                <template x-for="(question, i) in questions">
                    <div @click="currentIndex = i"
                        class="aspect-square flex items-center justify-center border-indigo-700 border-2 text-2xl"
                        :class="(question.selected != null && ' bg-indigo-100 ') +
                        (currentIndex == i && ' bg-indigo-400 text-white ') +
                        (question.flag && ' bg-red-100 border-red-700 !text-black ')"
                        x-text="i + 1">
                        1</div>
                </template>
            </div>

            {{-- submit --}}
            <button type="button" class="py-3 bg-cyan-100 border-cyan-700 border-2 rounded mx-4 mb-5"
                @click="submit()">Submit</button>
        </div>
    </header>

    <div class="flex gap-5 flex-auto">
        <div
            class="relative z-50 bottom-0 lg:flex flex-col gap-5 top-0 left-0 w-[90%] sm:max-w-md border-r border-black bg-white hidden">
            <div class="flex justify-between py-3 px-2 items-center">
                <div></div>
                <div>
                    <h1 class="text-3xl">{{ $title }}</h1>
                    <span class="text-sm">nama pemilik</span>
                </div>
            </div>

            {{-- container navigarion card question --}}
            <div class="grid grid-cols-5 auto-rows-max gap-2 px-4 flex-auto overflow-y-scroll">
                <template x-for="(question, i) in questions">
                    <div @click="currentIndex = i"
                        class="aspect-square flex items-center justify-center border-indigo-700 border-2 text-2xl"
                        :class="(question.selected != null && ' bg-indigo-100 ') +
                        (currentIndex == i && ' bg-indigo-400 text-white ') +
                        (question.flag && ' bg-red-100 border-red-700 !text-black ')"
                        x-text="i + 1">
                        1</div>
                </template>
            </div>

            {{-- submit --}}
            <button type="button" class="py-3 bg-cyan-100 border-cyan-700 border-2 rounded mx-4 mb-5"
                @click="submit()">Submit</button>
        </div>


        <div class="flex-auto flex flex-col justify-between">
            <main class="flex-auto mx-3">{{ $slot }}</main>

            <section class="grid grid-cols-3 justify-items-center px-5 py-8 bg-white">
                {{-- button prev --}}
                <button type="button" :disabled="currentIndex == 0" :class="currentIndex == 0 && 'opacity-50'"
                    class="rounded-full w-10 h-10 p-1 rotate-90 border-2 border-cyan-700 bg-cyan-100 text-cyan-800 justify-self-start"
                    @click="currentIndex-- "><x-icons.chevron /></button>

                {{-- button flag --}}
                <button type="button" class="rounded-2xl w-10 h-10 pl-1 py-1 border-2 border-red-700 text-red-800 "
                    :class="questions[currentIndex].flag && 'bg-red-100'"
                    @click="questions[currentIndex].flag = !questions[currentIndex].flag"><x-icons.flag /></button>

                {{-- button next --}}
                <button type="button" x-show="currentIndex < questions.length - 1"
                    class="rounded-full w-10 h-10 p-1 -rotate-90 border-2 border-cyan-700 bg-cyan-100 text-cyan-800 justify-self-end"
                    @click="currentIndex++"><x-icons.chevron /></button>

                {{-- button submit --}}
                <button type="button" x-show="currentIndex == questions.length - 1"
                    class="rounded-full p-1 px-2 border-2 border-cyan-700 bg-cyan-100 text-cyan-800 justify-self-end"
                    @click="submit()">submit?</button>

            </section>
        </div>
    </div>


    {{-- <x-alert.outwhileworking /> --}}

    <form action="{{ route('user.room.submit', $roomId) }}" method="POST" class="hidden" id="submitForm">
        @csrf
        <input type="hidden" name="data" value="" id="data">
    </form>

    <script>
        let maxTime = 0;

        function saveProgress() {
            var formdata = new FormData();

            let data = sessionStorage.getItem("{{ $title }}") || JSON.stringify({!! html_entity_decode($questions) !!});
            formdata.append("data", (data));
            formdata.append("maxTime", maxTime);

            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };

            fetch("{{ route('user.rooms.save', [auth()->user()->id, $roomId]) }}", requestOptions)
                .then(response => response.text())
                .then(result => console.log(result))
                .catch(error => console.log('error', error));
        }

        function submitWithoutConfirm() {
            let questions = JSON.parse(sessionStorage.getItem("{{ $title }}"));

            sessionStorage.clear();

            let data = [];
            questions.forEach((question, index) => {
                data.push({
                    question_id: question.id,
                    answer_id: question.selected
                });
            });
            document.getElementById('data').value = JSON.stringify(data);
            document.getElementById('submitForm').submit();
        }

        function submit() {
            let questions = JSON.parse(sessionStorage.getItem("{{ $title }}"));
            // hapus session questions
            sessionStorage.clear();

            let notAnswered = false;

            let data = [];
            questions.forEach((question, index) => {
                if (question.selected == null) {
                    alert(`Soal ke-${index + 1} belum dijawab`);
                    notAnswered = true;
                }
                data.push({
                    question_id: question.id,
                    answer_id: question.selected
                });
            });

            if (notAnswered) return;
            document.getElementById('data').value = JSON.stringify(data);
            document.getElementById('submitForm').submit();
        }

        function startCountdown(minutes) {
            let endTime = Date.now() + minutes * 1000; // waktu akhir dalam milidetik
            let countdownElement = document.getElementById('countdown'); // elemen untuk menampilkan countdown

            let countdownInterval = setInterval(() => {
                let now = Date.now();
                let distance = endTime - now; // jarak antara waktu sekarang dan waktu akhir

                // hitung menit dan detik yang tersisa
                let minutes = Math.floor(distance / (60 * 1000));
                let seconds = Math.floor((distance % (60 * 1000)) / 1000);

                // tampilkan hasilnya di elemen countdown
                countdownElement.innerText = minutes + "m " + seconds + "s ";

                maxTime = minutes;
                sessionStorage.setItem("maxTime", (minutes * 60) + seconds);

                // jika countdown selesai, hentikan interval
                if (distance < 0) {
                    clearInterval(countdownInterval);
                    countdownElement.innerText = "Waktu anda habis!";
                    submitWithoutConfirm();
                }
            }, 1000); // update setiap detik
        }


        if ({!! $maxTime == '' ? 'false' : $maxTime !!} > 0 || false) {
            startCountdown((sessionStorage.getItem("maxTime") || {{ $maxTime == '' ? 0 : $maxTime }} * 60));
        }



        // save progress every 2.30 minutes
        setTimeout(() => {
            saveProgress()
        }, 2000);
        setInterval(saveProgress, 150000);
    </script>
</body>

</html>
