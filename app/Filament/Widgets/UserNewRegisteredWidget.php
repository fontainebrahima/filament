<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UserNewRegisteredWidget extends TableWidget
{
    protected static ?int $sort = 2;
    //protected ?string $maxHeigth = "270px";
    protected int|string|array $columnSpan = "";

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::query()->take(5))
            ->columns([
                ImageColumn::make('image')
                        ->getStateUsing(fn ($record)=>'https://ui-avatars.com/api/?name='.urlencode($record->name) .'&background=random')
                        ->circular()
                        ->grow(false)
                        ->toggledHiddenByDefault(true)
                        ->imageSize(30)
                        ->extraAttributes(['class'=>'py-1 text-sm']), 
                TextColumn::make("name")->weight('bold')->searchable()->toggleable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("email")->color('gray')->searchable()->toggleable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("created_at")->searchable()->toggleable()->extraAttributes(['class'=>'py-1 text-sm'])
            ])->defaultSort('created_at','desc')
                //->striped()

            ->filters([
                //
            ])
            ->headerActions([
                //
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
