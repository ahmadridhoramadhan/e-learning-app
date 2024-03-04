@php
    $class1 = 'flex justify-between py-1 px-2 rounded-full items-center text-black border-2 border-black w-[93%]';
    if ($number == 1) {
        $class1 = 'flex justify-between bg-indigo-700 p-2 rounded-full items-center text-white ';
    } elseif ($number == 2) {
        $class1 = 'flex justify-between bg-indigo-500 p-2 rounded-full items-center text-white w-[97%]';
    } elseif ($number == 3) {
        $class1 = 'flex justify-between bg-indigo-300 p-2 rounded-full items-center text-black w-[94%]';
    }
@endphp

<div class="{{ $class1 }}">
    <div class="flex items-center gap-2 text-xl">
        <div class="aspect-square w-10 flex justify-center items-center bg-white rounded-full text-black">
            {{ $number }}
        </div>
        <div class="text-lg">{{ $name }}</div>
    </div>
    <div class="mr-3 text-2xl">{{ $score }}</div>
</div>
