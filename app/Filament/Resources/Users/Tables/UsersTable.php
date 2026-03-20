<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Split;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    ImageColumn::make('image')
                        ->getStateUsing(fn ($record)=>'https://ui-avatars.com/api/?name='.urlencode($record->name) .'&background=random')
                        ->circular()
                        ->grow(false), 
                    TextColumn::make("name")->weight('bold'),
                    TextColumn::make("email")->color('gray'),
                    TextColumn::make("created_at")
                
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionsEditAction::make(),
            ])
            ->toolbarActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make(),
                ]),
            ]);
    }
}

