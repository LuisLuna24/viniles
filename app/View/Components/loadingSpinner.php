<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class loadingSpinner extends Component
{
    public $colspan;
    /**
     * Create a new component instance.
     */
    public function __construct($colspan)
    {
        $this->colspan = $colspan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.loading-spinner');
    }
}
