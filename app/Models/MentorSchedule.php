<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_title', 'schedule_date', 'schedule_time_start', 'schedule_time_end', 'mentor_id'];

    protected $dates = [];

    /**
     * Get the mentor that owns the MentorSchedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
