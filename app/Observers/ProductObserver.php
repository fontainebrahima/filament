<?php

namespace App\Observers;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        /** @var \App\Models\User|null $recipient */
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Produit créé")
                ->body("Un produit a été créé avec succes")
                ->success()
                ->icon(Heroicon::ShoppingBag)
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
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        /** @var \App\Models\User|null $recipient */
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Produit modifie")
                ->body("Un produit a été modifié avec succes")
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
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        /** @var \App\Models\User|null $recipient */
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Produit supprimé")
                ->body("Un produit a été supprimé avec succes")
                ->danger()
                ->icon(Heroicon::Trash)
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
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
