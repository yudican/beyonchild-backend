<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['facility_name', 'facility_icon'];

    protected $dates = [];

    /**
     * The schools that belong to the Facility
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schools()
    {
        return $this->belongsToMany(School::class);
    }
}
