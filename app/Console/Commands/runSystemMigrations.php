<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class runSystemMigrations extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs system migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        Artisan::call('migrate', ['--path' => 'database/migrations/system', '--database' => 'mysql']);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
//            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
//            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
