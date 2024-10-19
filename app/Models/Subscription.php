<?php

namespace App\Models;

use App\Models\User;
use App\Models\Poet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    public $timestamps = false;

    use HasFactory;
    protected $fillable = [
        'poet_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poet()
    {
        return $this->belongsTo(Poet::class);
    }
}
