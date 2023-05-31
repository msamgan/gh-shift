<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Shift extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'gh:shift {marker}';
    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Shift to a different gh configuration';

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

        if (!in_array($marker, $db['markers'])) {
            dump('Marker not found.');
            return;
        }

        $sourceFile = $this->directories->getBaseDir() . DIRECTORY_SEPARATOR . 'hosts_' . $marker . '.yml';
        $targetFile = $this->directories->getGhConfigDir() . DIRECTORY_SEPARATOR . 'hosts.yml';

        copy($sourceFile, $targetFile);
        $db['current'] = $marker;

        $this->files->writeInFile(json_encode($db));

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
