<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class text extends Component
{
    public $name;
    public $id;
    public $label;
    public $type;
    public $error;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label, $type = 'text', $error = null, $value = null, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->error = $error;
        $this->label = $label;
        $this->type = in_array($type, ['email', 'text', 'password']) ? $type : 'text';
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.text');
    }
}
