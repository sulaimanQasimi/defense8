<?php

namespace Sq\Card\Livewire;

use Sq\Card\Models\PrintCardFrame;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CardDesign extends Component
{
    use WithFileUploads;

    public PrintCardFrame $cardFrame;

    public $attr;
    public $details;
    public $remark;
    public function mount(PrintCardFrame $printCardFrame): void
    {
        $this->cardFrame = $printCardFrame;
        $this->attr = $printCardFrame->attr;
        $this->details = $printCardFrame->details;
        $this->remark = $printCardFrame->remark;
    }
    public function updatedAttr($value, $key)
    {
        switch ($key) {
            case "content.background":
                $this->cardFrame->update(['attr->content->background' => Str::after($this->attr['content']['background']->store(path: 'public/background'), 'public/')]);

                $this->redirect(route('sq.employee.design-card', ['printCardFrame' => $this->cardFrame]), true);
                break;

            case "government.path":
                $this->cardFrame->update(['attr->government->path' => Str::after($this->attr['government']['path']->store(path: 'public/government'), 'public/')]);

                $this->redirect(route('sq.employee.design-card', ['printCardFrame' => $this->cardFrame]), true);
                break;
            case "government.title":
                $this->cardFrame->update(['attr->government->title' => $this->attr['government']['title']]);
                break;
            case "government.fontSize":
                $this->cardFrame->update(['attr->government->fontSize' => $this->attr['government']['fontSize']]);
                break;

            case "government.size":
                $this->cardFrame->update(['attr->government->size' => $this->attr['government']['size']]);
                break;

            case "government.x":
                $this->cardFrame->update(['attr->government->x' => $this->attr['government']['x']]);
                break;

            case "government.y":
                $this->cardFrame->update(['attr->government->y' => $this->attr['government']['y']]);
                break;

            // Ministry Attribute
            case "ministry.path":
                $this->cardFrame->update(['attr->ministry->path' => Str::after($this->attr['ministry']['path']->store(path: 'public/ministry'), 'public/')]);
                $this->redirect(route('sq.employee.design-card', ['printCardFrame' => $this->cardFrame]), true);
                break;

            case "ministry.title":
                $this->cardFrame->update(['attr->ministry->title' => $this->attr['ministry']['title']]);
                break;
            case "ministry.fontSize":
                $this->cardFrame->update(['attr->ministry->fontSize' => $this->attr['ministry']['fontSize']]);
                break;
            case "ministry.size":
                $this->cardFrame->update(['attr->ministry->size' => $this->attr['ministry']['size']]);
                break;
            case "ministry.x":
                $this->cardFrame->update(['attr->ministry->x' => $this->attr['ministry']['x']]);
                break;
            case "ministry.y":
                $this->cardFrame->update(['attr->ministry->y' => $this->attr['ministry']['y']]);
                break;
            // Profile
            case "profile.path":
                $this->cardFrame->update(['attr->profile->path' => Str::after($this->attr['profile']['path']->store(path: 'public/profile'), 'public/')]);
                break;
            case "profile.title":
                $this->cardFrame->update(['attr->profile->title' => $this->attr['profile']['title']]);
                break;
            case "profile.size":
                $this->cardFrame->update(['attr->profile->size' => $this->attr['profile']['size']]);
                break;
            case "profile.x":
                $this->cardFrame->update(['attr->profile->x' => $this->attr['profile']['x']]);
                break;
            case "profile.y":
                $this->cardFrame->update(['attr->profile->y' => $this->attr['profile']['y']]);
                break;
            // QrCode
            case "qrcode.size":
                $this->cardFrame->update(['attr->qrcode->size' => $this->attr['qrcode']['size']]);
                $this->redirect(route('sq.employee.design-card', ['printCardFrame' => $this->cardFrame]), true);
                break;
            case "qrcode.x":
                $this->cardFrame->update(['attr->qrcode->x' => $this->attr['qrcode']['x']]);
                break;
            case "qrcode.y":
                $this->cardFrame->update(['attr->qrcode->y' => $this->attr['qrcode']['y']]);
                break;
            case "header.backgroundColor":
                $this->cardFrame->update(['attr->header->backgroundColor' => $this->attr['header']['backgroundColor']]);
                break;
            case "content.fontColor":
                $this->cardFrame->update(['attr->content->fontColor' => $this->attr['content']['fontColor']]);
                break;
        }

    }
    public function updatedDetails($value)
    {
        $this->cardFrame->update(['details' => $value]);
    }
    public function updatedRemark($value)
    {
        $this->cardFrame->update(['remark' => $value]);
    }
    public function render()
    {
        return view('sqcard::livewire.guest.card-design');
    }
}
