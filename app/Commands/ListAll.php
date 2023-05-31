<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ListAll extends BaseCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'gh:list';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List all gh configurations';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkBase();
        $db = $this->getDb();

        dump('You are currently using: ' . $db['current'] . ' gh configureations.');
        dump('Available gh configurations:');

        foreach ($db['markers'] as $marker) {
            dump(' -' . $marker);
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
