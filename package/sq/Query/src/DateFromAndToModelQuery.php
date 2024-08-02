<?php
namespace Sq\Query;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DateFromAndToModelQuery
{
    public $start = null;
    public $end = null;
    public function __construct(private $model, private $column)
    {
        $this->date();
    }
    public function query()
    {

        $query = $this->model::when(
            ($this->start != null && $this->end != null),
            function ($query) {
                return $query->whereBetween($this->column, [Carbon::parse($this->start)->startOfDay(), Carbon::parse($this->end)->endOfDay()]);
            }
        )
            ->when(($this->start && $this->end == null), function ($query) {
                return $query->whereDate($this->column, Carbon::parse($this->start)->startOfDay());
            });
        return $query;
    }

    private function date(): void
    {
        if (request()->has('date')) {
            if (request()->input('date') != null && request()->input('date') != '' && request()->input('date') != 'null') {
                $date = explode(',', request()->input('date'));

                if (Arr::hasAny($date, 0)) {
                    $this->start = Verta::parse(Str::before(request()->input('date'), ','))->toCarbon();
                }

                if (Arr::hasAny($date, 1)) {
                    $this->end = Verta::parse(Str::after(request()->input('date'), ','))->toCarbon();
                }
            }
        }
    }
}
