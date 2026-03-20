<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Symfony\Component\Console\Color;
use Tiptap\Marks\Bold;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make("tabs")
                    ->tabs([
                        Tab::make("Informations du produit")
                            ->icon(Heroicon::ShoppingBag)
                            // ->inlineLabel()
                            ->schema([
                                TextEntry::make("id")
                                    ->label("Identifiant:")
                                    ->weight("bold")
                                    ->color("primary"),
                                TextEntry::make("name")
                                    ->label("Nom du produit:")
                                    ->weight("bold")
                                    ->color("primary"),
                                    // ->inlineLabel(),
                                TextEntry::make("sku")
                                    ->label("Reference:")
                                    ->weight("bold")
                                    ->badge()
                                    ->color("success"),
                                TextEntry::make("description")
                                    ->label("Description:")
                                    ->weight("bold")
                                    ->color("info")
                                    ->markdown()->size('200px'),
                                TextEntry::make("created_at")
                                    ->label("Date de creation:")
                                    ->weight("bold")
                                    ->color("info")
                                    ->badge()
                                    ->icon(Heroicon::Calendar)
                                    ->date("d/m/Y"), 
                            ]),

                        Tab::make("Prix et Stock")
                            ->icon(Heroicon::CurrencyDollar)
                            // ->badge(Product::count())
                            ->badge(10)
                            ->badgeColor("danger")
                            ->schema([
                                TextEntry::make("price")
                                    ->label("Prix du produit:")
                                    ->weight("bold")
                                    ->icon(Heroicon::CurrencyDollar)
                                    ->color("primary"),
                                TextEntry::make("stock")
                                    ->label("Stock disponible:")
                                    ->weight("bold")
                                    ->color("primary"),
                            ]), 

                        Tab::make("Media et Status")
                            ->icon(Heroicon::Photo)
                            ->schema([
                                ImageEntry::make("image")
                                    ->label("Image du produit:")
                                    ->disk("public"),
                                // IconEntry::make("is_active")
                                //     ->label("Produit actif ?")
                                //     ->boolean(),
                                TextEntry::make("is_active")
                                    ->label("Produit actif ?")
                                    ->badge()
                                    ->weight("bold")
                                    ->formatStateUsing(fn(bool $state):string => $state ? 'oui' : 'non')
                                    ->icon(fn(bool $state) => $state ? Heroicon::OutlinedCheckCircle : Heroicon::OutlinedXCircle)
                                    ->color(fn(bool $state):string => $state ? 'success' : 'danger'),
                                    // IconEntry::make("is_featured")  
                                    //     ->label("Produit à la une ?")
                                    //     ->boolean()
                                    //     ->trueIcon(Heroicon::OutlinedCheckCircle)
                                    //     ->falseIcon(Heroicon::OutlinedClock)
                                    //     ->trueColor("success")
                                    //     ->falseColor("primary"),
                                TextEntry::make("is_featured")
                                    ->label("Is featured ?")
                                    ->badge()
                                    ->formatStateUsing(fn(bool $state):string => $state ? 'feature' : 'pending')
                                    ->icon(fn(bool $state) => $state ? Heroicon::OutlinedCheckCircle : Heroicon::OutlinedClock)
                                    ->color(fn(bool $state):string => $state ? 'success' : 'primary'),


                            ])

                        ])->columnSpanFull(),
                        //    ->vertical(),

                // mise en sections
                // Section::make("Informations du produit")
                // ->inlineLabel()
                // ->schema([
                //     TextEntry::make("id")
                //         ->label("Identifiant:")
                //         ->weight("bold")
                //         ->color("primary"),
                //     TextEntry::make("name")
                //         ->label("Nom du produit:")
                //         ->weight("bold")
                //         ->color("primary"),
                //         // ->inlineLabel(),
                //     TextEntry::make("sku")
                //         ->label("Reference:")
                //         ->weight("bold")
                //         ->badge()
                //         ->color("success"),
                //     TextEntry::make("description")
                //         ->label("Description:")
                //         ->weight("bold")
                //         ->color("primary"),
                //     TextEntry::make("created_at")
                //         ->label("Date de creation:")
                //         ->weight("bold")
                //         ->color("info")
                //         ->badge()
                //         ->icon(Heroicon::Calendar)
                //         ->date("d/m/Y"),  
                // ])->columnSpanFull(),

                // Section::make("Prix et Stock")
                // ->schema([
                //     TextEntry::make("price")
                //         ->label("Prix du produit:")
                //         ->weight("bold")
                //         ->icon(Heroicon::CurrencyDollar)
                //         ->color("primary"),
                //     TextEntry::make("stock")
                //         ->label("Stock disponible:")
                //         ->weight("bold")
                //         ->color("primary"),
                // ])->columnSpanFull(),

                // Section::make("Media et Status")
                // ->schema([
                //     ImageEntry::make("image")
                //         ->label("Image du produit:")
                //         ->disk("public"),
                //     IconEntry::make("is_active")
                //         ->label("Produit actif ?")
                //         ->boolean(),
                //     IconEntry::make("is_featured")  
                //         ->label("Produit à la une ?")
                //         ->boolean(),
                // ])->columnSpanFull()
            ]);
    }
}
