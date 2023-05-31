<?php

namespace App\Commands;

use App\Services\Directories;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Mark extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'gh:mark {marker}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Mark the current gh config with a name';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkBase();
        $db = $this->getDb();

        $marker = $this->argument('marker');

        $sourceFile = $this->directories->getGhConfigDir() . DIRECTORY_SEPARATOR . 'hosts.yml';
        $targetFile = $this->directories->getBaseDir() . DIRECTORY_SEPARATOR . 'hosts_' . $marker . '.yml';

        copy($sourceFile, $targetFile);
        array_push($db['markers'], $marker);
        $db['current'] = $marker;

        $this->files->writeInFile(json_encode($db));

        dump('New gh marker created: ' . $marker);
        dump('You are currently using: ' . $db['current'] . ' gh configureations.');
    }

    /**
     * Define the command's schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
