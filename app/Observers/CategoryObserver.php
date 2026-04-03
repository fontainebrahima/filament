<?php

namespace App\Observers;

use App\Models\Category;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        /** @var \App\Models\User|null $recipient */
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Catégorie créée")
                ->body("Une catégorie a été créée avec succes")
                ->success()
                ->icon(Heroicon::CheckCircle)
                ->actions([
                    Action::make('view','markAsUnread')
                        ->button()
                        ->markAsRead()
                        ->markAsUnread(),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
               /** @var \App\Models\User|null $recipient */
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Catégorie modifiée")
                ->body("Une catégorie a été modifiée avec succes")
                ->info()
                ->icon(Heroicon::CheckBadge)
                ->actions([
                    Action::make('view','markAsUnread')
                        ->button()
                        ->markAsRead()
                        ->markAsUnread(),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Catégorie supprimée")
                ->body("Une catégorie a été supprimée avec succes")
                ->danger()
                ->icon(Heroicon::CheckBadge)
                ->actions([
                    Action::make('view','markAsUnread')
                        ->button()
                        ->markAsRead()
                        ->markAsUnread(),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
