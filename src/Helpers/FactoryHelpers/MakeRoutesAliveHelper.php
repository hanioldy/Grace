<?php

namespace Hani221b\Grace\Helpers\FactoryHelpers;

use Hani221b\Grace\Helpers\MakeStubsAliveHelper;

class MakeRoutesAliveHelper
{
    /**
     * returns the path of the requested route file
     * @return string
     */
    public static function getRouteFileName()
    {
        if (config('grace.mode') === 'api') {
            $filename = base_path() . '/routes/api.php';
        } else if (config('grace.mode') === 'blade') {
            $filename = base_path() . '/routes/grace.php';
        }
        return $filename;
    }

    /**
     * append use controller statement at the to of the route file
     * @param @stubVariables
     * @param @controller_name
     * @return void
     */
    public static function appendUseController($stubVariables = [], $controller_name)
    {
        $controller_namespace = $stubVariables['controller_namespace'];
        $table_name = $stubVariables['table_name'];
        $use_controller = "
/*<$table_name-controller>*/
use $controller_namespace\\$controller_name;
/*</$table_name-controller>*/
";
        $filename = self::getRouteFileName();
        $line_i_am_looking_for = 1;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = $use_controller;
        file_put_contents($filename, implode("\n", $lines));
    }
    /**
     * append resource routes for a certain table
     * @param $stubVariables
     * @return void
     */

    public static function appendRoutes($stubVariables = [])
    {
        $routes_file = self::getRouteFileName();
        $opened_file = fopen($routes_file, 'a');
        $controller_name = MakeStubsAliveHelper::getSingularClassName($stubVariables['table_name']) . "Controller";
        $table_name = $stubVariables['table_name'];
        $routes_template = "
/*<$table_name-routes>*/
Route::resource('$table_name', $controller_name::class, ['as' => 'grace']);
/*</$table_name-routes>*/
";

        self::appendUseController($stubVariables, $controller_name);
        fwrite($opened_file, $routes_template);
        fclose($opened_file);
    }
}
