<x-app-layout :title="'settings profile'">
    <div id="container-warning">
        @if (session('success'))
            <x-alerts.success :message="session('success')" />
        @endif
    </div>
    <div class="max-w-xl mx-auto mt-4">
        <form action="" method="POST" class="space-y-6">
            @csrf
            <x-inputs.text :label="'Nama'" :name="'name'" :value="$user->name" :error="$errors->first('name')" />
            <x-inputs.text :label="'Email'" :name="'email'" :type="'email'" :value="$user->email" :error="$errors->first('email')" />
            <x-inputs.text :label="'Password'" :name="'password'" :type="'password'" :value="''"
                :error="$errors->first('password')" />

            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file"
                    class="flex relative flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <img src="{{ $user->profile_picture_url }}" alt="avatar" id="show-image-preview"
                        class="absolute h-full z-10 aspect-square object-cover" />
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 absolute z-0">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" />
                </label>
            </div>

            <input id="hidden-input" type="hidden" name="profile_picture_url"
                value="{{ $user->profile_picture_url }}" />


            <button type="submit"
                class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Simpan</button>
        </form>
    </div>

    <script>
        const containerWarning = document.getElementById('container-warning');
        document.getElementById('dropzone-file').addEventListener('change', function() {
            var file = this.files[0];
            let message = '';

            if (file.size > 500 * 1024) { // Ukuran file lebih dari 500KB
                message = 'Ukuran file melebihi 500KB. Silakan pilih file yang lebih kecil.';
            } else if (!file.type.match('image.*')) { // File bukan gambar
                message = 'File bukan gambar. Silakan pilih file gambar.';
            } else if (file.type !== 'image/png' && file.type !== 'image/jpeg') { // File bukan PNG atau JPEG
                message = 'Format file bukan PNG atau JPEG. Silakan pilih file dengan format yang benar.';
            } else {
                var reader = new FileReader();

                reader.onloadend = function() {
                    document.getElementById('hidden-input').value = reader.result;
                    document.getElementById('show-image-preview').src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file);
                }
                return;
            }

            containerWarning.innerHTML = `
            <div id="alert-4"
                class="flex items-center p-4 mb-4 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 border-2 dark:border-yellow-300"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium" id="warning-message">
                    ${message}
                </div>
            </div>
            `;

            setTimeout(() => {
                containerWarning.innerHTML = '';
            }, 4000);
        }, false);
    </script>
</x-app-layout>
