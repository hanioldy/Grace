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
    public static function filesFillableArray($files_fields): string
    {
        if ($files_fields !== null) {
            return implode(",", $files_fields);
        } else {
            return '';
        }
    }


    /**
     * Mapping the value of field names and filter files fields
     * @return string
     */

    public static function fillableArray($field_names, $files_fields): string
    {
       $fillable_array =  array_filter($field_names, function($field_name) use ($files_fields){
            return !in_array($field_name, $files_fields);
        });
        return "'" . str_replace(",", "', '", implode(",", $fillable_array)) . "'";
    }

    /**
     * Map the values of isFile checkbox
     * @param \Illuminate\Http\Request
     * @return array
     */
    public static function isFileValues($field_names, $input_types): array
    {
        $types = [];
        $files_fields = [];
        foreach($input_types as $index => $type){
            if($index % 2 !== 0){
                array_push($types, $type);
            }
        }
        foreach($types as $index => $type){
            if($type === 'file'){
                array_push($files_fields, $field_names[$index] );
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
