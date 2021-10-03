<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SdqQuestionOption extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the sdqQuestion that owns the SdqQuestionOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sdqQuestion()
    {
        return $this->belongsTo(SdqQuestion::class);
    }
}
