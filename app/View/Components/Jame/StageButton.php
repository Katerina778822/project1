<?php

namespace App\View\Components\Jame;

use Illuminate\View\Component;

class StageButton extends Component
{
    public $design;
    public $stage;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($design, $stage = 0)
    {
        //размер кнопки
        if ($design === 1) {
            $this->class = ' w-7/12 h-6';
        }
        if ($design === 2) {
            $this->class = ' w-8/12 h-6';
        }
        if ($design === 3) {
            $this->class = ' w-9/12 h-6';
        }
        if ($design === 4) {
            $this->class = ' w-10/12 h-6';
        }
        if ($design === 5) {
            $this->class = ' w-11/12 h-8 ';
        } elseif ($design === 6) {
            $this->class = 'bg-sky-700 w-6 h-6 ';
        }
        //цвет кнопки
        if ($stage) {
            $this->class =  $this->class . ' bg-sky-700'; //кнопка нажата (стадия пройдена)
        } else
            $this->class =  $this->class . ' bg-sky-300'; //кнопка ненажата
        //Шрифт
        if ($design === 5) {
            $this->class =  $this->class . ' text-sm font-bold'; //Логич стадия
        } else
            $this->class =  $this->class . ' text-xs font-semibold'; //Эмоц стадия 

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.jame.stage-button', ['class' => $this->class]);
    }
}
