<?php

namespace Sq\Employee\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sq\Employee\Models\CardInfo;

class Attendance extends Component
{
    use WithPagination;

    #[Url]
    public $department;



    #[Url]
    public $employee;

    #[Url]
    public $date;


    public function mount()
    {


    }
    public function updated($name, $value): void
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('sqemployee::livewire.attendance', [
            'card_infos' => CardInfo::query()
                ->when($this->employee, fn($query) => $query->where("registare_no", $this->employee))
                ->when($this->department, fn($query) => $query->where("department_id", $this->department))
                ->paginate(),
        ]);
    }
}
