<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function sendFriendRequest(User $receiver)
    {
        $sender = Auth::user();

        // Check if the friend request already exists
        if (FriendRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->exists()) {
            return redirect()->back()->with('error', 'Friend request already sent.');
        }

        // Create the friend request
        FriendRequest::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Friend request sent successfully.');
    }

    public function acceptFriendRequest(User $sender)
{
    $receiver = Auth::user();

    // Find the friend request
    $friendRequest = FriendRequest::where('sender_id', $sender->id)
        ->where('receiver_id', $receiver->id)
        ->first();

    // Update the friend request status to accepted
    $friendRequest->update(['status' => 'accepted']);

    // Create a reciprocal friend request
    FriendRequest::create([
        'sender_id' => $receiver->id,
        'receiver_id' => $sender->id,
        'status' => 'accepted',
    ]);

    return redirect()->route('home')->with('success', 'Friend request accepted.');
}

    
public function rejectFriendRequest(User $sender)
{
    $receiver = Auth::user();

    // Find the friend request
    $friendRequest = FriendRequest::where('sender_id', $sender->id)
        ->where('receiver_id', $receiver->id)
        ->first();

    if (!$friendRequest) {
        return redirect()->back()->with('error', 'Friend request not found.');
    }

    // Update the friend request status to rejected
    $friendRequest->update(['status' => 'rejected']);

    // Remove the friend request from the collection
    $receiver->receivedFriendRequests()->where('sender_id', $sender->id)->delete();

    return redirect()->back()->with('success', 'Friend request rejected.');
}
    
}
