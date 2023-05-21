<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Lobby extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
    
    
    
}
