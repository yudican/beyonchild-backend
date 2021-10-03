<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SdqQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question_name', 'question_description'];

    protected $dates = [];

    /**
     * Get all of the sdqQuestion for the SdqQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sdqQuestionOption()
    {
        return $this->hasMany(SdqQuestionOption::class);
    }
}
