<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //	id	name	start_time	end_time	murder_method
    use HasFactory;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'murder_method',
    ];
    public function players()
    {
        return $this->hasMany(Player::class);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
