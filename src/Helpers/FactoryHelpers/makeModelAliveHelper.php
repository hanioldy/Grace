<?php

namespace Hani221b\Grace\Helpers\FactoryHelpers;

class makeModelAliveHelper
{
    /**
     * looping through an array of files fields and return mutators template
     * @param array stubVariables
     * @return string
     */
    public static function appendMutatorToModel($stubVariables)
    {
        $template = array();
        $table_name = $stubVariables['table_name'];
        $files_fileds = $stubVariables['files_fields'];
        $files_array = explode(',', $files_fileds);
        foreach ($files_array as $value) {
            $mutators_names = "get" . ucwords($value) . "Attribute";

    $mutator_template = "public function $mutators_names(\$value)
    {
        return (\$value !== null) ? asset('/storage/'. config('grace.storage_path') . '/$table_name/' . \$value) : '';
    }
    ";
            array_push($template, $mutator_template);
        }

        $string_mutators_template = '';
        foreach ($template as $index => $tem) {
            $string_mutators_template .= $template[$index] . "\n";

        }
        return $string_mutators_template;
    }
}
