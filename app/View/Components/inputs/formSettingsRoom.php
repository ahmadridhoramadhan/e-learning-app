<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class formSettingsRoom extends Component
{
    public ?object $room;
    /**
     * Create a new component instance.
     */
    public function __construct($room = null)
    {
        $this->room = $room;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.form-settings-room');
    }
}
