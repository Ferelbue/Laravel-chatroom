<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_id',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }
    public function users()
    {
        return $this->belongsToMany(User::class , 'room_user', 'room_id', 'user_id');
    }
    public function game()
    {
        return $this->belongsTo(Game::class , 'game_id', 'id', 'games');
    }   
}
