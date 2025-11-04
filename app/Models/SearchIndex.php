<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchIndex extends Model
{

    protected $table = 'search_index';

    protected $primaryKey = 'item_id';

    public $incrementing = false;


    protected $keyType = 'int';
    // protected $table = 'search_index';
    protected $fillable = [
        'item_type',
        'item_id',
        'category_slug',
        'title'
    ];
}
