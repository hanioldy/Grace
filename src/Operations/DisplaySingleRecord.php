<?php

namespace Hani221b\Grace\Operations;

use Hani221b\Grace\Support\Response;

class DisplaySingleRecord
{
    /**
     * This function displays a listing of records that belong to certain model in default language
     * @param array $records
     * @param string $model_path
     * @return \Illuminate\Http\JsonResponse
     */

    public static function display($records, $model_path, $resource_path)
    {
        $table_name = $records;
        $records = $model_path::Selection()->DefaultLanguage()
            ->with('translations')->first();

        if (config('grace.mode') === 'api') {
            return Response::successResponse(new $resource_path($records), 'Data passed successfully', 200);
        } else if (config('grace.mode') === 'blade') {
            return view(config('grace.views_folder_name') . "." . $table_name . '.index')->with([$table_name => $records]);
        }
    }
}
