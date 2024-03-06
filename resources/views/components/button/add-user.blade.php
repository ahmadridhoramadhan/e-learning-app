<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
</div>
<dialog id="modalAddUser" class="pb-5 max-w-96 pt-2 px-2 md:px-4 rounded-md w-full border border-black">
    <div class="w-full flex flex-col">
        <button class="w-8 h-8 ml-auto" @click="modalAddUser.close()"><x-icons.close /></button>
        <p class="text-xl font-semibold text-center pt-1 mb-4">Buat Akun Siswa Baru</p>
        <form action="{{ route('admin.users.create.process') }}" method="POST" class="w-full flex flex-col gap-3">
            @csrf
            <x-inputs.text2 :label="'Nama'" :name="'name'" :error="''" :value="''" required />
            <x-inputs.text2 :label="'Email'" :name="'email'" :type="'email'" :error="''" :value="''"
                required />
            <div>
                <x-inputs.text2 :label="'Password'" :name="'password'" :type="'password'" :error="''"
                    :value="''" />
                <p class="text-xs">Generate password otomatis ketika tidak di isi</p>
            </div>

            <div class="flex justify-center gap-4 mt-3">
                <button type="button" class="flex-auto border-2 border-black py-2 rounded-md"
                    @click="modalAddUser.close()">Batal</button>
                <button type="submit" class="flex-auto border border-black bg-cyan-200 py-2 rounded-md">Buat</button>
            </div>
        </form>

        <form action="{{ route('admin.users.create.file.process') }}" method="POST" class="mt-4"
            enctype="multipart/form-data">
            @csrf
            <label>
                <div class="w-full text-center py-2 border-2 border-cyan-700 bg-cyan-100 rounded-md shadow-md">Pilih
                    File ( .xlsx dan .csv)</div>
                <input type="file" name="file" id="user" class="hidden"
                    @input="$event.target.parentElement.parentElement.submit()">
            </label>
        </form>
    </div>
</dialog>

<button type="button" @click="modalAddUser.showModal()"
    class="flex items-center gap-1 border border-black p-2 hover:bg-slate-400 transition-all duration-300 hover:text-white hover:border-slate-800 group shadow-md select-none w-fit rounded-full">
    <div class="w-7 aspect-square group-hover:rotate-90 transition-all"><x-icons.plus /></div>
    <div class="text-sm hidden group-hover:block whitespace-nowrap">Tambah Siswa Baru</div>
</button>
