<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Poem;

class Vocab extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'poem_id',
        'word',
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
