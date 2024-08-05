<?php
namespace Sq\Query;

use Hekmatinasser\Verta\Facades\Verta;
use Vehical\OilType;

class OilStatistics
{
    public $data = [];
    public function __get($name)
    {
        return $this->$name();
    }
    public function make(): array
    {
        $statistic = [
            "current_month" => [
                "import" => [
                    OilType::Diesel => $this->calculate(\Sq\Oil\Models\Oil::class, OilType::Diesel, [Verta::startMonth()->toCarbon(), Verta::endMonth()->toCarbon()], true),
                    OilType::Petrole => $this->calculate(\Sq\Oil\Models\Oil::class, OilType::Petrole, [Verta::startMonth()->toCarbon(), Verta::endMonth()->toCarbon()], true),
                ],
                "export" => [
                    OilType::Diesel => $this->calculate(\Sq\Oil\Models\OilDisterbution::class, OilType::Diesel, [Verta::startMonth()->toCarbon(), Verta::endMonth()->toCarbon()], true),
                    OilType::Petrole => $this->calculate(\Sq\Oil\Models\OilDisterbution::class, OilType::Petrole, [Verta::startMonth()->toCarbon(), Verta::endMonth()->toCarbon()], true)
                ],
                'remain' => [
                    OilType::Diesel => null,
                    OilType::Petrole => null,
                ]
            ],
            "past_month" =>
                [
                    "import" => [
                        OilType::Diesel => $this->calculate(\Sq\Oil\Models\Oil::class, OilType::Diesel, Verta::startMonth()->toCarbon(), false, '<'),
                        OilType::Petrole => $this->calculate(\Sq\Oil\Models\Oil::class, OilType::Petrole, Verta::startMonth()->toCarbon(), false, '<'),
                    ],
                    "export" => [
                        OilType::Diesel => $this->calculate(\Sq\Oil\Models\OilDisterbution::class, OilType::Diesel, Verta::startMonth()->toCarbon(), false, '<'),
                        OilType::Petrole => $this->calculate(\Sq\Oil\Models\OilDisterbution::class, OilType::Petrole, Verta::startMonth()->toCarbon(), false, '<')
                    ],
                    'remain' => [
                        OilType::Diesel => null,
                        OilType::Petrole => null,
                    ]
                ]
        ];

        $statistic['current_month']['remain'][OilType::Diesel] = $statistic['current_month']['import'][OilType::Diesel] - $statistic['current_month']['export'][OilType::Diesel];
        $statistic['current_month']['remain'][OilType::Petrole] = $statistic['current_month']['import'][OilType::Petrole] - $statistic['current_month']['export'][OilType::Petrole];

        $statistic['past_month']['remain'][OilType::Diesel] = $statistic['past_month']['import'][OilType::Diesel] - $statistic['past_month']['export'][OilType::Diesel];
        $statistic['past_month']['remain'][OilType::Petrole] = $statistic['past_month']['import'][OilType::Petrole] - $statistic['past_month']['export'][OilType::Petrole];
        return $statistic;
    }
    private function calculate($model, $oil_type, $date, bool $between = false, $oprator = "<"): int
    {
        $query = $model::query()
            ->where('oil_type', $oil_type);
        if ($between) {

            $query->whereBetween('filled_date', $date);
        } else {
            $query->where('filled_date', $oprator, $date);
        }

        return $query->sum('oil_amount');
    }
}
