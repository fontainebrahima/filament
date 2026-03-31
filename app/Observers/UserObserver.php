<?php

namespace App\Observers;


use Filament\Notifications\Notification;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class UserObserver
{

    
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void       
    {
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Utilisateur créé")
                ->body("Un nouvel utilisateur a été créé avec succes")
                ->success()
                ->icon(Heroicon::UserPlus)
                ->actions([
                    Action::make('view','markAsUnread')
                        ->button()
                        ->markAsRead()
                        ->markAsUnread(),
                ])
                ->sendToDatabase($recipient);
        }
        // $recipient = auth()->user();

        // $recipient->notify(
        //     Notification::make()
        //         ->title('Utilisateur créé')
        //         ->body("Un nouvel utilisateur a été créé")
        //         ->success()
        //         ->toDatabase(),
        // );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Utilisateur modifié")
                ->body("Un utilisateur a été modifié avec succes")
                ->warning()
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
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $recipient = auth()->user();

        if ($recipient) {
            Notification::make()
                ->title("Utilisateur supprimé")
                ->body("Un utilisateur a été supprimé avec succes")
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
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
