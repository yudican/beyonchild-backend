<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the user that owns the Children
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * The talents that belong to the Children
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function talents()
    {
        return $this->belongsToMany(InterestTalent::class, 'children_talent', 'interest_talent', 'children_id');
    }
}
