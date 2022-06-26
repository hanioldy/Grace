<?php

namespace Hani221b\Grace\Helpers;

// use App\Models\Central\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class GlobalHelper extends Facade
{

    //=========================================
    // Function to get application default
    // language.
    //=========================================

    public static function GetDefaultLanguage()
    {
        return Config::get('app.locale');
    }

    //=========================================
    // Function to get all activated languages
    // in the application.
    //=========================================

    // public static function GetActivatedLanguage()
    // {
    //     return Language::Selection()->where('status', 1)->get();
    // }

    //=========================================
    // Get current tenant storage folder name
    //=========================================

    public static function CurrentTenantId()
    {

        if (str_contains($_SERVER['SERVER_NAME'], 'almotkamel')) {
            // get tenant id in production
            $tenant_name = Str::before($_SERVER['SERVER_NAME'], '.almotkamel.com');
            // get tenant id in development environment
        } else if (str_contains($_SERVER['SERVER_NAME'], 'test')) {
            $tenant_name = Str::before($_SERVER['SERVER_NAME'], '.test');
        }

        $tenant_id = 'tenant_' . $tenant_name;
        return $tenant_id;
    }

    //=========================================
    // Constants
    //=========================================

    const PAGINATION_COUNT = 10;
}
