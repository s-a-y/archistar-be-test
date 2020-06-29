<?php

namespace App\Http\Controllers\API;

use App\Analytic;
use App\Http\Controllers\Controller;
use App\Property;
use Illuminate\Http\Request;

/**
 * Controller for property analytics
 * @package App\Http\Controllers\API
 */
class AnalyticsController extends Controller
{
    /**
     * Creates new analytic for the property
     * @param Request $request
     * @param Property $property
     * @return \App\Http\Resources\Analytic
     */
    public function store(Request $request, Property $property)
    {
        $request->validate(Analytic::$rules);

        $analytic = new Analytic($request->all());
        $analytic->property()->associate($property);
        $analytic->save();
        return new \App\Http\Resources\Analytic($analytic);
    }

    /**
     * Updates analytic for the property
     * @param Request $request
     * @param Property $property
     * @param Analytic $analytic
     * @return \App\Http\Resources\Analytic
     */
    public function update(Request $request, Property $property, Analytic $analytic)
    {
        $request->validate(Analytic::$rules);

        $analytic->property()->associate($property);
        $analytic->analytic_type_id = $request->get('analytic_type_id');
        $analytic->value = $request->get('value');
        $analytic->save();
        return new \App\Http\Resources\Analytic($analytic);
    }

    /**
     * Lists all analytics for the property
     * @param Request $request
     * @param Property $property
     * @return \App\Http\Resources\AnalyticCollection
     */
    public function index(Request $request, Property $property)
    {
        return new \App\Http\Resources\AnalyticCollection(
            // added related objects to make sure it's easier to work with, can be optimized
            $property->analytics()->with(['property', 'analyticType'])->getResults()
        );
    }
}
