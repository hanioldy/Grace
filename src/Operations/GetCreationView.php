<?php

namespace Hani221b\Grace\Operations;

class GetCreationView
{
    /**
     * This function retuns a view in which we create a multi-language record.
     * @param array $table_name
     */

    public static function create($table_name)
    {
        return view(config('grace.views_folder_name'). '.' . $table_name . '.create');
    }
}
