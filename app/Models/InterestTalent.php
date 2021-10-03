<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestTalent extends Model
{
    use HasFactory;

    protected $fillable = ['talent_name'];

    protected $dates = [];

    /**
     * The childrens that belong to the InterestTalent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childrens()
    {
        return $this->belongsToMany(Children::class, 'children_talent', 'children_id', 'interest_talent');
    }
}
