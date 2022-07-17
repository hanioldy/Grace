<?php

namespace Hani221b\Grace\Helpers\FactoryHelpers;

class MakeDiskAliveHelper
{
    public static function appendDisk($stubVariables = [])
    {
        $table_name = $stubVariables['table_name'];
        // $storage_path = $stubVariables['storage_path'];
        $disk = "
            //=========================================================================
            // $table_name disk. You can change the path of its files here
            //=========================================================================

            '$table_name' => [
                'driver' => 'local',
                'root' => public_path() . '/grace/storage/$table_name' ,
                'url' => env('APP_URL') . '/',
                'visibility' => 'public',
            ],";

        $filename = base_path() . '\config\filesystems.php';
        $line_i_am_looking_for = 57;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = "\n" . $disk;
        file_put_contents($filename, implode("\n", $lines));
        return false;
    }
}
