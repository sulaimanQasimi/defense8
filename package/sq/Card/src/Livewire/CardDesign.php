<?php

namespace Sq\Card\Livewire;

use Sq\Card\Livewire\Contracts\CardAttribute;
use Sq\Card\Models\PrintCardFrame;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CardDesign extends Component
{
    use WithFileUploads;
    use CardAttribute;
    public PrintCardFrame $cardFrame;

    public $attr;
    public $details;
    public $remark;

    /**
     * Summary of mount
     * @param \Sq\Card\Models\PrintCardFrame $printCardFrame
     * @return void
     */
    public function mount(PrintCardFrame $printCardFrame): void
    {
        $this->cardFrame = $printCardFrame;
        $this->attr = $printCardFrame->attr;
        $this->details = $printCardFrame->details;
        $this->remark = $printCardFrame->remark;
    }

    /**
     * Update the Front page content
     * @param mixed $value
     * @return void
     */
    public function updatedDetails($value)
    {
        $this->cardFrame->update(attributes: ['details' => $value]);
    }

    /**
     * Summary of updatedRemark
     * @param mixed $value
     * @return void
     */
    public function updatedRemark($value)
    {
        $this->cardFrame->update(['remark' => $value]);
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('sqcard::livewire.guest.card-design');
    }
}
