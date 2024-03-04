<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class text extends Component
{
    public $name;
    public $label;
    public $type;
    public $error;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $type = 'text', $error)
    {
        $this->name = $name;
        $this->error = $error;
        $this->label = $label;
        $this->type = in_array($type, ['email', 'text', 'password']) ? $type : 'text';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.text');
    }
}
