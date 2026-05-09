<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'game_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
