<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FullCalendar extends Component
{
    /**
     * Create a new component instance.
     */


        public $events;

    // Constructor to accept data
    public function __construct($events)
    {
        $this->events = $events;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.full-calendar');
    }
}
