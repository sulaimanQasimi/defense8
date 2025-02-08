<?php

namespace Sq\Card\Livewire;

use Sq\Card\Livewire\Contracts\CardAttribute;
use Livewire\Component;
use Livewire\WithFileUploads;
use Sq\Card\Models\CustomPaperCard;

class CustomCardDesign extends Component
{
    use WithFileUploads;
    use CardAttribute;
    public CustomPaperCard $cardFrame;

    public array $paperSize = [
        "A0" => [841, 1189],
        "A1" => [594, 841],
        "A2" => [420, 594],
        "A3" => [297, 420],
        "A4" => [210, 297],
        "A5" => [148, 210],
        "A6" => [105, 148],
        "A7" => [74, 105],
        "A8" => [52, 74],
        "A9" => [37, 52],
        "A10" => [26, 37],
        "B0" => [1000, 1414],
        "B1" => [707, 1000],
        "B2" => [500, 707],
        "B3" => [353, 500],
        "B4" => [250, 353],
        "B5" => [176, 250],
        "B6" => [125, 176],
        "B7" => [88, 125],
        "B8" => [62, 88],
        "B9" => [44, 62],
        "B10" => [31, 44],
        "C0" => [917, 1297],
        "C1" => [648, 917],
        "C2" => [458, 648],
        "C3" => [324, 458],
        "C4" => [229, 324],
        "C5" => [162, 229],
        "C6" => [114, 162],
        "C7" => [81, 114],
        "C8" => [57, 81],
        "C9" => [40, 57],
        "C10" => [28, 40]

    ];
    protected string  $route = 'sq.card.livewire.custom-card-design';
    
    public $attr;
    public $details;
    public $remark;

    protected function ModelRoute()
    {
        return route('sq.employee.paper-design-card', ['customPaperCard' => $this->cardFrame]);
    }


    /**
     * Summary of mount
     * @param CustomPaperCard $printCardFrame
     * @return void
     */
    public function mount(CustomPaperCard $customPaperCard): void
    {
        $this->cardFrame = $customPaperCard;
        $this->attr = $customPaperCard->attr;
        $this->details = $customPaperCard->details;
        $this->remark = $customPaperCard->remark;
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
        //sq.card.livewire.custom-card-design
        return view('sqcard::livewire.custom-card-design');
    }
}
