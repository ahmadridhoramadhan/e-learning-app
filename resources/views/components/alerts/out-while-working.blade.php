<dialog id="alertUserLeftTheSite" class="w-full max-w-sm rounded-md shadow-md">
    <div class="flex flex-col items-center px-4 py-4 gap-7 w-full">
        <p>Meminta izin untuk masuk</p>
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
        alertUserLeftTheSite.showModal()

        // FIXME: ini mungkin tidak bekerja jika user lelet
        setTimeout(() => {
            leaveRoom()
        }, 2000);
    });
</script>
