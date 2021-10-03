<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = ['event_category_name', 'event_category_type', 'event_is_paid', 'event_discount'];

    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'pivot'];

    /**
     * The events that belong to the EventCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'category_event', 'event_category_id', 'event_id');
    }
}
