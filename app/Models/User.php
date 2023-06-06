<?php namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\FriendRequest;
use App\Models\Lobby;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasReceivedFriendRequest()
    {
        
        return $this->receivedFriendRequests()->exists();
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    public function hasSentFriendRequest()
    {
        return $this->sentFriendRequests()->exists();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }


    public function acceptedFriends()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'receiver_id', 'sender_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }
    

    public function isFriend(User $user)
    {
        return $this->friends->contains($user);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }
    

    public function lobbies()
    {
        return $this->belongsToMany(Lobby::class);
    }

    public function hasAcceptedFriendRequest()
    {
        return $this->friends()->wherePivot('status', 'accepted')->exists();
    }

    public function isFriendWith(User $user)
    {
        return $this->friends()->where('users.id', $user->id)->exists();
    }    
    
}
