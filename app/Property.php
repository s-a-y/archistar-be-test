<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Property extends Model
{
    static $rules = [
        'suburb' => 'required|max:255',
        'state' => 'required|max:255',
        'country' => 'required|max:255'
    ];

    protected $fillable = [
        'guid',
        'suburb',
        'state',
        'country',
    ];

    protected $hidden = [
        'id',
    ];

    public static function boot()
    {
        parent::boot();

        // generating uuid in case it hasn't been passed from API client when creating property
        static::creating(function ($property) {
            if (!$property->guid) {
                $property->guid = Uuid::uuid4()->toString();
            }
        });

        static::created(function ($property) {
            Analytic::bustCache($property);
        });

        static::updated(function ($property) {
            Analytic::bustCache($property);
        });
    }

    public function analytics()
    {
        return $this->hasMany(Analytic::class);
    }
}
