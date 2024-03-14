<dialog id="modalEditUser{{ $student->id }}"
    class="pb-5 rounded-md w-full border border-black dark:bg-slate-900 dark:text-white max-w-sm"
    @click="modalEditUser{{ $student->id }}.close()">
    <div class="w-full h-full" @click="$event.stopPropagation()">
        <div class="flex justify-between items-center py-5 mb-6 px-4 border-b-2 dark:border-gray-600">
            <p class="text-xl font-semibold">Edit Akun Siswa</p>
            <button class="w-8 h-8 ml-auto" @click="modalEditUser{{ $student->id }}.close()"><x-icons.close /></button>
        </div>
        <div class="w-full flex flex-col px-3">
            {{-- form edit --}}
            <form action="{{ route('admin.users.edit.process', $student->id) }}" method="POST"
                class="w-full flex flex-col gap-3">
                @csrf
                <x-inputs.text2 :label="'Nama'" :name="'name'" :error="''" :value="$student->name" required />
                <x-inputs.text2 :label="'Email'" :name="'email'" :type="'email'" :error="''"
                    :value="$student->email" required />
                <div>
                    <x-inputs.text2 :label="'Password'" :name="'password'" :error="''" :value="$student->password" />
                    <p class="text-xs">Generate password otomatis ketika tidak di isi</p>
                </div>

                <div class="flex justify-center gap-4 mt-3">
                    <button type="submit"
                        class="flex-auto h-full focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Simpan</button>
                    <button type="button"
                        class="flex-auto py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        @click="modalEditUser{{ $student->id }}.close()">Batal</button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<button type="button"
    class="block w-full text-start px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
    @click="modalEditUser{{ $student->id }}.showModal();">
    <span>Edit</span>
</button>
