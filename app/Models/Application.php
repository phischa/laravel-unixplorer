<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a student application to a university.
 */
class Application extends Model
{
    protected $guarded = [];

    /**
     * Get the university this application belongs to.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}
