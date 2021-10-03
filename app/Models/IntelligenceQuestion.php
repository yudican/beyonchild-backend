<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntelligenceQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question_name', 'question_score', 'smart_category_id'];

    protected $dates = [];

    /**
     * Get the smartCategory that owns the IntelligenceQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function smartCategory()
    {
        return $this->belongsTo(SmartCategory::class);
    }
}
