<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCode extends Model
{
    protected $table = 'agent_code';
    protected $guarded = [];

    protected $casts = [
        'clients' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
