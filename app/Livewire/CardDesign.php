<?php

namespace App\Livewire;

use App\Models\PrintCardFrame;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CardDesign extends Component
{
    use WithFileUploads;
    public PrintCardFrame $cardFrame;
    #[Rule('required|string')]
    public $color;
    #[Rule('required|string')]
    public $gov;
    #[Rule('required|string')]

    public $ministry;
    #[Rule('required|numeric')]

    public $ministry_size;
    #[Rule('required|numeric')]
    public $gov_size;
    public $ministery;

    #[Rule('required|numeric')]
    public $qr_x;
    #[Rule('required|numeric')]
    public $qr_y;

    #[Rule('required|numeric')]

    public $pro_x;
    #[Rule('required|numeric')]

    public $pro_y;
    public $background;
    public $background_path;
    #[Rule('required|numeric')]
    public $info_size;
    #[Rule('required|image')]

    public $ministry_logo;
    public $ministry_logo_path;
    #[Rule('required|image')]

    public $gov_logo;
    public $gov_logo_path;

    #[Rule('required|numeric')]
    public $ministry_x;

    #[Rule('required|numeric')]
    public $ministry_y;

    #[Rule('required|numeric')]
    public $gov_x;

    #[Rule('required|numeric')]
    public $gov_y;
    // Back of the Card file

    public $remark;
    public function mount(PrintCardFrame $printCardFrame): void
    {
        $this->cardFrame = $printCardFrame;
        //
        $this->background_path = $this->cardFrame->background_logo;

        //
        $this->qr_x = $this->cardFrame->qr_code_logo_x;
        $this->qr_y = $this->cardFrame->qr_code_logo_y;

        //
        $this->pro_x = $this->cardFrame->profile_logo_x;
        $this->pro_y = $this->cardFrame->profile_logo_y;

        //
        $this->gov = $this->cardFrame->gov_name;
        $this->gov_logo_path = $this->cardFrame->gov_logo;
        $this->gov_size = $this->cardFrame->gov_name_font_size;
        $this->gov_x = $this->cardFrame->gov_logo_x;
        $this->gov_y = $this->cardFrame->gov_logo_y;

        //
        $this->ministry = $this->cardFrame->ministry_name;
        $this->ministry_logo_path = $this->cardFrame->ministry_logo;
        $this->ministry_size = $this->cardFrame->ministry_name_font_size;
        $this->ministry_x = $this->cardFrame->ministry_logo_x;
        $this->ministry_y = $this->cardFrame->ministry_logo_y;

        //
        $this->color = $this->cardFrame->color;
        $this->info_size = $this->cardFrame->info_font_size;
        $this->remark = $this->cardFrame->remark;
    }
    public function updated($name, $value): void
    {
        switch ($name) {
            case "background":
                $this->background_path = Str::after($this->background->store(path: 'public/background'), 'public/');
                $this->cardFrame->background_logo = $this->background_path;
                break;

            case "ministry_logo":
                $this->ministry_logo_path = Str::after($this->ministry_logo->store(path: 'public/card/logo'), 'public/');
                $this->cardFrame->ministry_logo = $this->ministry_logo_path;
                break;

            case "gov_logo":
                $this->gov_logo_path = Str::after($this->gov_logo->store(path: 'public/card/logo'), 'public/');
                $this->cardFrame->gov_logo = $this->gov_logo_path;
                break;

            case "qr_x":
                $this->cardFrame->qr_code_logo_x = $this->qr_x;
                break;
            case "qr_y":
                $this->cardFrame->qr_code_logo_y = $this->qr_y;
                break;
            case "pro_x":
                $this->cardFrame->profile_logo_x = $this->pro_x;
                break;
            case "pro_y":
                $this->cardFrame->profile_logo_y = $this->pro_y;
                break;
            case "color":
                $this->cardFrame->color = $this->color;
                break;
            case "gov_x":
                $this->cardFrame->gov_logo_x = $this->gov_x;
                break;
            case "gov_y":
                $this->cardFrame->gov_logo_y = $this->gov_y;
                break;
            case "ministry_x":
                $this->cardFrame->ministry_logo_x = $this->ministry_x;
                break;
            case "ministry_y":
                $this->cardFrame->ministry_logo_y = $this->ministry_y;
                break;

            case "info_size":
                $this->cardFrame->info_font_size = $this->info_size;
                break;
            case "gov":
                $this->cardFrame->gov_name = $this->gov;
                break;
            case "ministry":
                $this->cardFrame->ministry_name = $this->ministry;
                break;
            case "gov_size":
                $this->cardFrame->gov_name_font_size = $this->gov_size;
                break;
            case "ministry_size":
                $this->cardFrame->ministry_name_font_size = $this->ministry_size;
                break;
            case "remark":
                // $this->cardFrame->remark = $this->remark;
                break;
            default:
        }
        $this->cardFrame->save();
    }
    public function render()
    {
        return view('livewire.card-design');
    }
}
