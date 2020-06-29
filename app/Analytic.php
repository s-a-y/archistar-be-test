<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Analytic extends Model
{
    protected $table = 'property_analytics';

    static $rules = [
        'analytic_type_id' => 'required|integer',
        'value' => 'required|max:255'
    ];

    protected $fillable = [
        'property_id',
        'analytic_type_id',
        'value',
    ];

    public static function cacheKey($key, $value) {
        return "analytics-summary-$key:$value";
    }

    public static function bustCache($property) {
        Cache::forget("analytics-summary-suburb:$property->suburb");
        Cache::forget("analytics-summary-state:$property->state");
        Cache::forget("analytics-summary-country:$property->country");
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($analytic) {
            static::bustCache($analytic->property()->first());
        });

        static::updated(function ($analytic) {
            static::bustCache($analytic->property()->first());
        });
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function analyticType()
    {
        return $this->belongsTo(AnalyticType::class);
    }

    public static function summary(array $filter)
    {
        return static::whereHas('property', function($q) use ($filter) {
            $q->where($filter);
        })
            ->select([
                DB::raw('analytic_type_id'),
                DB::raw('MAX(cast(value as double precision)) as max_value'),
                DB::raw('MIN(cast(value as double precision)) as min_value'),
                DB::raw('PERCENTILE_CONT(0.5) WITHIN GROUP (ORDER BY cast(value as double precision)) as median_value'),
                DB::raw('COUNT(distinct property_id) as properties_with_value'),
            ])
            ->groupBy('analytic_type_id')
            ->get();
    }
}
