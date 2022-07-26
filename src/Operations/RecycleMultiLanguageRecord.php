<?php

namespace Hani221b\Grace\Operations;

use Hani221b\Grace\Helpers\JsonResponse;

class RecycleMultiLanguageRecord
{
    /**
     * this function move multi language record to recycle bin.
     *
     * @param int $id
     * @param string $model_path
     * @return \Illuminate\Http\JsonResponse
     */

    public static function recycle($id, $model_path, $table_name)
    {
        //fetch the requested record
        $requested_record = $model_path::find($id);
        //return false if requested was not found
        if (!$requested_record) {
            return JsonResponse::errorResponse('The requested record does not exist', 404);
        }
        // FileHelper::UnlinkFile();
        $translations = $model_path::where('translation_of', $requested_record->id)->get();

        $translations->each->delete();
        $requested_record->delete();
        if (config('grace.mode') === 'api') {
            return JsonResponse::successResponse([
                'Default Record' => $requested_record,
                'translations' => $translations,
            ], 'The record has been recycled successfully', 200);
        } else if (config('grace.mode') === 'blade') {
            return redirect()->route('grace.' . $table_name. '.index');
        }
    }
}
