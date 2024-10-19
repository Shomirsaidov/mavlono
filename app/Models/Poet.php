<?php

namespace App\Models;

use App\Models\Poem;
use App\Models\View;
use App\Models\Subscription;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'avatar', 'lifetime', 'bio'];

    public function poems()
    {
        return $this->hasMany(Poem::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    
}
