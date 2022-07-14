<?php

namespace Hani221b\Grace\Helpers\ViewsHelpers;

class MakeEditViewHelper
{

    /**
     * Return the stub file path
     * @return string
     *
     */
    public static function getStubPath()
    {
        return __DIR__ . "/../../Stubs/views/edit.stub";
    }

    /**
     **
     * Make create view for blade mode
     *
     * @return array
     *
     */
    public static function makeCreate($folder_name, $stubVariables)
    {
        $field_names = $stubVariables['field_names'];
        $inputs_types = $stubVariables['input_types'];
        $names_types_array = array_combine($field_names, $inputs_types);
        $template = array();
        foreach ($names_types_array as $field => $value) {
            switch ($value) {
                case 'text':
                    $input_template = self::input($folder_name, $field);
                    break;

                case 'file':
                    $input_template = self::file($folder_name, $field);
                    break;

                case 'textarea':
                    $input_template = self::textarea($folder_name, $field);
                    break;
            }
            array_push($template, $input_template);
        }

        $string_input_template = '';
        foreach ($template as $index => $tem) {
            $string_input_template .= $template[$index] . "\n";
        }

        $contents = file_get_contents(self::getStubPath());

        $contents = str_replace('{{ inputs }}', $string_input_template, $contents);
        // dd($contents);
        foreach ($stubVariables as $search => $replace) {

            if (!is_array($replace)) {
                $contents = str_replace('{{ ' . $search . ' }}', $replace, $contents);
            }
        }
        $path = base_path() . '\\resources\\views\\' . config('grace.views_folder_name') . '\\' . $folder_name;
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        $file_name = $path . '\\edit.blade.php';
        file_put_contents($file_name, $contents);
    }

    /**
     * defining text input template
     * @param String $key
     * @return String
     */

    public static function input($key, $field)
    {
        $title = ucfirst($field);
        return "<div class='form-group'>
        <label for='{$field}'>
        <h5>{$title}</h5>
        </label>
        <input type='text' class='form-control input-default' value='{{ $$key->$field }}' name='{$field}'>
        </div>";
    }

    /**
     * defining textarea input template
     * @param String $key
     * @return String
     */

    public static function textarea($key, $field)
    {
        $title = ucfirst($field);
        return "<div class='form-group'>
        <label for='{$field}'>
            <h5>{$title}</h5>
        </label>
        <textarea class='form-control summernote' name='{$field}'>{{ $$key->$field }}</textarea>
        </div>";
    }

    /**
     * defining file input template
     * @param String $key
     * @return String
     */

    public static function file($key, $field)
    {
        $title = ucfirst($key);
        return "<div class='form-group'>
        <label for='{$field}'>
            <h5>{$title}</h5>
        </label>
        <img src='{{ $$key->$field }}'  width='200px'>
        <input type='file' class='form-control' name='{$field}'>
        </div>";

    }
}
