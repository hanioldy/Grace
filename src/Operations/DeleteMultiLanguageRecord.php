<?php

namespace Hani221b\Grace\Operations;

use Hani221b\Grace\Helpers\FileHelper;
use Hani221b\Grace\Helpers\JsonResponse;

class DeleteMultiLanguageRecord
{
    /**
     * this function delete multi language record and unlink its files.
     *
     * @param int $id
     * @param string $model_path
     * @return \Illuminate\Http\JsonResponse
     */

    public static function delete(
        $id,
        $model_path,
        $files_fillable_vales = null,
        $table_name,
    ) {
        //fetch the requested record
        $requested_record = $model_path::withTrashed()->find($id);
        //return false if requested was not found
        if (!$requested_record) {
            return JsonResponse::errorResponse('The requested record does not exist', 404);
        }
        $translations = $model_path::withTrashed()->where('translation_of', $requested_record->id)->get();
        // Unlink files from storage
        FileHelper::UnlinkWhenDelete($files_fillable_vales, $requested_record);
        foreach ($translations as $translation) {
            FileHelper::UnlinkWhenDelete($files_fillable_vales, $translation);
        }
        //delete translations
        $translations->each->forceDelete();
        //delete default record
        $requested_record->forceDelete();
        if (config('grace.mode') === 'api') {
            return JsonResponse::successResponse([
                'Default Record' => $requested_record,
                'Translations' => $translations,
            ], 'The record has been deleted successfully', 200);
        } else if (config('grace.mode') === 'blade') {
            return redirect('/' . $table_name);
        }
    }
}
