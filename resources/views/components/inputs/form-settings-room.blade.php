<div class="flex flex-col gap-5 mb-5">
    @php
        // jika room ada buat variabel settings yang berisi array dari string $room->settings jika tidak buat array kosong
        if (isset($room)) {
            $settings = $room ? json_decode($room->settings, true) : [];
        }
    @endphp
    <x-inputs.text :value="$room['name'] ?? false" :name="'name'" :label="'Nama Room'" :error="$errors->first('name')" required />
    <x-inputs.text :value="$room['password'] ?? false" :name="'password'" :label="'Password'" :type="'password'" :error="$errors->first('password')" />
    <x-inputs.text :value="$settings['max_time'] ?? false" :name="'timer'" :label="'Waktu Pengerjaan'" :type="'number'" :error="$errors->first('timer')" />

    <x-inputs.checkbox :checked="$settings['show_result'] ?? false" :name="'show_result'" :label="'Lihat Hasil'" :value="true" :explanation="'hasil jawaban akan langsung ditampilkan setelah siswa melakukan submit'" />
    <x-inputs.checkbox :checked="$settings['answer_history'] ?? false" :name="'answer_history'" :label="'History Jawaban'" :value="true" :explanation="'siswa dapat melihat soal lagi setelah di submit beserta jawaban yang benar'" />
    <x-inputs.checkbox :checked="$settings['answer_again'] ?? false" :name="'answer_again'" :label="'Jawab Lagi'" :value="true" :explanation="'siswa dapat submit lebih dari satu kali'" />
    <x-inputs.checkbox :checked="$settings['leader_board'] ?? false" :name="'leader_board'" :label="'Papan Peringkat'" :value="true" :explanation="'siswa dapat melihat top 5 niali teratas'" />
    <x-inputs.checkbox :checked="$settings['average_score'] ?? false" :name="'average_score'" :label="'Nilai Rata Rata'" :value="true" :explanation="'siswa dapat melihat rata rata nilai di room ini'" />
    <x-inputs.checkbox :checked="$settings['list_score_user'] ?? false" :name="'list_score_user'" :label="'Daftar Nilai'" :value="true" :explanation="'daftar nilai semua siswa di room ini akan di tampilkan'" />
    <x-inputs.checkbox :checked="$settings['focus'] ?? false" :name="'focus'" :label="'Fokus'" :value="true" :explanation="'siswa tidak bisa pindah halaman sembarangan jika pindah halaman maka user harus meminta izin anda'" />
</div>
<script>
    const show_result = document.getElementById('show_result');
    const answer_history = document.getElementById('answer_history');
    const answer_again = document.getElementById('answer_again');
    const leader_board = document.getElementById('leader_board');
    const average_score = document.getElementById('average_score');
    const list_score_user = document.getElementById('list_score_user');
    const focus = document.getElementById('focus');



    show_result.addEventListener('change', () => {
        if (show_result.checked) {
            average_score.checked = true;
        } else {
            average_score.checked = false;
        }
    });
    average_score.addEventListener('change', () => {
        if (average_score.checked) {
            show_result.checked = true;
        }
    });

    leader_board.addEventListener('change', () => {
        if (leader_board.checked) {
            list_score_user.checked = true;
        } else {
            list_score_user.checked = false;
        }
    });
    list_score_user.addEventListener('change', () => {
        if (list_score_user.checked) {
            leader_board.checked = true;
        }
    });
</script>
