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
        'killer_id',
        'kills',
        'dead',
        'won',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function killer()
    {
        return $this->belongsTo(Player::class,'killer_id');
    }
    public function target()
    {
        return $this->belongsTo(Player::class, 'target_id');
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
