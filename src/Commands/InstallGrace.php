<?php

namespace Hani221b\Grace\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
class InstallGrace extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grace:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Regitser grace route file in route service provider
     */

    public function register_route_file()
    {
        $web_registeration = "Route::middleware('web')
        ->group(base_path('routes/web.php'));";
        $grace_web_registeration = "            Route::middleware('web')
        ->group(base_path('routes/web.php'));

    Route::middleware('web')
        ->prefix('dashboard')
        ->group(base_path('routes/grace.php'));";

        $route_service_provider = file_get_contents('app\Providers\RouteServiceProvider.php');

        $route_service_provider = str_replace($web_registeration, $grace_web_registeration, $route_service_provider);

        file_put_contents('app\Providers\RouteServiceProvider.php', $route_service_provider);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // publish stuff
        Artisan::call('vendor:publish', ['--tag' => 'grace']);
        $this->line('<fg=green> Publishing stuff:</>
        <fg=blue> Config files </>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Config\grace.php <fg=yellow>]</> =><fg=yellow>[</>config\grace.php<fg=yellow>]</></>
        <fg=blue> Migration files </>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Database\Migrations\2022_06_23_053830_create_languages_table.php<fg=yellow>]</>
        => <fg=yellow>[</>database\migrations\2022_06_23_053830_create_languages_table.php<fg=yellow>]</></>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Database\Migrations\2022_07_18_045909_create_tables_table.php<fg=yellow>]</>
        => <fg=yellow>[</>database\migrations\2022_07_18_045909_create_tables_table.php<fg=yellow>]</></>
        <fg=blue> Views files </>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Views\Grace <fg=yellow>]</> =><fg=yellow>[</>resources\views\grace<fg=yellow>]</></>
        <fg=blue> Assets files </>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Assets <fg=yellow>]</> =><fg=yellow>[</>public\grace<fg=yellow>]</></>
        <fg=blue> Models </>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Models\Language.php <fg=yellow>]</> =><fg=yellow>[</>app\Models\Language.php<fg=yellow>]</></>
        <fg=blue> Routes </>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Routes\grace.php <fg=yellow>]</> =><fg=yellow>[</>routes\grace.php<fg=yellow>]</></>
      ');
        //register route file
        $this->register_route_file();
        $this->line('<fg=blue>Adding route file registration to RouteServiceProvider</>
        ');
        // run migrate
        Artisan::call('migrate');
        $this->info("<fg=yellow>Migrating: </> <fg=white>2022_06_23_053830_create_languages_table.php</>");
        $this->info("<fg=green>Migrated: </> <fg=white>2022_06_23_053830_create_languages_table.php</>");
    }
}
