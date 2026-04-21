<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            
            ->columns([
                TextColumn::make("name")->searchable()->sortable()->toggleable(),
                TextColumn::make("slug")->searchable()->sortable()->toggleable(),
            ])->striped()
            ->reorderable()
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
                    SelectFilter::make("id")
                        ->label("select Categorie")
                        ->options(Category::all()->pluck("name", "id"))
                        ->preload(),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                ViewAction::make()->iconButton(),
                DeleteAction::make()->iconButton()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
