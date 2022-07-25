<?php

namespace Hani221b\Grace\Controllers;

use App\Models\Language;
use App\Models\Table;
use Exception;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Support\Facades\DB;

class DashboardController
{
    public function grace_cp()
    {
        return view('Grace::index');
    }

    /**
     * get user dashboard
     */

    public function get_dashboard()
    {
        return view('grace.dashboard');
    }

    /**
     * get all languages
     */

    public function get_languages()
    {
        try {
            $languages = Language::Selection()->get();
            return view('grace.languages.index', compact('languages'));
        } catch (Exception $exception) {
            return 'something went wrong. please try again later';
        }
    }

    /**
     * make a language active of inactive
     */

    public function change_status_for_language($id)
    {
        try {
            $language = Language::where('id', $id)->select('id', 'status')->first();
            $status = $language->status == 0 ? 1 : 0;
            //update the status with the new value
            $language->update(['status' => $status]);
            return \redirect()->back();
        } catch (Exception $exception) {
            return $exception;
            return 'something went wrong. please try again later';
        }
    }

    /**
     * override system config and change default language
     */

    public function set_language_to_default($id)
    {
        try {
            // setting default langauge back to non default
            $default_language = Language::where('default', 1)->select('id', 'default')->first();
            $default_language->update(['default' => 0]);
            // setting new default language
            $language = Language::where('id', $id)->select('id', 'default')->first();
            $language->update(['default' => 1]);
            return \redirect()->back();
        } catch (Exception $exception) {
            return $exception;
            return 'something went wrong. please try again later';
        }
    }

    /**
     * get all tables
     */

    public function get_tables()
    {
        try {
            $tables = DB::table('tables')->get();
            return view('Grace::includes.tables', compact('tables'));
        } catch (Exception $exception) {
            return 'something went wrong. please try again later';
        }
    }

    /**
     * delete table with all its files and classes
     */
    public function delete_table($id)
    {
        $table = Table::where('id', $id)->first();
        $controller = base_path() . '\\' . $table->controller . '.php';
        $model = base_path() . '\\' . $table->model . '.php';
        $request = base_path() . '\\' . $table->request . '.php';
        $resource = base_path() . '\\' . $table->resource . '.php';
        $migration = base_path() . '\\' . $table->migration . '.php';
        $views = base_path() . '\\' . $table->views . '.php';
        if (file_exists($controller)) {
            unlink($controller);
        }
        if (file_exists($model)) {
            unlink($model);
        }
        if (file_exists($request)) {
            unlink($request);
        }
        if (file_exists($resource)) {
            unlink($resource);
        }
        if (file_exists($migration)) {
            unlink($migration);
        }
        if (file_exists($views)) {
            unlink($views);
        }
        // removing route
        $route_start = "//========================= $table->table_name routes =========================";
        $route_end = "//================================================================";
        $route_file_name = base_path() . '\routes\grace.php';
        $route_file = file_get_contents($route_file_name);
        $route = MakeStubsAliveHelper::getStringBetween($route_file, $route_start, $route_end);
        $full_route = $route_start . $route . $route_end;
        $new_route_file = str_replace($full_route, '', $route_file);
        file_put_contents($route_file_name, $new_route_file);

        //remove route controlle use statement

        $use_statement_start = "//======== $table->table_name controller ===========";
        $use_statement_end = "//======================================";
        $use_statement = MakeStubsAliveHelper::getStringBetween($route_file, $use_statement_start, $use_statement_end);
        $full_use_statement = $use_statement_start . $use_statement . $use_statement_end;
        $new_route_file = str_replace($full_use_statement, '', $new_route_file);
        file_put_contents($route_file_name, $new_route_file);
    }

}
