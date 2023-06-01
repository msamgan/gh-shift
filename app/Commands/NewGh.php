<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class NewGh extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'gh:new {marker}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new gh configuration, with provided marker';

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

        if (in_array($marker, $db['markers'])) {
            dump('Marker already exists.');
            return;
        }

        if ($db['current'] === $marker) {
            dump('You are already using this marker.');
            return;
        }

        if ($db['current'] === null) {
            dump('You are currently not using any marker, please use gh:mark mark the current configuration.');
            return;
        }

        $this->files->removeFile($this->directories->getGhConfigDir() . DIRECTORY_SEPARATOR . 'hosts.yml');
        shell_exec('gh auth login');

        $sourceFile = $this->directories->getGhConfigDir() . DIRECTORY_SEPARATOR . 'hosts.yml';
        $targetFile = $this->directories->getBaseDir() . DIRECTORY_SEPARATOR . 'hosts_' . $marker . '.yml';
        copy($sourceFile, $targetFile);

        array_push($db['markers'], $marker);
        $db['current'] = $marker;

        $this->files->writeInFile(json_encode($db));
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
