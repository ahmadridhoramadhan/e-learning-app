<dialog id="alertUserLeftTheSite" class="w-full rounded-md shadow-md">
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
    window.addEventListener('blur', function() {
        alertUserLeftTheSite.showModal()
    });
</script>
