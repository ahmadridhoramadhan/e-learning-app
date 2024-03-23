<?php

namespace App\View\Components\cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class deleteInDangerZone extends Component
{
    public ?string $title;
    public ?string $action;
    public ?string $method;
    public ?string $buttonText;
    public ?string $explanation;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = null,
        $action = null,
        $method = 'DELETE',
        $buttonText = 'Hapus',
        $explanation = null
    ) {
        $this->title = $title;
        $this->action = $action;
        $this->method = $method;
        $this->buttonText = $buttonText;
        $this->explanation = $explanation;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.delete-in-danger-zone');
    }
}
