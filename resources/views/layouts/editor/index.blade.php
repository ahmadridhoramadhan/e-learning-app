<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <title>{{ $title }} | {{ config('app.name') }}</title>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body class="flex flex-col min-h-screen dark:bg-slate-900 dark:text-white" x-data="{
    questions: JSON.parse(sessionStorage.getItem('{{ $title }}')) || {!! $attributes->get('questions') !!} || [],
    currentIndex: 0,
    addQuestion: function() {
        this.questions.push({
            id: null,
            question: '<p>soal ...</p>',
            answers: [{
                id: null,
                answer: '<p>jawaban yang benar ...</p>'
            }]
        });
        this.currentIndex = this.questions.length - 1;
        this.storeSession();
    },
    storeSession: function() {
        sessionStorage.setItem('{{ $title }}', JSON.stringify(this.questions));
    },
    getSession: function() {
        this.questions = JSON.parse(sessionStorage.getItem('{{ $title }}')) || [];
    },
}" x-init="if (questions.length == 0) {
    questions.push({
        id: null,
        question: '<p>soal ...</p>',
        answers: [{
            'id': null,
            answer: '<p>jawaban yang benar ...</p>'
        }]
    });
};
storeSession();
setInterval(() => {
    saveToApi(currentIndex);
}, 150000);">



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
                    <a href="https://flowbite.com" class="flex ms-2 md:me-24">
                        {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" /> --}}
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
                                    <a href="#"
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
            <div
                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:bg-slate-900 shadow dark:shadow-slate-600 bg-white dark:hover:bg-slate-700 group {{ Route::is('user.dashboard') ? 'dark:bg-slate-900 ' : '' }}">
                <div class="flex flex-auto items-center">
                    <a href="{{ route('user.room.detail', $roomId) }}" class="flex-auto ml-2">
                        <span class="text-xl">{{ $title }}</span><br>
                    </a>
                    <a href="{{ route('admin.rooms.settings', request()->segment(4)) }}" class="block w-7 h-7 mr-2">
                        <x-icons.settings />
                    </a>
                </div>
            </div>
        </div>
        <div class="flex-auto overflow-y-auto grid grid-cols-5 auto-rows-max gap-2 px-4">
            {{-- move between questions --}}
            <template x-for="(question, i) in questions">
                <div class="border border-black text-2xl aspect-square flex justify-center items-center dark:border-white"
                    :class="(currentIndex === i ? 'bg-cyan-200 dark:bg-cyan-800' : '')" x-text="i+1"
                    @click="currentIndex = i">
                </div>
            </template>
            <div class="border border-indigo-800 text-indigo-800 text-2xl aspect-square flex justify-center items-center bg-indigo-100 dark:bg-indigo-800 dark:text-indigo-100 dark:border-indigo-200"
                @click="addQuestion()">
                <x-icons.plus />
            </div>
        </div>
        <button type="button"
            class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm mx-3 py-3 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
            @click="saveToApi(currentIndex)">Simpan</button>
        <a href="{{ route('admin.rooms.detail', request()->segment(4)) }}"
            class="text-center block mb-5 py-2 border dark:border-white border-black mx-4 rounded-md shadow dark:shadow-slate-600 dark:hover:bg-slate-900 hover:bg-slate-200 transition-colors">Kembali</a>
    </aside>

    <div class="sm:p-4 p-2 sm:ml-64 md:ml-80 lg:ml-96 min-h-screen flex flex-col justify-between">
        {{-- main content --}}
        <div class="sm:p-4 p-2 mt-14 relative">
            {{ $slot }}
        </div>
        <section
            class="grid grid-cols-3 justify-items-center sm:px-8 px-5 py-4 border dark:border-slate-500  bg-slate-100 dark:bg-slate-800 bottom-0 rounded-full">
            {{-- prev --}}
            <button type="button" @click="save(currentIndex); getSession(); currentIndex--; "
                :disabled="currentIndex <= 0" :class="(currentIndex <= 0 ? ' opacity-20' : '')"
                class="'w-10 h-10 rotate-90 flex justify-center items-center rounded-full border border-gray-700 justify-self-start">
                <x-icons.chevron />
            </button>

            {{-- trash --}}
            <button type="button"
                class="border-red-500 flex items-center pl-2 border dark:text-red-400 rounded-md shadow-md p-2 text-red-700 justify-self-center"
                @click="questions.splice(currentIndex, 1);
                    if(currentIndex >= questions.length){currentIndex--};
                    storeSession();">
                <span class="hidden sm:inline">Hapus</span>
                <div class="size-7">
                    <x-icons.trash />
                </div>
            </button>

            {{-- add question --}}
            <button type="button"
                class="p-1 border w-10 h-10 border-black rounded-full shadow-md bg-cyan-300 justify-self-end"
                x-show="currentIndex === questions.length - 1"
                @click="save(currentIndex); getSession(); addQuestion();">
                <x-icons.plus />
            </button>

            {{-- next --}}
            <button type="button" @click="save(currentIndex); getSession(); currentIndex++;"
                x-show="currentIndex <= questions.length - 2"
                class="w-10 h-10 -rotate-90 flex justify-center items-center rounded-full border border-gray-700 justify-self-end">
                <x-icons.chevron />
            </button>
        </section>
    </div>


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
        // Render Summernote
        let currentElement = null;

        function renderSummernote(element) {
            element = element.closest(".editor");

            if (currentElement) {
                let markup = $(currentElement).summernote('code');
                $(currentElement).summernote('destroy');
                $(currentElement).html(markup);
            }

            currentElement = element;
            $(element).summernote({
                focus: true,
                callbacks: {
                    onBlur: function(e) {
                        // Cek apakah klik dilakukan di luar editor dan toolbar Summernote
                        if (!$(e.relatedTarget).closest('.note-editor').length) {
                            let markup = $(element).summernote('code');
                            $(element).summernote('destroy');
                            $(element).html(markup);
                            currentElement = null;
                        }
                    }
                }
            });
        }

        function addAnswer() {
            let markup = `
                <div class="relative">
                    <div class="answer editor border-black border rounded-lg shadow-md p-2 pl-3 min-h-10 dark:border-white" @click="renderSummernote($event.target)" :data-id="null">
                        <p>
                            jawaban salah ...
                        </p>
                    </div>

                    <div class="rotate-45 text-red-500 absolute top-px right-px w-8 aspect-square"
                        @click="$event.target.closest('.relative').remove()">
                        <x-icons.plus />
                    </div>
                </div>
            `;
            const element = document.getElementById('container-answers');

            // menambahkan markup di dalam element di urutan terakhir
            element.insertAdjacentHTML("beforeend", markup);
        }

        function save(currentIndex) {
            // ambil class question dan semua class answer
            const question = document.querySelector('.question');
            const answers = document.querySelectorAll('.answer');

            // simpan isinya menjadi format JSON seperti ini {question: '', answers: ['','']}
            let data = {
                id: question.dataset.id || null,
                question: question.innerHTML,
                answers: []
            };
            answers.forEach(answer => {
                data.answers.push({
                    id: answer.dataset.id || null,
                    answer: answer.innerHTML
                });
            });

            // ambil data dari session storage
            let questions = JSON.parse(sessionStorage.getItem('{{ $title }}')) || [];

            // jika currentIndex sama dengan panjang questions - 1 maka push data jika tidak maka ganti data di index tersebut
            if (currentIndex >= questions.length) {
                questions.push(data);
            } else {
                questions[currentIndex] = data;
            }

            // simpan data ke session storage
            sessionStorage.setItem('{{ $title }}', JSON.stringify(questions));
        }

        async function saveToApi(currentIndex) {
            save(currentIndex);

            try {
                // ambil data dari session storage
                let dataQuestions = sessionStorage.getItem('{{ $title }}') || [];

                var formdata = new FormData();
                formdata.append("data", dataQuestions);

                var requestOptions = {
                    method: 'POST',
                    body: formdata,
                    redirect: 'follow'
                };

                const res = await fetch("{{ route('admin.rooms.save', request()->segment(4)) }}",
                    requestOptions);

                const data = await res.json();
                console.log(data)
                if (res.ok) {
                    // Create an alert element
                    const alertContainer = document.getElementById('alert');
                    const alertElement = `
                        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Berhasil!</span> data sudah di simpan ke database.
                            </div>
                        </div>
                    `
                    alertContainer.innerHTML = alertElement;

                    setTimeout(function() {
                        alertContainer.innerHTML = '';
                    }, 4000);
                } else {
                    console.log('Data gagal disimpan');
                }
            } catch (error) {
                console.error(error);
            }
        }
    </script>
</body>

</html>
