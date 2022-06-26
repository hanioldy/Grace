<?php

namespace Hani221b\Grace\Operations;

use Illuminate\Support\Str;

class GetEditingView
{
    /**
     * This function retuns a view in which we edit a multi-language record.
     * @param array $table_name
     */

    public static function edit($id, $table_name, $model_path)
    {
        $variable_name = Str::singular($table_name);
        $record = Str::singular($table_name);
        $record = $model_path::where('id', $id)->Selection()->first();
        return view(config('grace.views_folder_name') . '.' . $table_name . '.edit')->with([$variable_name => $record]);
    }
}
