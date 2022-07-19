<?php

namespace Hani221b\Grace\Controllers;

use App\Models\Language;

class DashboardController
{
    public function grace_cp()
    {
        return view('Grace::index');
    }

    /**
     * get user dashboard
     */

     public function get_dashboard(){
         return view('grace.dashboard');
     }

    /**
     * get all languages
     */

     public function get_languages(){
         $languages = Language::Selection()->get();
         return view('grace.languages.index', compact('languages'));
     }

}
