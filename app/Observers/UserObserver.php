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
        // Check if there's a valid user to send the notification to
        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->get();

        if ($adminUsers->count() > 0) {
            Notification::make()
                ->title('New user registered')
                ->body('User ' . $user->name . ' has registered')
                ->sendToDatabase($adminUsers);
        }
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
