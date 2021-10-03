<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolCuriculumn extends Model
{
    use HasFactory;

    protected $fillable = ['curriculumn_name', 'school_id'];

    protected $dates = [];

    /**
     * Get the school that owns the SchoolCuriculumn
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
