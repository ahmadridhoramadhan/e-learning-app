<dialog id="modalAddUser{{ $classroomId }}"
    class="max-w-sm rounded-md w-full border border-black dark:text-white pb-4 dark:bg-gray-900 select-none"
    @click="modalAddUser{{ $classroomId }}.close()">
    <div class="w-full h-full" @click="$event.stopPropagation()">
        <div class="flex justify-between py-4 mb-3 border-b-2 px-3 items-center dark:border-gray-600">
            <p class="text-xl font-semibold text-center">Buat Akun Siswa Baru</p>
            <button class="w-6 h-6 ml-auto" @click="modalAddUser{{ $classroomId }}.close()"><x-icons.close /></button>
        </div>
        <div class="w-full flex flex-col px-5">
            <form action="{{ route('admin.users.create.process', $classroomId) }}" method="POST"
                class="w-full flex flex-col gap-3">
                @csrf
                <x-inputs.text :id="'nama' . $classroomId" :label="'Nama'" :name="'name'" :error="''" :value="''"
                    required />
                <x-inputs.text :id="'email' . $classroomId" :label="'Email'" :name="'email'" :type="'email'" :error="''"
                    :value="''" required />
                <div>
                    <x-inputs.text :id="'password' . $classroomId" :label="'Password'" :name="'password'" :type="'password'"
                        :error="''" :value="''" />
                    <p class="text-xs mt-1 ml-px">Generate password otomatis ketika tidak di isi</p>
                </div>

                <div class="gap-2 mt-3">
                    <button type="submit"
                        class="w-full h-full relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                        <span
                            class="w-full h-full relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            Buat
                        </span>
                    </button>
                </div>
            </form>

        </div>
        <form action="{{ route('admin.users.create.file.process', $classroomId) }}" method="POST"
            class="mt-4 px-3 border-t-2 dark:border-gray-700 pt-5" enctype="multipart/form-data">
            @csrf
            <label>
                <div
                    class="w-full text-center py-2 border-2 border-cyan-700 bg-cyan-100 rounded-md shadow-md dark:bg-cyan-900 ">
                    Upload
                    File ( .xlsx dan .csv)</div>
                <input type="file" name="file" class="hidden"
                    @input="$event.target.parentElement.parentElement.submit()">
            </label>
        </form>
    </div>
</dialog>

<button type="button" @click="modalAddUser{{ $classroomId }}.showModal()"
    class="flex flex-col py-8 justify-center items-center w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-full dark:hover:bg-slate-900 transition-colors select-none">
    <div class="size-24">
        <x-icons.plus />
    </div>
    <p>Tambah Siswa </p>
</button>
