<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;

class PostsTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")
                ->label("ID")
                ->toggleable(true),
                ImageColumn::make("image")->disk("public")->circular()->imageSize(30)->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make("title")->sortable()->searchable()->toggleable(),
                TextColumn::make("slug")->sortable()->searchable()->toggleable(),
                TextColumn::make("category.name")->sortable()->searchable()->toggleable()->badge()->color("danger"),
                ColorColumn::make("color")->sortable()->toggleable(isToggledHiddenByDefault: true),
                // textColumn::make("created_at")
                //         ->label("Created at")
                //         ->dateTime("d/m/Y H:i:s")
                //         ->sortable()
                //         ->searchable(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->label("Date de creation")
                    ->weight("bold")
                    ->color("info")
                    ->badge()
                    ->icon(Heroicon::Calendar)
                    ->date("d/m/Y H:m:s")
                    ->toggleable(),
                TextColumn::make("tags")
                    ->label("Tags")
                    ->badge()
                    ->color("warning")
                    ->icon(Heroicon::Tag)
                    ->toggleable(true),
                IconColumn::make("published")
                    ->label("Published")->toggleable(isToggledHiddenByDefault: true),


            ])
            ->defaultSort("title", "asc")
            ->striped()
            ->extraAttributes(['class'=>'py-1 text-sm'])
            ->deferLoading()
            ->filters([
                Filter::make("created_at")
                    ->label("date de creation")
                    ->schema([
                        DatePicker::make("created_at")
                        ->label("select date")
                    ])
                    ->query(function($query,$data){
                        return $query
                            ->When($data["created_at"], function($q, $date){
                                $q->whereDate("created_at", $date);
                            });
                    }),
                    SelectFilter::make("category_id")
                        ->label("select Categorie")
                        ->relationship("category","name")
                        ->preload(),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                ViewAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
