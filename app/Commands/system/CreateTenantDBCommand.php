<?php namespace App\Commands\system;

use App\Commands\Command;
use App\Persistence\Interfaces\System\TenantRepoInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Config;

class CreateTenantDBCommand extends Command implements SelfHandling
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
        //create database
        if(! $this->createDatabase())
            return false;

        if(! $this->runMigrations()) {
            $this->rollback();
            return false;
        }

        if(! $this->seedData()) {
            $this->rollback();
            return false;
        }

        //if all goes well send email with credentials to admin
        if(! $this->sendEmailToAdmin()) {
            $this->rollback();
            return false;
        }

        return true;

    }

    /**
     * @return bool
     */
    protected function createDatabase() {

        $response = DB::select("show databases like '{$this->database}'");
        if (! count($response) ) {
            try {
                $response = DB::statement("CREATE DATABASE {$this->database}");
                return true;

            } catch (Exeption $e) {
                $this->rollback['create_db'] = true;
                Log::error("CREATE DATABASE ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant['id']}'/n
                 -message = " . $e->getMessage());
                return false;
            }
        }
        else {
            $this->rollback['create_db'] = true;
            Log::error("CREATE DATABASE ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant['id']}'/n
                 -message = 'db name already exists'");
            return false;
        }

    }

    /**
     * @return bool
     */
    protected function runMigrations() {
        Config::set('database.connections.mysql_tenant.database', $this->database);

        try {
            Artisan::call('migrate', ['--path' => 'database/migrations/tenant', '--database' => 'mysql_tenant']);
        } catch (Exeption $e) {
            $this->rollback['run_migrations'] = true;
            Log::error("rRUN MIGRATIONS ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant['id']}'/n
                 -message = " . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function seedData() {
        //set db connection
        Config::set('database.connections.mysql_tenant.database', $this->database);

        //set administrator credentials
        $name = $this->tenant['admin_name'];
        $emai = $this->tenant['admin_email'];
        $password = uniqid();

        try {
            $response = DB::connection('mysql_tenant')->table('users')->insert([
                'name' => $name,
                'email' => $emai,
                'password' => $password,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
            DB::reconnect('mysql');
            DB::setDefaultConnection('mysql');
            return $response;

        } catch (Exeption $e) {
            $this->rollback['seed_data'] = true;
            Log::error("SET ADMIN CREDENTIALS ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant['id']}'/n
                 -message = " . $e->getMessage());
            return false;
        }

        return true;
    }

    protected function sendEmailToAdmin() {

        try {
            Mail::raw('Text to e-mail', function ($message) {
                $message->from('us@example.com', 'Laravel');

                $message->to('foo@example.com')->cc('bar@example.com');
            });
        } catch (Exeption $e) {
            $this->rollback['send_email'] = true;
            Log::error("SEND EMAIL ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant['id']}'/n
                 -message = " . $e->getMessage());
            return false;
        }

        return true;

    }

    protected function rollback() {

        if($this->rollback['send_email']) {

        }

        if($this->rollback['create_db']) {
            DB::statement("DROP DATABASE {$this->database}");
        }

    }
}
