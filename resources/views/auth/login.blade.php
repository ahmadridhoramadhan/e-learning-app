<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')


    <title>login - ISA</title>
</head>

<body class="min-h-screen flex justify-center items-center">
    <form class="flex flex-col justify-center items-center md:px-16 px-2 max-w-3xl w-full" method="POST"
        action="{{ route('login.process') }}">
        @csrf


        <header
            class="text-black text-7xl font-bold leading-[93.6px] tracking-tighter self-center whitespace-nowrap max-md:text-4xl">
            Login
        </header>

        @if (session('error'))
            <x-alert.danger :title="'Login Error'" :message="session('error')" />
        @endif

        <div class="w-full flex flex-col gap-3 mb-4 mt-10">

            <x-inputs.text name="email" label="Email" type="email" error="{{ $errors->first('email') }}" />
            <x-inputs.text name="password" label="Password" type="password" error="{{ $errors->first('password') }}" />
        </div>

        <div class="w-full">
            <button type="submit"
                class="w-full flex justify-center items-center border-2 border-black rounded-md py-5 mb-10">
                Login
                <x-icons.login />
            </button>
            <a href="{{ route('google.login') }}"
                class="flex items-center justify-center gap-5 w-full py-3 border-2 border-black rounded-md">
                <img src="/icons/google.svg" alt="">
                Masuk menggunakan google
            </a>
        </div>
    </form>
</body>

</html>
