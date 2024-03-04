<div class="flex flex-col gap-5 mb-5">
    @php
        // jika room ada buat variabel settings yang berisi array dari string $room->settings jika tidak buat array kosong
        if (isset($room)) {
            $settings = $room ? json_decode($room->settings, true) : [];
        }
    @endphp
    <x-inputs.text2 :value="$room['name'] ?? false" :name="'name'" :label="'Nama Room'" :error="$errors->first('name')" required />
    <x-inputs.text2 :value="$room['password'] ?? false" :name="'password'" :label="'Password'" :type="'password'" :error="$errors->first('password')" />
    <x-inputs.text2 :value="$settings['max_time'] ?? false" :name="'timer'" :label="'Waktu Pengerjaan'" :type="'number'" :error="$errors->first('timer')" />

    <x-inputs.checkbox :checked="$settings['show_result'] ?? false" :name="'show_result'" :label="'Lihat Hasil'" :value="true" :explanation="'hasil jawaban akan langsung ditampilkan setelah siswa melakukan submit'" />
    <x-inputs.checkbox :checked="$settings['answer_history'] ?? false" :name="'answer_history'" :label="'History Jawaban'" :value="true" :explanation="'siswa dapat melihat soal lagi setelah di submit beserta jawaban yang benar'" />
    <x-inputs.checkbox :checked="$settings['answer_again'] ?? false" :name="'answer_again'" :label="'Jawab Lagi'" :value="true" :explanation="'siswa dapat submit lebih dari satu kali'" />
    <x-inputs.checkbox :checked="$settings['leader_board'] ?? false" :name="'leader_board'" :label="'Papan Peringkat'" :value="true" :explanation="'siswa dapat melihat top 5 niali teratas'" />
    <x-inputs.checkbox :checked="$settings['average_score'] ?? false" :name="'average_score'" :label="'Nilai Rata Rata'" :value="true" :explanation="'siswa dapat melihat rata rata nilai di room ini'" />
    <x-inputs.checkbox :checked="$settings['list_score_user'] ?? false" :name="'list_score_user'" :label="'Daftar Nilai'" :value="true" :explanation="'daftar nilai semua siswa di room ini akan di tampilkan'" />
</div>
