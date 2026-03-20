<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make("INFORMATIONS PRODUIT")
                        ->description("Veuillez remplir les champs suivants")
                        ->icon(Heroicon::ShoppingBag)
                        ->schema([
                            Group::make()
                                ->schema([
                                    TextInput::make("name")->required(),
                                    TextInput::make("sku")->disabled()->dehydrated(false),
                                ])->columns(2),
                            MarkdownEditor::make("description"),
                        ]),

                    Step::make("PRIX & STOCK")
                        ->description("Insertion du prix et du stock")
                        ->icon(Heroicon::CurrencyDollar)
                        ->schema([
                            Group::make()
                                ->schema([
                                    TextInput::make("price"),
                                    TextInput::make("stock"),
                                ])->columns(2),
                        ]),

                    Step::make("MEDIA & STATUS")
                        ->icon(Heroicon::Photo)
                        ->description("Image et statuts obligatoires")
                        ->schema([
                            Group::make()
                                ->schema([
                                    FileUpload::make("image")->disk("public")->directory("products"),
                                    Checkbox::make("is_active"),
                                    Checkbox::make("is_featured"),
                                ])
                        ]),


                ])
                ->columnSpanFull()
                ->skippable()
                ->submitAction(
                    Action::make("save")
                    ->label("Enregistrer")
                    ->icon(Heroicon::InboxArrowDown)
                    ->button()
                    ->color("primary")
                    ->submit("save")
                    // ->extraAttributes([
                    //     "class" => "bg-blue-500 hover:bg-blue-600 text-white",
                    // ])
                )
            ]);
    }
}
