<x-app-layout>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ Auth::user()->name }}
    </h2>


    <a href="{{ route('logout') }}">logout</a>
</x-app-layout>
