<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['event_name', 'event_date', 'event_fee', 'event_banner', 'event_description', 'event_narasumber', 'event_benefit', 'event_note', 'event_start', 'event_end'];

    protected $dates = ['event_date'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['event_banner_url'];

    /**
     * The eventCategories that belong to the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function eventCategories()
    {
        return $this->belongsToMany(EventCategory::class, 'category_event', 'event_id', 'event_category_id');
    }

    public function getEventBannerUrlAttribute()
    {
        return asset('storage/' . $this->attributes['event_banner']);
    }
}
