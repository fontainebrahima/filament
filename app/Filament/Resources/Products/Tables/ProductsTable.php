<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class ProductsTable
{
    
    public static function configure(Table $table): Table
    {
        return $table
        ->deferLoading()
            ->columns([
                ImageColumn::make("image")->disk("public")->imageSize(30)->square()->toggleable(),
                TextColumn::make("name")->sortable()->searchable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("sku")->sortable()->badge()->color("primary")->searchable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("price")->sortable()->toggleable(isToggledHiddenByDefault: true)->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("stock")->toggleable()->extraAttributes(['class'=>'py-1 text-sm']),
                IconColumn::make("is_active")->sortable()->boolean()->toggleable(isToggledHiddenByDefault:true)->extraAttributes(['class'=>'py-1 text-sm']),
                // IconColumn::make("is_featured")
                //             ->boolean()
                //             ->trueIcon(Heroicon::OutlinedCheckCircle)
                //             ->falseIcon(Heroicon::OutlinedClock)
                //             ->trueColor("success")
                //             ->falseColor("primary")
                //             ,
                TextColumn::make("is_featured")
                        ->badge()
                        ->formatStateUsing(fn(bool $state):string =>$state ? "feature" : "Pending")
                        ->icon(fn(bool $state) => $state ? Heroicon::OutlinedCheckCircle : Heroicon::OutlinedClock)
                        ->color(fn(bool $state):string =>$state ? 'success' : 'primary')
                        ->toggleable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make('created_at')
                    ->sortable()
                    ->label("Date de creation")
                    ->weight("bold")
                    ->color("info")
                    ->badge()
                    ->icon(Heroicon::Calendar)
                    ->date("d/m/Y H:m:s")
                    ->toggleable()->extraAttributes(['class'=>'py-1 text-sm'])

                
            ])->defaultSort('created_at','desc')
                ->striped()
                


            ->filters([
                Filter::make('created_at')
                ->label('date de creation')
                ->schema([
                    DatePicker::make('created_at')
                    ->label("select date")
                ])
                ->query(function($query, $data){
                    return $query
                        ->when($data["created_at"], function($q, $date){
                            $q->whereDate("created_at", $date);
                        });
                })
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
