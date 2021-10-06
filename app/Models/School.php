<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [];

    /**
     * Get the location that owns the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(SchoolLocation::class, 'school_location_id');
    }
    /**
     * Get the level that owns the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    /**
     * The facilities that belong to the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    /**
     * Get all of the curriculumns for the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function curriculumns()
    {
        return $this->hasMany(SchoolCuriculumn::class);
    }

    /**
     * Get all of the extracuriculars for the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extracuriculars()
    {
        return $this->hasMany(SchoolExtracurricular::class);
    }

    /**
     * Get the user that owns the Mentor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the mentors for the School
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentors()
    {
        return $this->hasMany(Mentor::class);
    }
}
