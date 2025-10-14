<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //

    protected $table = 'favorite';

    protected $fillable = ['user_id', 'ad_id', 'category_slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function ad()
    {
        return $this->morphTo();
    }

}
