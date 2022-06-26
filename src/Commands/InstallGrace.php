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
        <fg=green><fg=yellow>[</>Hani221b\Grace\Config\grace.php <fg=yellow>]</> =><fg=yellow>[</>config.grace.php<fg=yellow>]</></>
        <fg=blue> Migration files </>
        <fg=green><fg=yellow>[</>Hani221b\Grace\Database\Migrations\2022_06_23_053830_create_languages_table.php<fg=yellow>]</>
        => <fg=yellow>[</>database\migrations\2022_06_23_053830_create_languages_table.php<fg=yellow>]</></>
      ');
        // run migrate
        Artisan::call('migrate');
        $this->info("<fg=yellow>Migrating: </> <fg=white>2022_06_23_053830_create_languages_table.php</>");
        $this->info("<fg=green>Migrated: </> <fg=white>2022_06_23_053830_create_languages_table.php</>");
    }
}
