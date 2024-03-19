{{-- question card --}}
<div class="border-b-2 border-gray-300 mb-3 pb-3 last:border-b-0 dark:border-gray-700">
    <p class="mb-2 text-lg">{!! $question->question->question !!}</p>
    <ul class="pl-1 flex flex-col gap-1 list-disc ml-5">
        @foreach ($question->question->answers as $answer)
            <li
                class="break-all {{ $answer->id == $question->answer_id ? ' dark:text-red-500 text-red-700 font-semibold ' : '' }} {{ $answer->id == $question->question->answer_id ? ' !text-green-700 dark:text-green-500 font-semibold ' : '' }}">
                {!! $answer->answer !!}
            </li>
        @endforeach
    </ul>
    @if ($question->answer_id == null)
        <p class="text-red-700 text-sm">anda tidak menjawab</p>
    @endif
</div>
