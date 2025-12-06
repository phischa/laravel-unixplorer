<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    /**
     * Get the university this application belongs to.
     */
    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
