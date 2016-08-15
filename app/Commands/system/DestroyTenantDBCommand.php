<?php namespace App\Commands\system;

use App\Commands\Command;
use App\Persistence\Interfaces\System\TenantRepoInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Config;

class DestroyTenantDBCommand extends Command implements SelfHandling
{
    protected $tenantId;
    protected $database;
    protected $rollback = [
        'create_db'         => false,
        'run_migrations'    => false,
        'seed_data'         => false,
        'send_email'        => false,
    ];
    private $tenant;

    /**
     * Create a new command instance.
     *
     * @param array $tenant
     */
    public function __construct(array $tenant)
    {
        $this->tenant = $tenant;
        $this->database = $tenant['subdomain'];
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle()
    {
        if(! $this->dropDatabase())
            return false;

        return true;

    }

    /**
     * @return bool
     */
    protected function dropDatabase() {

        $response = DB::select("show databases like '{$this->database}'");
        if (count($response) ) {
            DB::statement("DROP DATABASE {$this->database}");
            return true;
        }
        else {
            $this->rollback['create_db'] = true;
            Log::error("DROP DATABASE ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant['id']}'/n
                 -message = 'db name does not exists'");
            return false;
        }

    }

}
