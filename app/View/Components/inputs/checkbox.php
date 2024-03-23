<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class checkbox extends Component
{
    public string $name;
    public string $label;
    public ?string $value;
    public ?string $explanation;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $label,
        string $value = '',
        string $explanation = ''
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->explanation = $explanation;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.checkbox');
    }
}
