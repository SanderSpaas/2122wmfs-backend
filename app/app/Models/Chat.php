<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'send_at',
        'game_id',
        'player_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'send_at-' => 'datetime',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
    public function games()
    {
        return $this->belongsTo(Game::class);
    }
}
