<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class UserChartWidget extends ChartWidget
{
    protected ?string $heading = "Graph mensuel d'entree utilisateur";


    protected string $color = 'success';
    protected ?string $maxHeight = '700px';

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'animation' => [
                'duration' => 1000,
                'easing' => 'easeInQuad',
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],

            // 'scales'=> [
            //     'y'=> [
            //         'beginAtZero' => true,
            //     ],
            // ],


        ];
    }

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
