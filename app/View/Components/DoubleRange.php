<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DoubleRange extends Component
{
    public $step;
    public $min;
    public $max;
    public $value;
    public $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($step, $min, $max, $value, $model)
    {
        $this->step = $step;
        $this->min = $min;
        $this->max = $max;
        $this->value = $value;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.double-range');
    }
}
