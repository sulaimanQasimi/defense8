<?php

namespace App\Livewire\Setting;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class LanguageAutomization extends Component
{

    public $file;
    public $words;
    public $lang;
    public $keywords;

    public function mount()
    {
        $this->keywords = collect(json_decode(File::get(lang_path('vendor/nova/fa.json'))));
// dd($this->keywords);
        foreach ($this->keywords as $key => $keyword) {
            $this->words[$key] = $keyword;
            $this->lang[$key] = $keyword;
        }
    }

    public function updated($name, $value)
    {
        $this->keywords->put(str_replace('lang.', '', $name), $value);
        File::put(lang_path('vendor/nova/fa.json'), $this->keywords->toJson(JSON_UNESCAPED_UNICODE));

    }

    public function render()
    {
        return view('livewire.setting.language-automization');
    }
}
