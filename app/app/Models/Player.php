<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kills',
        'dead',
        'won',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function hitman()
    {
        return $this->belongsTo(Player::class);
    }
    public function target()
    {
        return $this->hasMany(Player::class);
    }
}
