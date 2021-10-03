<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolExtracurricular extends Model
{
    use HasFactory;

    protected $fillable = ['extracurricular_name', 'school_id'];

    protected $dates = [];

    /**
     * Get the school that owns the SchoolExtracurricular
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
