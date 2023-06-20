<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    // Vrienden verzoek sturen functie
    public function sendFriendRequest(User $receiver)
    {
        $sender = Auth::user();

        // Checken of de vrienden verzoek al gestuurd is
        if (FriendRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->exists()) {
            return redirect()->back()->with('error', 'Vriendschapsverzoek al verstuurd.');
        }

        // Vriendschapsverzoek aanmaken
        FriendRequest::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Vriendschapsverzoek verzonden.');
    }
    // Vriendschapsverzoek accepteren functie
    public function acceptFriendRequest(User $sender)
{
    $receiver = Auth::user();

    // Vriendschapsverzoek vinden via where
    $friendRequest = FriendRequest::where('sender_id', $sender->id)
        ->where('receiver_id', $receiver->id)
        ->first();

    // Vriendschapsverzoek status in de database updaten naar geaccepteerd "accepted"
    $friendRequest->update(['status' => 'accepted']);

    // Stuur een vriendschapsverzoek naar de verzender
    FriendRequest::create([
        'sender_id' => $receiver->id,
        'receiver_id' => $sender->id,
        'status' => 'accepted',
    ]);

    return redirect()->route('home')->with('success', 'Vriendschapsverzoek geaccepteerd.');
}


// Vriendschapsverzoek weigeren/verwijderen functie
public function rejectFriendRequest(User $sender)
{
    $receiver = Auth::user();

    // Vriendschapsverzoek vinden
    $friendRequest = FriendRequest::where(function ($query) use ($sender, $receiver) {
            $query->where('sender_id', $sender->id)
                ->where('receiver_id', $receiver->id);
        })
        ->orWhere(function ($query) use ($sender, $receiver) {
            $query->where('sender_id', $receiver->id)
                ->where('receiver_id', $sender->id);
        })
        ->first();

    if (!$friendRequest) {
        return redirect()->back()->with('error', 'Vriendschapsverzoek niet gevonden.');
    }

    // Vriendschap verwijderen tussen beide users
    $receiver->friends()->detach($sender->id);
    $sender->friends()->detach($receiver->id);

    // Vriendschapsverzoek verwijderen uit collectie
    $receiver->receivedFriendRequests()->where('sender_id', $sender->id)->delete();

    // Vriendschapsverzoek verwijderen uit collectie van de verzender
    $sender->receivedFriendRequests()->where('sender_id', $receiver->id)->delete();

    return redirect()->back()->with('success', 'Vriendschap verwijderd.');
}





    
}
