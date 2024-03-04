<dialog id="modalEditUser" class="pb-5 pt-2 px-2 rounded-md w-full border border-black">
    <div class="w-full flex flex-col">
        <button class="w-8 h-8 ml-auto" @click="modalEditUser.close()"><x-icons.close /></button>
        <p class="text-xl font-semibold text-center pt-1 mb-4">Edit Akun Siswa</p>
        {{-- form edit --}}
        <form action="{{ route('admin.users.edit.process', $student->id) }}" method="POST"
            class="w-full flex flex-col gap-3">
            @csrf
            <x-inputs.text2 :label="'Nama'" :name="'name'" :error="''" :value="$student->name" required />
            <x-inputs.text2 :label="'Email'" :name="'email'" :type="'email'" :error="''" :value="$student->email"
                required />
            <div>
                <x-inputs.text2 :label="'Password'" :name="'password'" :error="''" :value="$student->password" />
                <p class="text-xs">Generate password otomatis ketika tidak di isi</p>
            </div>

            <div class="flex justify-center gap-4 mt-3">
                <button type="button" class="flex-auto border-2 border-black py-2 rounded-md"
                    @click="modalEditUser.close()">Batal</button>
                <button type="submit" class="flex-auto border border-black bg-cyan-200 py-2 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</dialog>

<button type="button" @click="modalEditUser.showModal();"
    class="flex items-start gap-1 py-1 px-2 bg-cyan-700 border-2 border-cyan-200 w-fit rounded-md absolute bottom-2 right-2">
    <span>Edit</span>
    <div class="w-4 h-4 shrink-0"><x-icons.edit /></div>
</button>
