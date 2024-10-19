<?php

namespace App\Models;

use App\Models\User;
use App\Models\Poem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    public $timestamps = false;

    use HasFactory;
    protected $fillable = [
        'user_id',
        'poem_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poem()
    {
        return $this->belongsTo(Poem::class);
    }
}
