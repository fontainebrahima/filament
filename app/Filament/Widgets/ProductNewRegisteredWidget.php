<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter as FiltersFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use SebastianBergmann\CodeCoverage\Filter;

class ProductNewRegisteredWidget extends TableWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = "sm";
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Product::query())
            ->columns([
                ImageColumn::make("image")->disk("public")->imageSize(30)->circular()->toggleable(),
                TextColumn::make("name")->sortable()->searchable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("sku")->sortable()->badge()->color("primary")->searchable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("price")->sortable()->toggleable(isToggledHiddenByDefault: true)->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("stock")->toggleable()->extraAttributes(['class'=>'py-1 text-sm']),
                IconColumn::make("is_active")->sortable()->boolean()->toggleable(isToggledHiddenByDefault:true)->extraAttributes(['class'=>'py-1 text-sm']),
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
            //->striped()

            ->filters([
                FiltersFilter::make('created_at')
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
            ->headerActions([
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
