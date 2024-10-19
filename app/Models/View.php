<?php

namespace App\Models;

use App\Models\User;
use App\Models\Poem;
use App\Models\Poet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'poem_id',
        'poet_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poem()
    {
        return $this->belongsTo(Poem::class);
    }

    public function poet()
    {
        return $this->belongsTo(Poet::class);
    }


}
