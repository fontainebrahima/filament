<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class TestStatWidget extends StatsOverviewWidget
{


    protected function getTrendData($model): array
    {
        $data = $model::selectRaw("DAY(created_at) as day, COUNT(*) as count")
            ->whereMonth("created_at", now()->month)
            ->whereYear("created_at", now()->year)
            ->groupBy("day")
            ->pluck("count", "day")
            ->toArray();

        return array_map(fn($day) => $data[$day] ?? 0, range(1, now()->daysInMonth));
    }

    protected function getStats(): array
    {
        return [
            Stat::make("Utilisateur(s)", User::count())
                ->description("Nombre total d'utilisateurs")
                ->descriptionIcon(Heroicon::User)
                ->chart(
                    $this->getTrendData(User::class)
                )->descriptionColor("success")
                 ->color("success"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            Stat::make("Product(s)", Product::count())
                ->description("Nombre total de produits")
                ->descriptionIcon(Heroicon::ShoppingBag)
                ->chart(
                    $this->getTrendData(Product::class)
                )->descriptionColor("warning")
                 ->color("warning"),

            Stat::make("Article(s)", Post::count())
                ->description("Nombre total d'articles")
                ->descriptionIcon(Heroicon::Newspaper)
                ->chart(
                    $this->getTrendData(Post::class)
                )->descriptionColor("info")
                 ->color("info"),
            
            Stat::make("Categorie(s)", Category::count())
                ->description("Nombre total de categories")
                ->descriptionIcon(Heroicon::Tag)
                ->chart(
                    $this->getTrendData(Category::class)
                )->descriptionColor("primary")
                ->color("primary")
        ];
    }
   

}
