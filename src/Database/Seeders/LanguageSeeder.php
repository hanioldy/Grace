<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            [
                'abbr' => 'en',
                'name' => 'English',
                'direction' => 1,
                'status' => 1,
                'default' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ar',
                'name' => 'Arabic',
                'direction' => 0,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'bs',
                'name' => 'Bosnian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'bg',
                'name' => 'Bulgarian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ca',
                'name' => 'Catalan',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ca',
                'name' => 'Catalan',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'cs',
                'name' => 'Czech',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'da',
                'name' => 'Danish',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'de',
                'name' => 'German',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'el',
                'name' => 'Greek',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'et',
                'name' => 'Estonian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'fi',
                'name' => 'Finnish',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'fr',
                'name' => 'French',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'he',
                'name' => 'Hebrew',
                'direction' => 0,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'hi',
                'name' => 'Hindi',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'hu',
                'name' => 'Hungarian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'id',
                'name' => 'Indonesian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'it',
                'name' => 'Italian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ja',
                'name' => 'Japanese',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'kk',
                'name' => 'Kazakh',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ko',
                'name' => 'Korean',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'lt',
                'name' => 'Lithuanian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'lv',
                'name' => 'Latvian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'mg',
                'name' => 'Malagasy',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'mk',
                'name' => 'Macedonian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ms',
                'name' => 'Malay',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'nb',
                'name' => 'Norwegian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'nl',
                'name' => 'Dutch',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'fa',
                'name' => 'Persian',
                'direction' => 0,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'pl',
                'name' => 'Polish ',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'pt',
                'name' => 'Portuguese',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ro',
                'name' => 'Romanian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ru',
                'name' => 'Russian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'zh',
                'name' => 'Chinese',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'sr',
                'name' => 'Serbian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'sk',
                'name' => 'Slovak',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'es',
                'name' => 'Spanish',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'sv',
                'name' => 'Swedish',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'tl',
                'name' => 'Tagalog',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'th',
                'name' => 'Thai',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'tr',
                'name' => 'Turkish',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'uk',
                'name' => 'Ukrainian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'vi',
                'name' => 'Vietnamese',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'af',
                'name' => 'Afrikaans',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'az',
                'name' => 'Azerbaijani',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'bn',
                'name' => 'Bengali',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'cy',
                'name' => 'Welsh',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'hy',
                'name' => 'Armenian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ka',
                'name' => 'Georgian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ku',
                'name' => 'Kurdish',
                'direction' => 0,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ka',
                'name' => 'Georgian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'mn',
                'name' => 'Mongolian',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'abbr' => 'ne',
                'name' => 'Nepali',
                'direction' => 1,
                'status' => 0,
                'default' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}