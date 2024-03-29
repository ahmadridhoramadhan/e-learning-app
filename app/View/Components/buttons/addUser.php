<?php

namespace App\View\components\buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addUser extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $classroomId)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buttons.add-user');
    }
}
