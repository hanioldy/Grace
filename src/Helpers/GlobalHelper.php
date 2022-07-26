<?php

namespace Hani221b\Grace\Helpers;

use App\Models\Language;
use Illuminate\Support\Facades\Facade;

class GlobalHelper extends Facade
{

    //=========================================
    // Function to get application default
    // language.
    //=========================================

    public static function GetDefaultLanguage()
    {
        $default_language = Language::where('default', 1)->select('abbr')->first();
        return $default_language->abbr;
    }

    //=========================================
    // Function to get all activated languages
    // in the application.
    //=========================================

    public static function GetActivatedLanguage()
    {
        return Language::Selection()->where('status', 1)->get();
    }

}
