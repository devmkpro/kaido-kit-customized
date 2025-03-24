<?php

namespace App\Observers;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $recepient = Auth::user();
        Notification::make()
            ->title('User Created')
            ->body('A new user has been created: ' . $user->name)
            ->success()
            ->sendToDatabase($recepient);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $recepient = Auth::user();
        Notification::make()
            ->title('User Updated')
            ->body('User ' . $user->name . ' has been updated.')
            ->success()
            ->sendToDatabase($recepient);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $recepient = Auth::user();
        Notification::make()
            ->title('User Deleted')
            ->body('User ' . $user->name . ' has been deleted.')
            ->success()
            ->sendToDatabase($recepient);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $recepient = Auth::user();
        Notification::make()
            ->title('User Restored')
            ->body('User ' . $user->name . ' has been restored.')
            ->success()
            ->sendToDatabase($recepient);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $recepient = Auth::user();
        Notification::make()
            ->title('User Force Deleted')
            ->body('User ' . $user->name . ' has been force deleted.')
            ->success()
            ->sendToDatabase($recepient);
    }
}
