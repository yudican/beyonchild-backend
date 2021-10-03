<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'category_description', 'category_icon'];

    protected $dates = [];

    /**
     * Get all of the multipleIntelegences for the SmartCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multipleIntelegences()
    {
        return $this->hasMany(IntelligenceQuestion::class);
    }
}
