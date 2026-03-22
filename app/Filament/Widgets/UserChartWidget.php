<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class UserChartWidget extends ChartWidget
{
    protected ?string $heading = "Graph mensuel d'entree utilisateur";

    //protected ?string $maxHeight = '270px';
    protected string $color = 'success';

    protected function getData(): array
    {

        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Graphique des utilisateurs',
                    'data' => $data->map(fn($value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn($value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
        //return 'bar';
    }
}
