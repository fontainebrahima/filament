<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class UserPieChartWidget extends ChartWidget
{
    protected ?string $heading = 'User Pie Chart Widget';

    protected ?string $maxHeight = '270px';

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
                    'backgroundColor' => ['red', 'green', 'blue', 'indigo'],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $data->map(fn($value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        //return 'pie';
        return 'doughnut';
        //return 'polarArea';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'cutout' => '60%',
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
