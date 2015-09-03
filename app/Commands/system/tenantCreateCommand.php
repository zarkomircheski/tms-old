<?php namespace App\Commands\system;

use App\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Config;

class tenantCreateCommand extends Command implements SelfHandling
{
    public $tenant;
    public $database;
    protected $rollback = [
        'create_db'         => false,
        'run_migrations'    => false,
        'seed_data'         => false,
        'send_email'        => false,
    ];
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($tenant)
    {
        $this->tenant = $tenant;
        $this->database = $tenant->subdomain;
    }

    /**
     * Execute the command.
     *
     * @return void
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
                $this->rollback['create_db'] = true;
                return true;

            } catch (Exeption $e) {
                Log::error("CREATE DATABASE ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant->id}'/n
                 -message = " . $e->getMessage());
                return false;
            }
        }
        else {
            Log::error("CREATE DATABASE ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant->id}'/n
                 -message = 'db name already exists'");
            return false;
        }

    }

    /**
     *
     */
    protected function runMigrations() {
        Config::set('database.connections.mysql_tenant.database', $this->database);

        try {
            Artisan::call('migrate', ['--path' => 'database/migrations/tenant', '--database' => 'mysql_tenant']);
        } catch (Exeption $e) {
            Log::error("rRUN MIGRATIONS ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant->id}'/n
                 -message = " . $e->getMessage());
            return false;
        }
        $this->rollback['run_migrations'] = true;
        return true;
    }

    protected function seedData() {
        //set db connection
        Config::set('database.connections.mysql_tenant.database', $this->database);

        //set administrator credentials
        $name = $this->tenant->admin_name;
        $emai = $this->tenant->admin_email;
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
            Log::error("SET ADMIN CREDENTIALS ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant->id}'/n
                 -message = " . $e->getMessage());
            return false;
        }

        $this->rollback['seed_data'] = true;
        return true;
    }

    protected function sendEmailToAdmin() {

        try {
            Mail::raw('Text to e-mail', function ($message) {
                $message->from('us@example.com', 'Laravel');

                $message->to('foo@example.com')->cc('bar@example.com');
            });
        } catch (Exeption $e) {
            Log::error("SEND EMAIL ATTEMPT:/n
                 -db_name = '{$this->database}'/n
                 -tenant_id = '{$this->tenant->id}'/n
                 -message = " . $e->getMessage());
            return false;
        }

        $this->rollback['send_email'] = true;
        return true;

    }

    protected function rollback() {

        if($this->rollback['send_email']) {

        }

//        if($this->rollback['seed_data']) {
//            Config::set('database.connections.mysql_tenant.database', $this->database);
//            $response = DB::connection('mysql_tenant')->table('users')->where('email', $this->tenant->email)->delete();
//        }
//
//        if($this->rollback['run_migrations']) {
//            Config::set('database.connections.mysql_tenant.database', $this->database);
//            Artisan::call('migrate', ['--force', '--database' => 'mysql_tenant']);
//
//        }

        if($this->rollback['create_db']) {
            DB::statement("DROP DATABASE {$this->database}");
        }

    }
}
