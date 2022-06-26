<?php

namespace Hani221b\Grace\Helpers;

use Illuminate\Support\Str;

class FileHelper
{

    //=========================================
    // Function to upload files.
    //=========================================
    public static function UploadFile($folder, $file)
    {
        // return var_dump($file);
        $file->store('/', $folder);
        $filename = $file->hashName();
        $path = $filename;
        return $path;
    }

    //=========================================
    // Function to unlink files.
    //=========================================

    public static function UnlinkFile($file_from_request)
    {
        $file = Str::after($file_from_request, asset(''));
        $file_to_be_unlinked = base_path($file);
        if (file_exists($file_to_be_unlinked)) {
            unlink($file_to_be_unlinked);
        }
    }

    //=========================================
    // Check key exist.
    //=========================================

    // public static function CheckKeyExists($key,
    //     $array,
    //     $disk = null,
    //     $file_from_request = null,
    //     $unlink_file_from_request = null,
    //     $file_path = null,
    //     $fillable_array = null,
    //     $array_to_be_merged = null
    // ) {
    //     if (in_array($key, $array)) {
    //         $file_path = FileHelper::UploadFile($disk, $file_from_request);
    //         FileHelper::UnlinkFile($unlink_file_from_request, $file_path);
    //         $fillable_array = array_merge($array_to_be_merged, [
    //             $key => $file_path,
    //         ]);
    //     }
    // }

    // public static function CheckKeyExists(
    //     $files_fillable_values,
    //     $disk = null,
    //     $collection_array = null,
    //     $unlink_collection = null
    // ) {
    //     $file_array = [];
    //     if (in_array('file', $files_fillable_values)) {
    //         if (isset($unlink_collection)) {
    //             FileHelper::UnlinkFile($unlink_collection['file']);
    //         }
    //         $path = FileHelper::UploadFile($disk, $collection_array['file']);
    //         $file_array = array_merge($file_array, ['file' => $path]);
    //     }
    //     if (in_array('image', $files_fillable_values)) {
    //         if (isset($unlink_collection)) {
    //             FileHelper::UnlinkFile($unlink_collection['image']);
    //         }
    //         $path = FileHelper::UploadFile($disk, $collection_array['image']);
    //         $file_array = array_merge($file_array, ['image' => $path]);
    //     }
    //     if (in_array('icon', $files_fillable_values)) {
    //         if (isset($unlink_collection)) {
    //             FileHelper::UnlinkFile($unlink_collection['icon']);
    //         }
    //         $path = FileHelper::UploadFile($disk, $collection_array['icon']);
    //         $file_array = array_merge($file_array, ['icon' => $path]);
    //     }

    //     if (!in_array('file', $files_fillable_values)
    //         && in_array('image', $files_fillable_values)
    //         && in_array('icon', $files_fillable_values)) {
    //         // return empty array if no file was passed
    //         return $file_array = [];
    //     } else {
    //         return $file_array;
    //     }

    // }

    public static function CheckKeyExists(
        $files_fillable_values,
        $disk = null,
        $collection_array = null,
        $unlink_collection = null
    ) {
        $file_array = [];
        $files_fillable_values = array_values($files_fillable_values);
        foreach ($files_fillable_values as $fillable_value) {
            if (in_array($fillable_value, $files_fillable_values)) {
                if (isset($unlink_collection)) {
                    FileHelper::UnlinkFile($unlink_collection[$fillable_value]);
                }
                $path = FileHelper::UploadFile($disk, $collection_array[$fillable_value]);
                $file_array = array_merge($file_array, [$fillable_value => $path]);
                return $file_array;
            } else {
                return $file_array = [];
            }
        }
    }

    //=========================================
    // Unlink files when delete record.
    //=========================================

    // public static function UnlinkWhenDelete($files_fillable_values, $unlink_collection)
    // {
    //     if (in_array('file', $files_fillable_values)) {
    //         FileHelper::UnlinkFile($unlink_collection['file']);
    //     } else if (in_array('image', $files_fillable_values)) {
    //         FileHelper::UnlinkFile($unlink_collection['image']);
    //     } else if (in_array('icon', $files_fillable_values)) {
    //         FileHelper::UnlinkFile($unlink_collection['icon']);
    //     }
    // }

    public static function UnlinkWhenDelete($files_fillable_values, $unlink_collection)
    {
        $files_fillable_values = array_values($files_fillable_values);
        foreach ($files_fillable_values as $fillable_value) {
            if (in_array($fillable_value, $files_fillable_values)) {
                FileHelper::UnlinkFile($unlink_collection[$fillable_value]);
            }
        }
    }
}
