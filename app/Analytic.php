<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function analyticType()
    {
        return $this->belongsTo(AnalyticType::class);
    }

}
