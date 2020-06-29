<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Property;
use Illuminate\Http\Request;

/**
 * Controller for properties resource
 * @package App\Http\Controllers\API
 */
class PropertiesController extends Controller
{
    /**
     * Stores property into the database
     * @param Request $request
     * @return \App\Http\Resources\Property
     */
    public function store(Request $request)
    {
        // pushed validation rules into the model itself, as they may be useful in multiple places
        $request->validate(Property::$rules);

        $property = new Property($request->all());
        $property->save();
        return (new \App\Http\Resources\Property($property));
    }
}
