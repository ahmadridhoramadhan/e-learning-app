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

<body class="flex flex-col min-h-screen dark:bg-slate-900 dark:text-white" x-data="{
    currentIndex: 0,
    questions: JSON.parse(sessionStorage.getItem('{{ $title }}')) || {{ $questions }},
    storeSession: function() { sessionStorage.setItem('{{ $title }}', JSON.stringify(this.questions)) }
}"
    x-effect="currentIndex; storeSession();">

    <nav class="fixed top-0 z-50 w-full bg-gray-100 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('user.dashboard') }}" class="flex ms-2 md:me-24">
                        {{-- <img src="#/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" /> --}}
                        <span
                            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">ISA</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="flex items-center ms-3">
                        {{-- profile picture --}}
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                @if (Auth::user()->profile_picture_url == null)
                                    <div class="size-8">
                                        <x-icons.person />
                                    </div>
                                @else
                                    <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_picture_url }}"
                                        alt="user photo">
                                @endif
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('user.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Settings</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-gray-100 dark:text-red-300 dark:hover:bg-gray-600 dark:hover:text-red-400"
                                        role="menuitem">
                                        Sign out
                                        <div class="ml-2 size-4 inline-block">
                                            <x-icons.logout />
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 flex flex-col gap-4 justify-between md:w-full max-w-xs lg:max-w-sm w-64 h-screen pt-20 transition-transform -translate-x-full bg-gray-100 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="px-3 pb-4 bg-gray-100 dark:bg-gray-800 ">
            <a href="{{ route('user.room.detail', $roomId) }}"
                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:bg-slate-900 shadow dark:shadow-slate-600 bg-white dark:hover:bg-slate-700 group {{ Route::is('user.dashboard') ? 'dark:bg-slate-900 ' : '' }}">
                <div class="flex flex-auto items-center">
                    <div class="size-8">
                        @if ($room->user->profile_picture_url == null)
                            <x-icons.person />
                        @else
                            <img src="{{ $room->user->profile_picture_url }}"
                                class="rounded-full shadow dark:shadow-slate-600" alt="">
                        @endif
                    </div>
                    <div class="flex-auto ms-3">
                        <span class="text-xl">{{ $title }}</span><br>
                        <span
                            class="dark:text-gray-400 text-gray-700 text-xs -mt-1 block">{{ $room->user->name }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="flex-auto overflow-y-auto grid grid-cols-5 auto-rows-max gap-2 px-4">
            <template x-for="(question, i) in questions">
                <div @click="currentIndex = i"
                    class="aspect-square flex items-center justify-center border-indigo-700 border-2 text-2xl"
                    :class="(question.selected != null && ' bg-indigo-100 dark:bg-indigo-900 ') +
                    (currentIndex == i && ' !bg-indigo-400 text-white dark:!bg-indigo-400 ') +
                    (question.flag &&
                        ' bg-red-100 border-red-700 !text-black dark:!text-white dark:bg-red-800 dark:border-red-300 ')"
                    x-text="i + 1">
                    1</div>
            </template>
        </div>
        <button type="button"
            class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm mx-3 mb-6 py-3 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
            @click="submit()">Submit</button>
    </aside>

    <div class="sm:p-4 p-2 sm:ml-64 md:ml-80 lg:ml-96 min-h-screen flex flex-col justify-between">
        {{-- main content --}}
        <div class="sm:p-4 p-2 mt-14">
            <div class="flex justify-center">
                <div class=" text-xl dark:bg-slate-800 rounded mb-4 -mt-2 p-2" id="countdown">00:00</div>
            </div>
            {{ $slot }}
        </div>
        <section
            class="grid grid-cols-3 justify-items-center sm:px-8 px-5 py-4 border dark:border-slate-500  bg-slate-100 dark:bg-slate-800 bottom-0 rounded-full">
            {{-- button prev --}}
            <button type="button" :disabled="currentIndex == 0" :class="currentIndex == 0 && 'opacity-50'"
                class="rounded-full w-10 h-10 p-1 rotate-90 border-2 border-cyan-700 bg-cyan-100 text-cyan-800 justify-self-start"
                @click="currentIndex-- "><x-icons.chevron /></button>

            {{-- button flag --}}
            <button type="button"
                class="rounded-2xl border-2 border-red-700 text-red-800 flex gap-2 items-center pr-1 pl-2 dark:text-red-400"
                :class="questions[currentIndex].flag && 'bg-red-100'"
                @click="questions[currentIndex].flag = !questions[currentIndex].flag">Tandai <div class="size-6">
                    <x-icons.flag />
                </div></button>

            {{-- button next --}}
            <button type="button" x-show="currentIndex < questions.length - 1"
                class="rounded-full w-10 h-10 p-1 -rotate-90 border-2 border-cyan-700 bg-cyan-100 text-cyan-800 justify-self-end"
                @click="currentIndex++"><x-icons.chevron /></button>

            {{-- button submit --}}
            <button type="button" x-show="currentIndex == questions.length - 1"
                class="rounded-full p-1 px-2 border-2 border-cyan-700 bg-cyan-100 text-cyan-800 justify-self-end"
                @click="submit()">submit?</button>
            {{-- TODO: confirm before submit --}}
        </section>
    </div>

    @if (json_decode($room->settings)->focus ?? false)
        <x-alerts.out-while-working :$roomId />
    @endif


    <form action="{{ route('user.room.submit', $roomId) }}" method="POST" class="hidden" id="submitForm">
        @csrf
        <input type="hidden" name="data" value="" id="data">
    </form>

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }




        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {

            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

                // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }

        });
    </script>

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
            if (!confirm('apakah anda yakin dengan jawaban anda?')) return
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
