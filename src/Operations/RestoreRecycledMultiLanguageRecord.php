<?php

namespace Hani221b\Grace\Operations;

use Hani221b\Grace\Helpers\JsonResponse;

class RestoreRecycledMultiLanguageRecord
{
    /**
     * this function move multi language record to recycle bin.
     *
     * @param int $id
     * @param string $model_path
     * @return \Illuminate\Http\JsonResponse
     */

    public static function restore($id, $model_path, $table_name)
    {
        //fetch the requested record
        $requested_record = $model_path::withTrashed()->find($id);
        //return false if requested was not found
        if (!$requested_record) {
            return JsonResponse::errorResponse('The requested record does not exist', 404);
        }
        // FileHelper::UnlinkFile();
        $translations = $model_path::withTrashed()->where('translation_of', $requested_record->id)->get();

        $translations->each->restore();
        $requested_record->restore();
        if (config('grace.mode') === 'api') {
            return JsonResponse::successResponse([
                'Default Record' => $requested_record,
                'Translations' => $translations,
            ], 'The record has been restored successfully', 200);
        } else if (config('grace.mode') === 'blade') {
            return redirect('/' . $table_name);
        }
    }
}
