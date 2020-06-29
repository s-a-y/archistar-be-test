<?php

namespace App\Http\Controllers\API;

use App\Analytic;
use App\Http\Controllers\Controller;
use App\Http\Resources\SummaryCollection;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Returns aggregated analytics data
 * @package App\Http\Controllers\API
 */
class SummaryController extends Controller
{
    /**
     * Aggregated analytics data for a suburb, state or country
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $request->validate([
            'suburb' => 'max:255',
            'state' => 'max:255',
            'country' => 'max:255'
        ]);

        $filter = $request->all(['suburb', 'state', 'country']);
        $firstKey = array_key_first($filter);

        return Cache::rememberForever(
            Analytic::cacheKey($firstKey, $filter[$firstKey]),
            function() use ($filter) {
                $result = Analytic::summary($filter);
                return (new SummaryCollection($result))->additional([
                    'meta' => [
                        'properties_total' => Property::where($filter)->count()
                    ]
                ]);
            });
    }

}
