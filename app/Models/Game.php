<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games'; // Replace 'games' with your actual table name
    
    protected $fillable = ['word'];
    
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
