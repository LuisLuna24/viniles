<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class toggleSwitch extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $checked;
    public $disabled;
    public $wireClick;
    public function __construct($id, $checked = false, $disabled = false, $wireClick = '')
    {
        $this->id = $id;
        $this->checked = $checked;
        $this->disabled = $disabled;
        $this->wireClick = $wireClick;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toggle-switch');
    }
}
