<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SummaryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $propertiesTotal = $this->additional['meta']['properties_total'];
        return [
            'data' => $this->collection->map(function($item) use ($propertiesTotal) {
                $percentage = $item->properties_with_value / $propertiesTotal * 100;

                return [
                    'analytic_type_id' => $item->analytic_type_id,
                    'max_value' => $item->max_value,
                    'min_value' => $item->min_value,
                    'median_value' => $item->median_value,
                    'properties_with_value' => number_format($percentage, 2),
                    'properties_without_value' => number_format(100 - $percentage,2),
                ];
            })
        ];

    }
}
