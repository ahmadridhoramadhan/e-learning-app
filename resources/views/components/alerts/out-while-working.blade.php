<dialog id="alertUserLeftTheSite" class="w-full max-w-sm rounded-md shadow-md">
    <div class="flex flex-col items-center px-4 py-4 gap-7 w-full">
        <p>Anda telah keluar dari browser sebanyak 3 kali atau lebih. room ini menggunakan mode fokus tunggu pemilik
            room untuk mengizinkan anda masuk lagi</p>
        <div class="select-none">
            <x-loading />
        </div>
        <div class="w-full">
            <a href="{{ route('user.dashboard') }}"
                class="w-full py-2 border-2 rounded-md border-red-700 text-red-800 bg-red-100 inline-block text-center">kembali
                ke
                dashboard</a>
        </div>
    </div>
</dialog>
<script>
    let totalLeave = 0
    async function leaveRoom() {
        try {
            const res = await fetch('{{ route('user.room.leave.process', [$roomId, auth()->user()->id]) }}', {
                method: 'POST',
            })

            const data = await res.json()

            console.log(data)
        } catch (error) {
            console.error(error)

        }
    }
    window.addEventListener('blur', function() {
        totalLeave++

        if (totalLeave >= 3) alertUserLeftTheSite.showModal()

        // FIXME: ini mungkin tidak bekerja jika user lelet
        setTimeout(() => {
            if (totalLeave >= 3) leaveRoom()
        }, 2000);
    });
</script>
