<?php

namespace Hani221b\Grace\Support;

use Hani221b\Grace\Support\Str;
use ReflectionMethod;
use ReflectionClass;

class Core
{
    /**
     * Combine fields names and files fileds value to return files fillable array
     * @return string
     */
    public static function filesFillableArray($field_names, $files_fields): string
    {
        $files_fillable_array = [];
        if ($field_names !== null && $files_fields !== null) {
            $files_array = array_combine($field_names, $files_fields);
            foreach ($files_array as $field_name => $file_filed) {
                if ($file_filed === '1') {
                    array_push($files_fillable_array, $field_name);
                }
            }
        }
        return implode(",", $files_fillable_array);
    }


    /**
     * Mapping the value of field names and filter files fields
     * @return string
     */

    public static function fillableArray($field_names, $files_fields): string
    {
        $fillable_array = [];
        $all_fields = array_combine($field_names, $files_fields);
        foreach ($all_fields as $name => $value) {
            if ($value === "0") {
                array_push($fillable_array, $name);
            }
        }
        return "'" . str_replace(",", "', '", implode(",", $fillable_array)) . "'";
    }

    /**
     * Map the values of isFile checkbox
     * @param \Illuminate\Http\Request
     * @return array
     */
    public static function isFileValues($request): array
    {
        $files_fields = $request->isFile;
        if ($files_fields !== null) {
            foreach ($files_fields as $key => $value) {
                if ($value === '1') {
                    unset($files_fields[$key + 1]);
                }
            }
        }
        return $files_fields;
    }

    /**
     * Searching a class for a method an returns its code as string
     * @param $class
     * @param $method
     * @return string
     */

    public static function methodSource($class, $method): string
    {
        $func = new ReflectionMethod($class, $method);
        $filename = $func->getFileName();
        $start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;
        $source = file($filename);
        $body = implode("", array_slice($source, $start_line, $length));
        $source_code = Str::getBetween($body, "{\n", "}\n");
        return $source_code;
    }

    /**
     * Searching a class for a method an returns its code as string
     * @param $class
     * @param $method
     * @return string
     */

    public static function getClassSourceCode($class): string
    {
        $func = new ReflectionClass($class);
        $filename = $func->getFileName();
        $start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;
        $source = file($filename);
        $body = implode("", array_slice($source, $start_line, $length));
        $source_code = Str::getBetween($body, "{", "// The end of the class [DO NOT REMOVE THIS COMMENT]");
        return $source_code;
    }
}
