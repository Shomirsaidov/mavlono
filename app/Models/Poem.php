<?php

namespace App\Models;

use App\Models\Poet;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\View;
use App\Models\Vocab;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poem extends Model
{
    use HasFactory;
    protected $fillable = ['poet_id', 'content','user_id','genre','tags'];

    public function poet()
    {
        return $this->belongsTo(Poet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function vocabulary()
    {
        return $this->hasMany(Vocab::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function views()
    {
        return $this->hasMany(View::class);
    }

}
