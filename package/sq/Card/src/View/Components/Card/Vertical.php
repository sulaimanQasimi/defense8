<?php

namespace Sq\Card\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Vertical extends Component
{
    public function __construct()
    {
        //
    }
    public function render(): View|Closure|string
    {
        return view('sqcard::components.card.vertical');
    }
}
