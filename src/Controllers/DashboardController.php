<?php

namespace Hani221b\Grace\Controllers;

use App\Models\Language;
use Exception;
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
            return view('grace.tables.index', compact('tables'));
        } catch (Exception $exception) {
            return 'something went wrong. please try again later';
        }
    }

}
