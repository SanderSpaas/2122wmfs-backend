<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alias',
        'game_id',
        'user_id',
        'kills',
        'dead',
        'won',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function hitman()
    {
        return $this->belongsTo(Player::class,'id');
    }
    public function target()
    {
        return $this->hasMany(Player::class, 'id');
    }
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id');
    }
}
