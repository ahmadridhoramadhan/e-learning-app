<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    @if ($attributes->has('title'))
        <title>{{ $attributes->get('title') }} | {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body class="flex flex-col min-h-screen" x-data="{
    questions: {!! $attributes->get('questions') !!} || [],
    currentIndex: 0,
    addQuestion: function() {
        this.questions.push({
            question: '<p>soal ...</p>',
            answers: ['<p>jawaban ...</p>']
        });
        this.currentIndex = this.questions.length - 1;
        this.storeSession();
    },
    storeSession: function() {
        sessionStorage.setItem('{{ $attributes->get('title') }}', JSON.stringify(this.questions));
    },
    getSession: function() {
        this.questions = JSON.parse(sessionStorage.getItem('{{ $attributes->get('title') }}')) || [];
    },
}" x-init="if (questions.length == 0) {
    questions.push({
        question: '<p>soal ...</p>',
        answers: ['<p>jawaban ...</p>']
    });
}
storeSession();

setInterval(() => {
    saveToApi(currentIndex);
}, 150000);">
    {{-- include header --}}
    @include('layouts.editor.header')

    {{-- page content --}}
    <main class="flex-auto container mx-auto px-3 md:px-0">
        {{ $slot }}
    </main>

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
                    <div class="answer editor border-black border rounded-lg shadow-md p-2 pl-3 min-h-10" @click="renderSummernote($event.target)">
                        <p>
                            jawaban ...
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
                question: question.innerHTML,
                answers: []
            };
            answers.forEach(answer => {
                data.answers.push(answer.innerHTML);
            });

            // ambil data dari session storage
            let questions = JSON.parse(sessionStorage.getItem('{{ $attributes->get('title') }}')) || [];

            // jika currentIndex sama dengan panjang questions - 1 maka push data jika tidak maka ganti data di index tersebut
            if (currentIndex >= questions.length) {
                questions.push(data);
            } else {
                questions[currentIndex] = data;
            }

            // simpan data ke session storage
            sessionStorage.setItem('{{ $attributes->get('title') }}', JSON.stringify(questions));
        }

        async function saveToApi(currentIndex) {
            save(currentIndex);

            // fetch("{{ route('admin.rooms.save', request()->segment(4)) }}", requestOptions)
            //     .then(response => response.text())
            //     .then(result => console.log(result))
            //     .catch(error => console.log('error', error));

            try {
                // ambil data dari session storage
                let dataQuestions = sessionStorage.getItem('{{ $attributes->get('title') }}') || [];

                var formdata = new FormData();
                formdata.append("data", dataQuestions);

                var requestOptions = {
                    method: 'POST',
                    body: formdata,
                    redirect: 'follow'
                };

                const res = await fetch("{{ route('admin.rooms.save', request()->segment(4)) }}", requestOptions);

                const data = await res.json();

                console.log(data);
            } catch (error) {
                console.error(error);
            }
        }
    </script>
</body>

</html>
