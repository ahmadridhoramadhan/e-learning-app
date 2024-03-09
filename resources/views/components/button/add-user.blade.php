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



{{--
<!-- Modal toggle -->
<button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
    class="flex items-center gap-1 border border-black p-2 hover:bg-slate-400 transition-all duration-300 hover:text-white hover:border-slate-800 group shadow-md select-none w-fit rounded-full">
    <div class="w-7 aspect-square group-hover:rotate-90 transition-all"><x-icons.plus /></div>
    <div class="text-sm hidden group-hover:block whitespace-nowrap">Tambah Siswa Baru</div>
</button>


<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Tambah Siswa Baru
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" action="{{ route('admin.users.create.process') }}" method="POST">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Type product name" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" name="price" id="price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="$2999" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Select category</option>
                            <option value="TV">TV/Monitors</option>
                            <option value="PC">PC</option>
                            <option value="GA">Gaming/Console</option>
                            <option value="PH">Phones</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                            Description</label>
                        <textarea id="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write product description here"></textarea>
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add new product
                </button>
            </form>
        </div>
    </div>
</div> --}}
