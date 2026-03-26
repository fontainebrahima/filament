<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Schema $schema): Schema
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                ImageColumn::make("image")
                    ->disk("public")
                    ->circular()
                    ->imageSize(30),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->searchable()
                    ->weight("bold")
                    ->color("info")
                    ->badge()
                    ->icon(Heroicon::Calendar)
                    ->date("d/m/Y H:m:s")
                    ->toggleable(),
                TextColumn::make('tags')
                    ->searchable()
                    ->color("warning")
                    ->badge()
                    ->icon(Heroicon::Tag)
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
