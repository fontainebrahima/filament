<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make("Informations")
                    ->description("Informations sur le post")
                    ->icon(Heroicon::RocketLaunch)
                    ->schema([
                        
                        Group::make()
                            ->schema([
                                TextInput::make("title")->rules("required|min:8"),
                                TextInput::make("slug")->unique()->validationMessages([
                                    "unique" => "Le slug existe deja",
                                    "min" => "Le slug doit contenir au moins 8 caracteres",
                                ])->rules("required|min:8"),
                                Select::make("category_id")
                                    ->label("Category")
                                    //->options(Category::all()->pluck("name", "id")),
                                    ->relationship("category","name")
                                    ->searchable()
                                    ->preload(),
                                ColorPicker::make("color"),
                            ])->columns(2),
                            MarkdownEditor::make("body"),
                    ])->columnSpan(2),

                        Group::make()
                            ->schema([
                                Section::make("Media")
                                    ->description("Image Upload")
                                    ->icon(Heroicon::Photo)
                                    ->schema([
                                        FileUpload::make("image")->disk("public")->directory("posts")
                                    ]),

                                Section::make("Meta Data")
                                    ->description(" Les champs de saisie Meta Data")
                                    ->icon(Heroicon::CircleStack)
                                    ->schema([
                                        TagsInput::make("tags"),
                                        Checkbox::make("published"),
                                        DatePicker::make("published_at"),
                                    ])
                            ])->columnSpan(1),

            ])->columns(3);

    }

}
