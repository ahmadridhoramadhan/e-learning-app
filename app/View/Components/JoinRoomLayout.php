<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JoinRoomLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public object $room,
        public string $questions,
        public string $roomId,
        public string $maxTime,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.joinRoom');
    }
}
