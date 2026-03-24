<?php

namespace App\Filament\Widgets;

use App\Models\Post;
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
use Illuminate\Database\Eloquent\Relations\Relation;

class UserNewRegisteredWidget extends TableWidget
{
    protected static ?int $sort = 2;
    //protected ?string $maxHeigth = "270px";
    protected int|string|array $columnSpan = "";

    protected function getTableQuery(): Builder|Relation|null
    {
        return User::query()
        ->latest()
        ->limit(5);
    }

    public function table(Table $table): Table
    {
        return $table
            //->query(fn (): Builder => User::query()->latest()->take('5'))
            ->columns([
                ImageColumn::make('image')
                        ->getStateUsing(fn ($record)=>'https://ui-avatars.com/api/?name='.urlencode($record->name) .'&background=random')
                        ->circular()
                        ->grow(false)
                        ->toggledHiddenByDefault(true)
                        ->imageSize(40)
                        ->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("name")->weight('bold')->searchable()->toggleable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("email")->color('gray')->searchable()->toggleable()->extraAttributes(['class'=>'py-1 text-sm']),
                TextColumn::make("created_at")->searchable()
                                            ->toggleable()
                                            ->extraAttributes(['class'=>'py-1 text-sm'])
                                            ->label("Date de creation")
                                            ->weight("bold")
                                            ->color("danger")
                                            ->badge()
                                            ->icon(Heroicon::Calendar)
                                            ->date("d/m/Y H:m:s")
            ])->defaultSort('created_at','desc')
            //->paginated(5)
            ->striped()

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
